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
namespace Webkul\TimeSlotDelivery\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TimeSlotsRepositoryInterface
{


    /**
     * Save TimeSlots
     * @param \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
    );

    /**
     * Retrieve TimeSlots
     * @param string $timeslotsId
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($timeslotsId);

    /**
     * Retrieve TimeSlots matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete TimeSlots
     * @param \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Webkul\TimeSlotDelivery\Api\Data\TimeSlotsInterface $timeSlots
    );

    /**
     * Delete TimeSlots by ID
     * @param string $timeslotsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($timeslotsId);
}
