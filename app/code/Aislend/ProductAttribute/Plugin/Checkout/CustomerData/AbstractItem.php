<?php

namespace Aislend\ProductAttribute\Plugin\Checkout\CustomerData;

class AbstractItem
{

    public function aroundGetItemData(\Magento\Checkout\CustomerData\AbstractItem $subject, \Closure $proceed, \Magento\Quote\Model\Quote\Item $item)
    {
        $prodId = $item->getProduct()->getId();
        $result = $proceed($item);

        if(!array_key_exists('product_id', $result)){
            $result['product_id'] = $prodId;
        }

        return $result;
    }
}
