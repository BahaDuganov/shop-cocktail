<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_TimeSlotDelivery
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
namespace Webkul\TimeSlotDelivery\Model\Config\Source;

/**
 *
 */
class Hours implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $hours = [];
        for ($i=0; $i < 24; $i++) {
            if ($i < 10) {
                $hours[] = ['value' => '0'.$i, 'label' => __('0'.$i)];
            } else {
                $hours[] =  ['value' => $i, 'label' => __($i)];
            }
        }

        return $hours;

        return $hours;
    }
}
