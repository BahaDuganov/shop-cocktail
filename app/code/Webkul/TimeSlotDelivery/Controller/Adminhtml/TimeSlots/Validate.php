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

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface;

/**
 * TimeSlots validate
 */
class Validate extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface
     */
    protected $timeSlotRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        TimeSlotsRepositoryInterface $timeSlotRepository,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->timeSlotRepository = $timeSlotRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->date = $date;
        parent::__construct($context);
    }

    /**
     * AJAX time slot validation action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(0);
        $id = $this->getRequest()->getParam('entity_id');
        $startTime = $this->date->date('g:i A', $this->getRequest()->getParam('start_time'));
        $endTime = $this->date->date('g:i A', $this->getRequest()->getParam('end_time'));

        if ($startTime !== '' && $endTime !== '') {
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            if ($endTime < $startTime) {
                $response->setError(1);
                $response->setMessage(__('Closing time can not be less than Opening time.'));
            }
        }
        if (!$id) {
            $slots =  $this->getSlots();
            if (count($slots)) {
                $response->setError(1);
                $response->setMessage(__('Time Slot with same details already exists.'));
            }
        }
        
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($response);
        
        return $resultJson;
    }

    /**
     * get time slot list
     *
     * @return array
     */
    protected function getSlots()
    {
        $filters[] = $this->filterBuilder
        ->setField('start_time')
        ->setConditionType('eq')
        ->setValue($this->getRequest()->getParam('start_time'))
        ->create();
        $filters[] = $this->filterBuilder
        ->setField('end_time')
        ->setConditionType('eq')
        ->setValue($this->getRequest()->getParam('end_time'))
        ->create();
        $filters[] = $this->filterBuilder
        ->setField('delivery_day')
        ->setConditionType('eq')
        ->setValue($this->getRequest()->getParam('delivery_day'))
        ->create();

        $this->searchCriteriaBuilder->addFilters($filters);
        
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->timeSlotRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }
}
