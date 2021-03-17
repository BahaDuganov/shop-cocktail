<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_TimeSlotDelivery
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\TimeSlotDelivery\Api\Data;

interface OrderInterface
{
    const ENTITY_ID = 'entity_id';

    /**
     * Get entityId
     * @return string|null
     */
    public function getId();

    /**
     * Set entityId
     * @param string $entityId
     * @return \Webkul\TimeSlotDelivery\Api\Data\OrderInterface
     */
    public function setId($entityId);
}
