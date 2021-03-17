<?php

namespace Aislend\Alert\Cron;

class SendStockMails
{
    protected $_websites;
    protected $_scopeConfig;
    protected $_emailFactory;
    protected $_storeManager;
    protected $_guestCollection;
    protected $_dateFactory;

    protected $productRepository;
    protected $_errors = [];

    const XML_PATH_STOCK_ALLOW = 'catalog/productalert/allow_stock';
    
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Aislend\Alert\Model\EmailFactory $emailFactory,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Aislend\Alert\Model\ResourceModel\GuestAlert\CollectionFactory $guestCollection
    ) 
    {
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_emailFactory = $emailFactory;
        $this->_dateFactory = $dateFactory;
        $this->productRepository = $productRepository;
        $this->_guestCollection = $guestCollection;
    }

    protected function _getWebsites()
    {
        if ($this->_websites === null) {
            try {
                $this->_websites = $this->_storeManager->getWebsites();
            } catch (\Exception $e) {
                $this->_errors[] = $e->getMessage();
            }
        }
        return $this->_websites;
    }

    public function guestprocess()
    {
        $email = $this->_emailFactory->create();
        foreach ($this->_getWebsites() as $website) {
            if (!$website->getDefaultGroup() || !$website->getDefaultGroup()->getDefaultStore()) {
                continue;
            }
            if (!$this->_scopeConfig->getValue(self::XML_PATH_STOCK_ALLOW, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $website->getDefaultGroup()->getDefaultStore()->getId())) {
                continue;
            }


            $collection = $this->_guestCollection->create()
                                    ->addFieldToFilter('website_id',$website->getId())
                                    ->addFieldToFilter('status',0)
                                    ->setEmailOrder();

            $sameCustomer = null;
            $email->setWebsite($website);
            foreach ($collection as $guest) {
                try {
                    if(!$sameCustomer || ($guest->getEmail() != $sameCustomer->getEmail())){    // new customer
                        if($sameCustomer){ //send mail to previous customer
                            $email->send();        
                        }

                        $sameCustomer = $guest;
                        $email->clean();
                        $email->setEmail($sameCustomer->getEmail());
                    }

                    $product = $this->productRepository->getById($guest->getProductId(), false, $website->getDefaultStore()->getId());
                    

                    if ($product->isSalable()) {
                        $email->addStockProduct($product);

                        $guest->setSendDate($this->_dateFactory->create()->gmtDate());
                        $guest->setSendCount($guest->getSendCount() + 1);
                        $guest->setStatus(0);
                        $guest->save();
                    }

                } catch (\Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }

            // send after forloop completes for last customer
            if ($sameCustomer) {
                try {
                    $email->send();
                } catch (\Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }
        }
        return $this;
    }
}
