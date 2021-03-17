<?php
namespace Aislend\CustomReports\Block\Adminhtml;

class Department extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Template file
     *
     * @var string
     */
    protected $_template = 'report/grid/container.phtml';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Aislend_CustomReports';
        $this->_controller = 'adminhtml_department';
        $this->_headerText = __('Total Ordered Report Grouped by Department');
        parent::_construct();

        $this->buttonList->remove('add');
        $this->addButton(
            'filter_form_submit',
            ['label' => __('Export CSV'), 'onclick' => 'filterFormSubmit()', 'class' => 'primary']
        );
    }

    /**
     * Get filter URL
     *
     * @return string
     */
    public function getFilterUrl()
    {
        //$this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/department', ['_current' => true]);
    }
}
