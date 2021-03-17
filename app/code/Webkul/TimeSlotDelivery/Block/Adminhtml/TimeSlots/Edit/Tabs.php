<?php
 
namespace Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Edit;
 
use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
 
class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('time_slot_config_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Delivery Time Slots'));
    }
 
    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'time_slots',
            [
                'label' => __('Add/Remove Time Slots'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Tab\Configuration'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'hello',
            [
                'label' => __('Time Slot Orders'),
                'url' => $this->getUrl('timeslots/*/grid', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
 
        return parent::_beforeToHtml();
    }
}