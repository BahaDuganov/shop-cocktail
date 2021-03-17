<?php

namespace Aislend\Alert\Controller\Unsubscribe;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;

class Stock extends \Magento\Framework\App\Action\Action
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
		$productId = (int)$this->getRequest()->getParam('product');
		$email = $this->getRequest()->getParam('email');
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

		if($productId && $email){

	        try {
	            $product = $this->productRepository->getById($productId);
	            if (!$product->isVisibleInCatalog()) {
	                throw new NoSuchEntityException();
	            }
				
				$website_id = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getWebsiteId();

				$model = $this->_guestAlert->create()
						->addFieldToFilter('product_id',$productId)
						->addFieldToFilter('email',$email)
						->addFieldToFilter('website_id',$website_id)
						->walk('delete');

	            $this->messageManager->addSuccess(__('You will no longer receive stock alerts for this product.'));
	        } catch (NoSuchEntityException $noEntityException) {
	            $this->messageManager->addError(__('The product was not found.'));
	            $resultRedirect->setPath('customer/account/');
	        } catch (\Exception $e) {
	            $this->messageManager->addException($e, __('We can\'t update the alert subscription right now.'));
	        }
	        $resultRedirect->setUrl($product->getProductUrl());
		}else{
            $resultRedirect->setPath('/');
		}

		return $resultRedirect;
	}
}