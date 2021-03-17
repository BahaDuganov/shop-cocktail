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

class Unit
{
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = [
            ['value' => 'km', 'label' => __('Kilometer')],
            ['value' => 'miles', 'label' => __('Miles')],
        ];

        return $data;
    }
}
