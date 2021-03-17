<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\TotalSegmentInterface
 */
class TotalSegmentExtension extends \Magento\Framework\Api\AbstractSimpleObject implements TotalSegmentExtensionInterface
{
    /**
     * @return \Magento\Tax\Api\Data\GrandTotalDetailsInterface[]|null
     */
    public function getTaxGrandtotalDetails()
    {
        return $this->_get('tax_grandtotal_details');
    }

    /**
     * @param \Magento\Tax\Api\Data\GrandTotalDetailsInterface[] $taxGrandtotalDetails
     * @return $this
     */
    public function setTaxGrandtotalDetails($taxGrandtotalDetails)
    {
        $this->setData('tax_grandtotal_details', $taxGrandtotalDetails);
        return $this;
    }

    /**
     * @return \Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface|null
     */
    public function getTaxAmastyExtrafeeDetails()
    {
        return $this->_get('tax_amasty_extrafee_details');
    }

    /**
     * @param \Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface $taxAmastyExtrafeeDetails
     * @return $this
     */
    public function setTaxAmastyExtrafeeDetails(\Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface $taxAmastyExtrafeeDetails)
    {
        $this->setData('tax_amasty_extrafee_details', $taxAmastyExtrafeeDetails);
        return $this;
    }
}
