<?php

namespace Aislend\Alert\Controller\Add;

use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;


class User extends \Magento\ProductAlert\Controller\Add\Stock
{


	public function execute()
	{
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        if($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomerDataObject();    
            $cust_email = $customer->getEmail();

            $productId = (int)$this->getRequest()->getParam('product_id');

            try {
                /* @var $product \Magento\Catalog\Model\Product */
                $product = $this->productRepository->getById($productId);
                /** @var \Magento\ProductAlert\Model\Stock $model */
                $model = $this->_objectManager->create('Magento\ProductAlert\Model\Stock')
                    ->setCustomerId($this->customerSession->getCustomerId())
                    ->setProductId($product->getId())
                    ->setWebsiteId(
                        $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')
                            ->getStore()
                            ->getWebsiteId()
                    );
                $model->save();
                $response = 1;
                $message = 'You will be notified on '.$cust_email.' when this product is back in stock';
            } catch (NoSuchEntityException $noEntityException) {
                $message = 'There are not enough parameters.';
                $response = 0;
            } catch (\Exception $e) {
                $response = 0;
                $message = 'We can\'t update the alert subscription right now.';
            }

            $respArr = array(
                'status' => $response,
                'msg' => $message
            );

        } else{
            $respArr = array(
                'status' => 0,
                'msg' => 'Please login for notification'
            );
        }

        $result->setData($respArr);
        return $result;
	}
}