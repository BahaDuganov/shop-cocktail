<?php

namespace Freento\Progressbar\Model\Config\Source;

class BasedOn implements \Magento\Framework\Option\ArrayInterface
{
    const SUBTOTAL = 'subtotal';

    const SUBTOTAL_DISCOUNT = 'subtotal_discount';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            '' => '',
            self::SUBTOTAL => __('Subtotal'),
            self::SUBTOTAL_DISCOUNT => __('Subtotal - Discount')
        ];
    }
}
