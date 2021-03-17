<?php

/**
 * DistanceRateShipping Admin Shipping Grid Controller
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

class Grid extends \Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping
{
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                      $context
     * @param \Magento\Framework\View\Result\LayoutFactory             $resultLayoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('distancerateshipping.shipping.edit.tab.shipping');
        return $resultLayout;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshipping');
    }
}
