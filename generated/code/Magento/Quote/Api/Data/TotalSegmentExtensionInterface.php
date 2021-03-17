<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\TotalSegmentInterface
 */
interface TotalSegmentExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return \Magento\Tax\Api\Data\GrandTotalDetailsInterface[]|null
     */
    public function getTaxGrandtotalDetails();

    /**
     * @param \Magento\Tax\Api\Data\GrandTotalDetailsInterface[] $taxGrandtotalDetails
     * @return $this
     */
    public function setTaxGrandtotalDetails($taxGrandtotalDetails);

    /**
     * @return \Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface|null
     */
    public function getTaxAmastyExtrafeeDetails();

    /**
     * @param \Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface $taxAmastyExtrafeeDetails
     * @return $this
     */
    public function setTaxAmastyExtrafeeDetails(\Amasty\Extrafee\Api\TaxExtrafeeDetailsInterface $taxAmastyExtrafeeDetails);
}
