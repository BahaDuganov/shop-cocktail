<?php


namespace Webkul\TimeSlotDelivery\Model\ResourceModel;

class TimeSlots extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('webkul_timeslotdelivery_timeslots', 'entity_id');
    }
}
