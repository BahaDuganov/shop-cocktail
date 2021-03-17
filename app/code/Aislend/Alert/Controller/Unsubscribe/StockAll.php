<?php

namespace Aislend\Alert\Controller\Unsubscribe;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;

class StockAll extends \Magento\Framework\App\Action\Action
{
	protected $_guestAlert;

    public function __construct(
        Context $context,
        \Aislend\Alert\Model\ResourceModel\GuestAlert\CollectionFactory $guestAlert,
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
        $this->_guestAlert = $guestAlert;
        parent::__construct($context);
    }

	public function execute()
	{
		$email = $this->getRequest()->getParam('email');
		if($email){
	        try {	
				$website_id = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getWebsiteId();

				$model = $this->_guestAlert->create()
						->addFieldToFilter('email',$email)
						->addFieldToFilter('website_id',$website_id)
						->walk('delete');

	            $this->messageManager->addSuccess(__('You will no longer receive stock alerts.'));
	        } catch (\Exception $e) {
	        	$this->messageManager->addException($e, __('Unable to update the alert subscription.'));
	        }
	    }

	    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		return $resultRedirect->setPath('/');
	}
}