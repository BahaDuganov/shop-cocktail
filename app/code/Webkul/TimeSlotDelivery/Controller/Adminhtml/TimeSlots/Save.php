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

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface
     */
    protected $timeSlotRepository;

    /**
     * @var \Webkul\TimeSlotDelivery\Model\TimeSlotsFactory
     */
    protected $timeSlotFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * Save class constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface $timeSlotRepository
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface $timeSlotRepository,
        \Webkul\TimeSlotDelivery\Model\TimeSlotsFactory $timeSlotFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->timeSlotRepository = $timeSlotRepository;
        $this->timeSlotFactory = $timeSlotFactory;
        $this->date = $date;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        
        if ($this->getRequest()->isPost()) {
            $timeSlotData = $this->getRequest()->getParam('timedelivery');
            $validate = $this->validateData($timeSlotData);
            if (!$validate['error'] && isset($timeSlotData['slot'])) {
                try {
                    $count = 0;
                    foreach ($timeSlotData['slot'] as $data) {
                        $model = $this->timeSlotFactory->create();
                        if (isset($data['is_delete']) && $data['is_delete']) {
                            $this->deleteDataById($data['entity_id']);
                            continue;
                        }
                        $data['start_time'] = $this->date->date('g:i A', $data['start_time']);
                        $data['end_time'] = $this->date->date('g:i A', $data['end_time']);
                        if (!$data['entity_id']) {
                            unset($data['entity_id']);
                        }
                        $model->setData($data);
                        $this->saveData($model);
                        $count++;
                    }
                    $this->messageManager->addSuccess(__('Total %1 time slot(s) saved successfully.', $count));
                    return $resultRedirect->setPath('*/*/');
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Timeslots.'));
                }
            }
            return $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * save slots
     *
     * @param \\Webkul\TimeSlotDelivery\Model\TimeSlots $completeDataObject
     * @return void
     */
    public function saveData($completeDataObject)
    {
        try {
            $this->timeSlotRepository->save($completeDataObject);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Delete Slot
     * @param  int $id
     */
    public function deleteDataById($id)
    {
        if ($id) {
            try {
                $this->timeSlotRepository->deleteById($id);
            } catch (\Exception $e) {
                throw new LocalizedException(
                    __(
                        $e->getMessage()
                    )
                );
            }
        }
    }

    /**
     * Slot Validation
     * @param  $data
     * @return bool
     */
    public function validateData($data)
    {
        $error = ['error' => false, 'msg' => ''];
        if (!isset($data['slot'])) {
            return ['error' => true, 'msg' => 'No time slots available.'];
        }
        foreach ($data['slot'] as $key => $value) {
            if (!$value['is_delete']) {
                if ($value['order_count'] == '' || !is_numeric($value['order_count'])) {
                    $error = ['error' => true, 'msg' => 'Quotas must have numeric value.'];
                }
                if ($value['start_time'] == '' || !$value['start_time']) {
                    $error = ['error' => true, 'msg' => 'Start time field must be have valid value.'];
                }
                if ($value['end_time'] == '' || !$value['end_time']) {
                    $error = ['error' => true, 'msg' => 'End time field must be have valid value.'];
                }
                if (strtotime($value['end_time']) < strtotime($value['start_time'])) {
                    $error = ['error' => true, 'msg' => 'End time must be greater than start time.'];
                }
            }
        }
        return $error;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_TimeSlotDelivery::TimeSlots_save');
    }
}
