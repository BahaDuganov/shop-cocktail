<?php

/**
 * DistanceRateShipping Admin Shipping update Controller.
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

use Magento\Backend\App\Action;
use Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory;

class Update extends \Magento\Backend\App\Action
{
    /**
     * @var DistanceRateShippingFactory
     */
    protected $drshippingModel;

    /**
     * @param Action\Context                             $context
     * @param DistanceRateShippingFactory                $drshippingModel
     */
    public function __construct(
        Action\Context $context,
        DistanceRateShippingFactory $drshippingModel
    ) {
        parent::__construct($context);
        $this->drshippingModel = $drshippingModel;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->isPost()) {
            try {
                if (!$this->_formKeyValidator->validate($this->getRequest())) {
                    return $this->resultRedirectFactory->create()->setPath('*/*/index');
                }
                $params = $this->getRequest()->getParams();
                if (!empty($params)) {
                    $shippingData = $this->drshippingModel
                      ->create()
                      ->load($params['drshipping_id']);
                  
                    $shippingCollection = $this->drshippingModel->create()
                        ->getCollection()
                        ->addFieldToFilter('distance_from', ['lteq' =>$params['distance_from']])
                        ->addFieldToFilter('distance_to', ['gteq' =>$params['distance_to']])
                        ->addFieldToFilter('drshipping_id', ['neq' => $params['drshipping_id']]);
                    if ($shippingCollection->getSize()) {
                        $this->messageManager->addError(
                            __('Shipping rule already exist for the given range for seller.')
                        );
                        return $this->resultRedirectFactory->create()->setPath('*/*/index');
                    }
                    $shippingData->addData($params);
                    $shippingData->setMpShippingId($params['drshipping_id'])->save();
                    $this->messageManager->addSuccess(__('Your shipping detail has been successfully updated.'));
                    return $this->resultRedirectFactory->create()->setPath('*/*/index');
                } else {
                    $this->messageManager->addError(__('No record Found!'));
                    return $this->resultRedirectFactory->create()->setPath('*/*/index');
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }

    /**
     * [_isAllowed To check the allowed authorization]
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshipping');
    }
}
