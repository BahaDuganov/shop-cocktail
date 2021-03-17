<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\ViewModel;

class LocationModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * DistanceRateShipping Helper
     *
     * @var \Webkul\DistanceRateShipping\Helper\Data
     */
    public $drHelper;

    /**
     * @param \Webkul\DistanceRateShipping\Helper\Data $mpHelper
     */
    public function __construct(
        \Webkul\DistanceRateShipping\Helper\Data $drHelper
    ) {
        $this->drHelper = $drHelper;
    }

    public function getDrHelper()
    {
        return $this->drHelper;
    }
}
