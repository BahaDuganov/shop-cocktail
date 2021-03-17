<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\AddressInterface
 */
interface AddressExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return \Magento\SalesRule\Api\Data\RuleDiscountInterface[]|null
     */
    public function getDiscounts();

    /**
     * @param \Magento\SalesRule\Api\Data\RuleDiscountInterface[] $discounts
     * @return $this
     */
    public function setDiscounts($discounts);

    /**
     * @return \Amasty\Conditions\Api\Data\AddressInterface|null
     */
    public function getAdvancedConditions();

    /**
     * @param \Amasty\Conditions\Api\Data\AddressInterface $advancedConditions
     * @return $this
     */
    public function setAdvancedConditions(\Amasty\Conditions\Api\Data\AddressInterface $advancedConditions);
}
