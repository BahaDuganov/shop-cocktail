<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\TotalsInterface
 */
class TotalsExtension extends \Magento\Framework\Api\AbstractSimpleObject implements TotalsExtensionInterface
{
    /**
     * @return string|null
     */
    public function getCouponLabel()
    {
        return $this->_get('coupon_label');
    }

    /**
     * @param string $couponLabel
     * @return $this
     */
    public function setCouponLabel($couponLabel)
    {
        $this->setData('coupon_label', $couponLabel);
        return $this;
    }

    /**
     * @return \Amasty\Rules\Api\Data\DiscountBreakdownLineInterface[]|null
     */
    public function getAmruleDiscountBreakdown()
    {
        return $this->_get('amrule_discount_breakdown');
    }

    /**
     * @param \Amasty\Rules\Api\Data\DiscountBreakdownLineInterface[] $amruleDiscountBreakdown
     * @return $this
     */
    public function setAmruleDiscountBreakdown($amruleDiscountBreakdown)
    {
        $this->setData('amrule_discount_breakdown', $amruleDiscountBreakdown);
        return $this;
    }
}
