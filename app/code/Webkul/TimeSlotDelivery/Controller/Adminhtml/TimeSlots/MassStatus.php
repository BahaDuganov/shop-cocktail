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
namespace Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots\CollectionFactory;

class MassStatus extends \Magento\Backend\App\Action
{

    /**
     * @var Filter
     */
    protected $_filter;
    
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Mass Delete
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->_filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->collectionFactory->create());
        
        $timeSlotIds = $collection->getAllIds();
        $status = (int) $this->getRequest()->getParam('status');
        $count = $collection->getSize();
        foreach ($collection as $item) {
            $item->setStatus($status);
            $item->save();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been updated.', count($timeSlotIds)));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_TimeSlotDelivery::TimeSlots_update');
    }
}
