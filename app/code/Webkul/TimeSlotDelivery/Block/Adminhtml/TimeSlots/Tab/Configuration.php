<?php
namespace Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Tab;


class Configuration extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'timeslots/configurations.phtml';

    /**
     * Prepare global layout.
     *
     * @return $this
     */
    public function _prepareLayout()
    {
        $this->addChild('magento_time_delivery_box', 'Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Tab\Option');

        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getOptionsBoxHtml()
    {
        return $this->getChildHtml('magento_time_delivery_box');
    }
}