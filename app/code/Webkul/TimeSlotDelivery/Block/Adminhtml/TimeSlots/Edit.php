<?php

namespace Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    
       /**
        * @param Context $context
        * @param Registry $registry
        * @param array $data
        */
       public function __construct(
           Context $context,
           Registry $registry,
           array $data = []
       ) {
           $this->_coreRegistry = $registry;
           parent::__construct($context, $data);
       }
    
       /**
        * Class constructor
        *
        * @return void
        */
       protected function _construct()
       {
           $this->_objectId = 'id';
           $this->_controller = 'adminhtml_TimeSlots';
           $this->_blockGroup = 'Webkul_TimeSlotDelivery';
    
           parent::_construct();
    
           $this->buttonList->update('save', 'label', __('Save Time Slots'));
           $this->buttonList->remove('delete');
           $this->buttonList->remove('reset');
       }
    
       /**
        * Retrieve text for header element depending on loaded news
        * 
        * @return string
        */
       public function getHeaderText()
       {
            return __('Manage Delivery Time Slots');
       }


    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    { 
        return parent::_prepareLayout();
    }
}
