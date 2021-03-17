<?php
namespace Aislend\CustomReports\Block\Adminhtml;

class Finance extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Template file
     *
     * @var string
     */
    protected $_template = 'report/grid/container-finance.phtml';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Aislend_CustomReports';
        $this->_controller = 'adminhtml_finance';
        $this->_headerText = __('Fiannce Report');
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
        return $this->getUrl('*/*/finance', ['_current' => true]);
    }
}
