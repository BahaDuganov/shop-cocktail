<?php
namespace Aislend\CustomReports\Block\Adminhtml\Department;

use Magento\Framework\Registry;


class Grid extends \Magento\Backend\Block\Widget\Grid
{

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(\Magento\Backend\Block\Template\Context $context,
                                \Magento\Backend\Helper\Data $backendHelper,
                                Registry $registery,
                                array $data = [])
    {
        parent::__construct($context, $backendHelper, $data);
        $this->registry = $registery;
    }

    function _prepareLayout(){

        /** @var $customReport \DEG\CustomReports\Model\CustomReport */
        $customReport = $this->registry->registry('current_customreport');
        /** @var $genericCollection \DEG\CustomReports\Model\GenericReportCollection */
        /* $genericCollection = $customReport->getGenericReportCollection();
        $columnList = $this->getColumnListFromCollection($genericCollection);
        if (count($columnList)) {
            $this->addColumnSet($columnList);
            $this->addGridExportBlock();
            $this->setCollection($genericCollection);
        } */
        parent::_prepareLayout();
    }
}
