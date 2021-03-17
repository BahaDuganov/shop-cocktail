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

interface TimeSlotsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get TimeSlots list.
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     * @param \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
