<?php

/**
 * Webkul DistanceRateShipping Shipping Edit Tab Shipping Admin Block
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Block\Adminhtml\Shipping\Edit\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;

class Shipping extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_storeManager;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @var \Webkul\DistanceRateShipping\Model\MpshippingFactory
     */
    protected $_shippingFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $shippingFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $shippingFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_shippingFactory = $shippingFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_storeManager = $context->getStoreManager();
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('distancerateshipping_grid');
        $this->setDefaultSort('drshipping_id');
        $this->setUseAjax(true);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_shippingFactory->create()->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'drshipping_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'drshipping_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'type'=>'range'
            ]
        );
        $this->addColumn(
            'distance_from',
            [
                'header' => __('Distance From'),
                'sortable' => true,
                'index' => 'distance_from',
                'type'=>'range'

            ]
        );
        $this->addColumn(
            'distance_to',
            [
                'header' => __('Distance To'),
                'sortable' => true,
                'index' => 'distance_to',
                'type'=>'range'

            ]
        );
        $this->addColumn(
            'rate',
            [
                'type'  =>'range',
                'header' => __('Rate'),
                'sortable' => true,
                'index' => 'rate'
            ]
        );
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->getMassactionBlock()->setTemplate('Webkul_DistanceRateShipping::widget/grid/massaction_extended.phtml');
        $this->setMassactionIdField('drshipping_id');
        $this->getMassactionBlock()->setFormFieldName('distancerateshipping');
        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label'    => __('Delete'),
                'url'      => $this->getUrl('*/*/massDelete', ['_current' => true]),
                'confirm'  => __('Are you sure?')
            ]
        );
        return $this;
    }
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('distancerateshipping/*/gridshipping', ['_current' => true]);
    }
    /**
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('distancerateshipping/*/edit', ['_current' => true, 'id'=> $row->getDrshippingId()]);
    }
    public function getcurrency()
    {
        return $currencyCode = $this->_storeManager->getStore()->getBaseCurrencyCode();
    }
}
