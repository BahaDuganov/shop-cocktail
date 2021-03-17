<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\TotalsInterface
 */
interface TotalsExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getCouponLabel();

    /**
     * @param string $couponLabel
     * @return $this
     */
    public function setCouponLabel($couponLabel);

    /**
     * @return \Amasty\Rules\Api\Data\DiscountBreakdownLineInterface[]|null
     */
    public function getAmruleDiscountBreakdown();

    /**
     * @param \Amasty\Rules\Api\Data\DiscountBreakdownLineInterface[] $amruleDiscountBreakdown
     * @return $this
     */
    public function setAmruleDiscountBreakdown($amruleDiscountBreakdown);
}
