<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\AddressInterface
 */
class AddressExtension extends \Magento\Framework\Api\AbstractSimpleObject implements AddressExtensionInterface
{
    /**
     * @return \Magento\SalesRule\Api\Data\RuleDiscountInterface[]|null
     */
    public function getDiscounts()
    {
        return $this->_get('discounts');
    }

    /**
     * @param \Magento\SalesRule\Api\Data\RuleDiscountInterface[] $discounts
     * @return $this
     */
    public function setDiscounts($discounts)
    {
        $this->setData('discounts', $discounts);
        return $this;
    }

    /**
     * @return \Amasty\Conditions\Api\Data\AddressInterface|null
     */
    public function getAdvancedConditions()
    {
        return $this->_get('advanced_conditions');
    }

    /**
     * @param \Amasty\Conditions\Api\Data\AddressInterface $advancedConditions
     * @return $this
     */
    public function setAdvancedConditions(\Amasty\Conditions\Api\Data\AddressInterface $advancedConditions)
    {
        $this->setData('advanced_conditions', $advancedConditions);
        return $this;
    }
}
