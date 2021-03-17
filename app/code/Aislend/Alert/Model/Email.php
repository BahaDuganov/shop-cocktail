<?php

namespace Aislend\Alert\Model;

class Email extends \Magento\Framework\Model\AbstractModel
{

    const XML_PATH_EMAIL_STOCK_TEMPLATE = 'aislend/alert/email_stock_template';
    const XML_PATH_EMAIL_IDENTITY = 'aislend/alert/email_identity';

    protected $_website;
    protected $_email;
    protected $_scopeConfig;
    protected $_appEmulation;
    protected $_transportBuilder;
    protected $_stockProducts = [];
    protected $_stockBlock;
    protected $_productAlertData = null;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Aislend\Alert\Helper\Data $productAlertData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->_productAlertData = $productAlertData;
        $this->_appEmulation = $appEmulation;
        $this->_scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _getStockBlock()
    {
        if ($this->_stockBlock === null) {
            $this->_stockBlock = $this->_productAlertData->createBlock('Aislend\Alert\Block\Email\Stock');
        }
        return $this->_stockBlock;
    }

    public function setWebsite(\Magento\Store\Model\Website $website)
    {
        $this->_website = $website;
        return $this;
    }

    public function clean()
    {
        $this->_email = null;
        $this->_stockProducts = [];

        return $this;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function addStockProduct(\Magento\Catalog\Model\Product $product)
    {
        $this->_stockProducts[$product->getId()] = $product;
        return $this;
    }

    // send email to user
    public function send()
    {
        if ($this->_website === null || $this->_email === null) {
            return false;
        }
        if (!$this->_website->getDefaultGroup() || !$this->_website->getDefaultGroup()->getDefaultStore()) {
            return false;
        }

        if(count($this->_stockProducts) === 0){
            return false;
        }

        $store = $this->_website->getDefaultStore();
        $storeId = $store->getId();
        if(!$this->_scopeConfig->getValue(self::XML_PATH_EMAIL_STOCK_TEMPLATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE,$storeId)){
            return false;
        }


        $this->_appEmulation->startEnvironmentEmulation($storeId);

        try {
            $this->_getStockBlock()->setStore($store)->reset();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        $this->_getStockBlock()->setGuestEmail($this->_email);
    
        foreach ($this->_stockProducts as $product) {
            $this->_getStockBlock()->addProduct($product);
        }
        $block = $this->_getStockBlock();
        $templateId = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_STOCK_TEMPLATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);

        // create block
        $alertGrid = $this->_appState->emulateAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND, [$block, 'toHtml']);

        $this->_appEmulation->stopEnvironmentEmulation();

        // send mail
        $transport = $this->_transportBuilder
                                ->setTemplateIdentifier($templateId)
                                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $storeId])->setTemplateVars(
                                    [
                                    'alertGrid' => $alertGrid,
                                    ])
                                ->setFrom($this->_scopeConfig->getValue(self::XML_PATH_EMAIL_IDENTITY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId))
                                ->addTo($this->_email)
                                ->getTransport();

        $transport->sendMessage();
        return true;
    }
}