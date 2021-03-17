<?php

namespace Aislend\Alert\Controller\Add;

use Magento\Framework\Controller\ResultFactory;
use Aislend\Alert\Model\GuestAlertFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Guest extends \Magento\Framework\App\Action\Action
{
	protected $_customerFactory;
	protected $_guestalert;
	protected $_productRepository;

    public function __construct(\Magento\Framework\App\Action\Context $context,
    	\Magento\Customer\Model\CustomerFactory $customerFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		GuestAlertFactory $guestalert,
		ProductRepositoryInterface $productRepository
	)
    {
    	$this->_customerFactory = $customerFactory;
    	$this->_storeManager = $storeManager;
    	$this->_guestalert = $guestalert;
    	$this->_productRepository = $productRepository;

        parent::__construct($context);
    }

	public function execute()
	{
		$result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
		$respArr = array();

		$store_id = $this->_storeManager->getStore()->getId();
		$websiteId = $this->_storeManager->getStore($store_id)->getWebsiteId();

		$pararms = $this->getRequest()->getParams();
		$email = $pararms['email'];
		$prod_id = $pararms['product_id'];

		$product = $this->_productRepository->getById($prod_id);

        try {
			if($product_id = $product->getId()){
				// insert normally if email is a logged in user 
				$customer = $this->_customerFactory->create()->setWebsiteId($websiteId)->loadByEmail($email);
				if($customer->getId()){
	                $model = $this->_objectManager->create('Magento\ProductAlert\Model\Stock')
	                    ->setCustomerId($customer->getId())
	                    ->setProductId($product_id)
	                    ->setWebsiteId($websiteId);
	                $model->save();

		            $response = 1;
		            $message = 'You will be notified on '.$customer->getEmail().' when this product is back in stock';
				} else{
			        $guestalertCollection = $this->_guestalert->create()->getCollection()
			                            ->addFieldToFilter('email',$email)
			                            ->addFieldToFilter('product_id', $product_id)
			                            ->addFieldToFilter('website_id', $websiteId)
			                            ->getFirstItem();

			        if(!$guestalertCollection->getId()){
			            $guestalertModel = $this->_guestalert->create()
			            					->setData('email',$email)
			                       			->setData('product_id', $product_id)
			                       			->setData('website_id', $websiteId)
			                       			->save();
			        } else{
			        	$email = $guestalertCollection->getEmail();
			        }

		            $response = 1;
		            $message = 'You will be notified on '.$email.' when this product is back in stock';
				}
			} else{
	            $response = 0;
	            $message = 'Sorry this product can not be added';
			}
        } catch (\Exception $e) {
            $response = 0;
            $message = 'We can\'t update the alert subscription right now.';
        }

        $respArr = array(
            'status' => $response,
            'msg' => $message
        );

        $result->setData($respArr);
        return $result;
	}

}