<?php


namespace Webkul\TimeSlotDelivery\Model\TimeSlots;

use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $slotData = $model->getData();
            $slotData = $this->addUseDefaultSettings($model, $slotData);
            $slotData = $this->updateTimeFormate($model, $slotData);
            $this->loadedData[$model->getId()] = $slotData;
        }
        $data = $this->dataPersistor->get('webkul_timeslotdelivery_timeslots');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $slotData = $model->getData();
            $this->loadedData[$model->getId()] = $slotData;
            $this->dataPersistor->clear('webkul_timeslotdelivery_timeslots');
        }
        return $this->loadedData;
    }

    protected function updateTimeFormate($model, $slotData)
    {
        $slotData['start_time'] = '1970/01/01 '. $model->getStartTime();
        $slotData['end_time'] = '1970/01/01 '. $model->getEndTime();
        return $slotData;
    }

    /**
     * Add use default settings
     *
     * @param \Webkul\TimeSlotDelivery\Model\TimeSlots $slotModel
     * @param array $categoryData
     * @return array
     */
    protected function addUseDefaultSettings($slotModel, $slotData)
    {
        if ($slotModel->getStartTime() !== '') {
            $slotData['disable_start'] = true;
        } else {
            $slotData['disable_start'] = false;
        }
        if ($slotModel->getEndTime() !== '') {
            $slotData['disable_end'] = true;
        } else {
            $slotData['disable_end'] = false;
        }
        if ($slotModel->getDeliveryDay() !== '') {
            $slotData['disable_day'] = true;
        } else {
            $slotData['disable_end'] = false;
        }
        return $slotData;
    }
}
