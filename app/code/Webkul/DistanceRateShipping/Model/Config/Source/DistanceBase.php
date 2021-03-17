<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Model\Config\Source;

class DistanceBase
{
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = [
            ['value' => 'googleMap', 'label' => __('Google Map Distance')],
            ['value' => 'latLong', 'label' => __('Latitude & Longitude')],
        ];

        return $data;
    }
}
