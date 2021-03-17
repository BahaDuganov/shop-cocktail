<?php

/**
 * DistanceRateShipping Admin Shipping Index Controller.
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

use Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping as ShippingController;
use Magento\Framework\Controller\ResultFactory;

class Index extends ShippingController
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Webkul_DistanceRateShipping::distancerateshipping');
        $resultPage->getConfig()->getTitle()->prepend(__('Distance Rate Shipping Manager'));
        $resultPage->addBreadcrumb(
            __('Distance Rate Shipping Manager'),
            __('Distance Rate Shipping Manager')
        );
        $resultPage->addContent(
            $resultPage
            ->getLayout()
            ->createBlock(
                \Webkul\DistanceRateShipping\Block\Adminhtml\Shipping\Edit::class
            )
        );
        $resultPage->addLeft(
            $resultPage
            ->getLayout()
            ->createBlock(
                \Webkul\DistanceRateShipping\Block\Adminhtml\Shipping\Edit\Tabs::class
            )
        );
        return $resultPage;
    }
}
