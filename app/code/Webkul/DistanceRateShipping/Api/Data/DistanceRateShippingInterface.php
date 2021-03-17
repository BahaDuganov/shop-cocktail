<?php

/**
 * DistanceRateShipping Interface
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Api\Data;

interface DistanceRateShippingInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const DRSHIPPING_ID = 'drshipping_id';
    /**#@-*/

    /**
     * Get Drshipping ID
     *
     * @return int|null
     */
    public function getDrshippingId();
    /**
     * Set Drshipping ID
     *
     * @param int $id
     * @return \Webkul\DistanceRateShipping\Api\Data\DistanceRateShippingInterface
     */
    public function setDrshippingId($id);
}
