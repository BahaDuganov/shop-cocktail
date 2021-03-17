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

namespace Webkul\TimeSlotDelivery\Block\Adminhtml\TimeSlots\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;

class Orders extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Webkul\TimeSlotDelivery\Model\OrderFactory $orderFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_orderFactory = $orderFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resource = $resource;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('time_slot_orders');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    /**
     * @return array|null
     */
    public function getCategory()
    {
        return $this->_coreRegistry->registry('category');
    }

    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        // if ($column->getId() == 'in_category') {
        //     $productIds = $this->_getSelectedProducts();
        //     if (empty($productIds)) {
        //         $productIds = 0;
        //     }
        //     if ($column->getFilter()->getValue()) {
        //         $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
        //     } elseif (!empty($productIds)) {
        //         $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
        //     }
        // } else {
        //     parent::_addColumnFilterToCollection($column);
        // }
        parent::_addColumnFilterToCollection($column);
        return $this;
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $slotId = (int)$this->getRequest()->getParam('slot_id');
        $timeSlotConfig = $this->_resource->getTableName('webkul_timeslotdelivery_timeslots');
        $collection = $this->_orderFactory->create()->getCollection()->join(
            ['tcr' => $this->_resource->getTableName('sales_order_grid')],
            "main_table.order_id = tcr.entity_id",
            [
                'increment_id'=>'tcr.increment_id',
                'grand_total'=>'tcr.grand_total',
                'tcr.customer_name'
            ]
        );
        $collection->getSelect()->join(
            $timeSlotConfig.' as tsc',
            'main_table.slot_id = tsc.entity_id',
            ['start_time' => 'start_time', 'end_time'=>'end_time']
        );
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'increment_id',
            [
                'header' => __('#Order Id'),
                'index' => 'increment_id'
            ]
        );
        
        $this->addColumn(
            'grand_total',
            [
                'header' => __('Grand Total (Purchased)'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index' => 'grand_total'
            ]
        );
        $this->addColumn(
            'selected_date',
            [
                'header' => __('Delivery Date'), 'index' => 'selected_date',
                'type' => 'date',
            ]
        );
        $this->addColumn(
            'start_time',
            [
                'header' => __('Time From'), 'index' => 'start_time',
                'type' => 'text',
            ]
        );
        $this->addColumn(
            'end_time',
            [
                'header' => __('Time To'), 'index' => 'end_time',
                'type' => 'text',
            ]
        );
        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'width' => '100',
                'renderer' => 'Webkul\TimeSlotDelivery\Block\Adminhtml\Grid\Renderer\Action',
                'filter' => false,
                'sortable' => false,
                'index' => 'order_id',
                'is_system' => true,
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('timeslots/*/grid', ['_current' => true]);
    }
}
