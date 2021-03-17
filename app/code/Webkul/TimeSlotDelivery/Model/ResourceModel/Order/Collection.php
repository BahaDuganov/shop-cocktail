<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_TimeSlotDelivery
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
namespace Webkul\TimeSlotDelivery\Model\ResourceModel\Order;

use \Webkul\TimeSlotDelivery\Model\ResourceModel\AbstractCollection;

/**
 * Webkul TimeSlotDelivery ResourceModel Seller collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Webkul\TimeSlotDelivery\Model\Order',
            'Webkul\TimeSlotDelivery\Model\ResourceModel\Order'
        );
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
        $this->_map['fields']['slot_id'] = 'main_table.slot_id';
        $this->_map['fields']['selected_date'] = 'main_table.selected_date';
    }

    
    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }
    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    public function getDeliveryOrderCollection()
    {
        $timeSlotConfig = $this->getTable('webkul_timeslotdelivery_timeslots');
        $salesOrder = $this->getTable('sales_order');

        $this->getSelect()->join(
            $timeSlotConfig.' as sc',
            'main_table.slot_id = sc.entity_id',
            ['start_time' => 'start_time', 'end_time'=>'end_time']
        );
        $this->addFilterToMap('start_time', 'sc.start_time');
        $this->addFilterToMap('end_time', 'sc.end_time');

        $this->getSelect()->join(
            $salesOrder.' as sales',
            'main_table.order_id = sales.entity_id',
            ['increment_id' => 'increment_id']
        );
        $this->addFilterToMap('increment_id', 'sales.increment_id');
        
        return $this;
    }
}
