<?php


namespace Webkul\TimeSlotDelivery\Model;

use Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface;

class TimeSlots extends \Magento\Framework\Model\AbstractModel implements TimeSlotsInterface
{

    /**#@+
     * Post's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots');
    }

    /**
     * Get timeslots_id
     * @return string
     */
    public function getTimeslotsId()
    {
        return $this->getData(self::TIMESLOTS_ID);
    }

    /**
     * Set timeslots_id
     * @param string $timeslotsId
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface
     */
    public function setTimeslotsId($timeslotsId)
    {
        return $this->setData(self::TIMESLOTS_ID, $timeslotsId);
    }

    /**
     * Get entity_id
     * @return string
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entity_id
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface
     */
    public function setEntityId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * Prepare post's statuses.
     * Available event to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
