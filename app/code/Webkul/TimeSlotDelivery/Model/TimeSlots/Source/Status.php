<?php
namespace Webkul\TimeSlotDelivery\Model\TimeSlots\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Webkul\Rmasystem\Model\Reason
     */
    protected $timeSlotModel;

    /**
     * Constructor
     *
     * @param
     */
    public function __construct(\Webkul\TimeSlotDelivery\Model\TimeSlots $timeSlotModel)
    {
        $this->timeSlotModel = $timeSlotModel;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->timeSlotModel->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
