<?php
/**
 * DistanceRateShipping Admin Shippingset Controller
 *
 * @category    Webkul
 * @package     Webkul_DistanceRateShipping
 * @author      Webkul Software Private Limited
 *
 */
namespace Webkul\DistanceRateShipping\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Shippingset extends \Magento\Backend\App\Action
{
    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshippingset');
    }
}
