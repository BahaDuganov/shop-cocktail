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

namespace Webkul\TimeSlotDelivery\Model;

use Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface;
use Webkul\TimeSlotDelivery\Api\Data\TimeSlotsSearchResultsInterfaceFactory;
use Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots as ResourceTimeSlots;
use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots\CollectionFactory as TimeSlotsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class TimeSlotsRepository implements timeSlotsRepositoryInterface
{

    protected $resource;

    protected $timeSlotsFactory;

    protected $timeSlotsCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataTimeSlotsFactory;

    private $storeManager;


    /**
     * @param ResourceTimeSlots $resource
     * @param TimeSlotsFactory $timeSlotsFactory
     * @param TimeSlotsInterfaceFactory $dataTimeSlotsFactory
     * @param TimeSlotsCollectionFactory $timeSlotsCollectionFactory
     * @param TimeSlotsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceTimeSlots $resource,
        TimeSlotsFactory $timeSlotsFactory,
        TimeSlotsInterfaceFactory $dataTimeSlotsFactory,
        TimeSlotsCollectionFactory $timeSlotsCollectionFactory,
        TimeSlotsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->timeSlotsFactory = $timeSlotsFactory;
        $this->timeSlotsCollectionFactory = $timeSlotsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTimeSlotsFactory = $dataTimeSlotsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
    ) {
        try {
            $timeSlots->getResource()->save($timeSlots);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the timeSlots: %1',
                $exception->getMessage()
            ));
        }
        return $timeSlots;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($timeSlotsId)
    {
        $timeSlots = $this->timeSlotsFactory->create();
        $timeSlots->getResource()->load($timeSlots, $timeSlotsId);
        if (!$timeSlots->getId()) {
            throw new NoSuchEntityException(__('TimeSlots with id "%1" does not exist.', $timeSlotsId));
        }
        return $timeSlots;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->timeSlotsCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
    ) {
        try {
            $timeSlots->getResource()->delete($timeSlots);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the TimeSlots: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($timeSlotsId)
    {
        return $this->delete($this->getById($timeSlotsId));
    }
}
