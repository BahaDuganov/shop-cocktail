<?php


namespace Webkul\TimeSlotDelivery\Controller\Adminhtml;

abstract class TimeSlots extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Webkul_TimeSlotDelivery::manage';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Webkul'), __('Webkul'))
            ->addBreadcrumb(__('Timeslots'), __('Timeslots'));
        return $resultPage;
    }
}
