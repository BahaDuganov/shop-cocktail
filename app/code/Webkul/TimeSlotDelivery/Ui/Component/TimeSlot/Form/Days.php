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
namespace Webkul\TimeSlotDelivery\Ui\Component\TimeSlot\Form;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Days
 */
class Days implements OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;
    
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $days = [
            ['value' => 'Sunday',       'label' => __('Sunday')],
            ['value' => 'Monday',       'label' => __('Monday')],
            ['value' => 'Tuesday',      'label' => __('Tuesday')],
            ['value' => 'Wednesday',    'label' => __('Wednesday')],
            ['value' => 'Thursday',     'label' => __('Thursday')],
            ['value' => 'Friday',       'label' => __('Friday')],
            ['value' => 'Saturday',     'label' => __('Saturday')],
        ];
        $options = [];
        foreach ($days as $key => $value) {
            $options[] = [
                'label' => $value['label'],
                'value' => $value['value'],
            ];
        }
        $this->options = $options;

        return $this->options;
    }
}
