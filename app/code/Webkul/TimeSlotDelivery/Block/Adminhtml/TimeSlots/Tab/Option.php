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
namespace Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Tab;

use Magento\Catalog\Model\Product;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots\CollectionFactory as TimeSlotCollection;

/**
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Option extends \Magento\Framework\View\Element\Template
{

    /**
     * @var string
     */
    protected $_template = 'timeslots/configuration/option.phtml';

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var int
     */
    protected $_itemCount = 1;

    /**
     * @var \Webkul\TimeSlotDelivery\Model\Config\Source\Days
     */
    protected $_days;


    /**
     * @var \Webkul\TimeSlotDelivery\Model\Config\Source\Minutes
     */
    protected $status;

     /**
      * @var CollectionFactory
      */
    protected $_timeSlotCollection;

    /**
     * @param \Magento\Framework\View\Element\Template\Context   $context
     * @param \Webkul\TimeSlotDelivery\Model\Config\Source\Days    $days
     * @param \Webkul\TimeSlotDelivery\Model\Config\Source\Hours   $hours
     * @param \Webkul\TimeSlotDelivery\Model\Config\Source\Minutes $minutes
     * @param \Magento\Customer\Model\Session                    $customerSession
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param TimeSlotCollection                                 $timeSlotCollection
     * @param array                                              $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\TimeSlotDelivery\Model\Config\Source\Days $days,
        \Webkul\TimeSlotDelivery\Model\TimeSlots\Source\Status $status,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        TimeSlotCollection $timeSlotCollection,
        array $data = []
    ) {
        $this->_days = $days;
        $this->status = $status;
        $this->_objectManager = $objectManager;
        $this->_timeSlotCollection = $timeSlotCollection;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve options field id prefix
     *
     * @return string
     */
    public function getFieldId()
    {
        return 'time_delivery';
    }

    /**
     * @return int
     */
    public function getItemCount()
    {
        return $this->_itemCount;
    }

    /**
     * Retrieve options field name prefix
     *
     * @return string
     */
    public function getFieldName()
    {
        return 'timedelivery[slot]';
    }

    /**
     * @return mixed
     */
    public function getDaysHtml()
    {
        $select = $this->getLayout()->createBlock(
            'Magento\Framework\View\Element\Html\Select'
        )->setData(
            [
                'id' => $this->getFieldId() . '_<%- data.id %>_type',
                'class' => 'select select-days-type required-option-select admin__control-select',
            ]
        )->setName(
            $this->getFieldName() . '[<%- data.id %>][delivery_day]'
        )->setOptions(
            $this->_days->toOptionArray()
        );

        return $select->getHtml();
    }

    /**
     * @return mixed
     */
    public function getStatusHtml()
    {
        $select = $this->getLayout()->createBlock(
            'Magento\Framework\View\Element\Html\Select'
        )->setData(
            [
                'id' => $this->getFieldId() . '_<%- data.id %>_status_type',
                'class' => 'select select-status-type required-option-select admin__control-select',
            ]
        )->setName(
            $this->getFieldName() . '[<%- data.id %>][status]'
        )->setOptions(
            $this->status->toOptionArray()
        );

        return $select->getHtml();
    }

    /**
     * Provide already save values
     * @return array
     */
    public function getTimeSlotsValue()
    {
        $date = $this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
        $collection = $this->_timeSlotCollection->create();
        $values = [];
        if ($collection->getSize()) {
            foreach ($collection as $slot) {
                $value = [];
                $value['id'] = $slot->getEntityId();
                $value['entity_id'] = $slot->getEntityId();
                $value['item_count'] = 1;
                $value['day'] = $slot->getDeliveryDay();
                $value['start'] = $date->gmtDate('h:i A', $slot->getStartTime());
                $value['end'] = $date->gmtDate('h:i A', $slot->getEndTime());
                $value['quota'] = $slot->getOrderCount();
                $value['status'] = $slot->getStatus();
                $values[] = new \Magento\Framework\DataObject($value);
            }
        }
        
        return $values;
    }
}
