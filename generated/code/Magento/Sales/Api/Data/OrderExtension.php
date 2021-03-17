<?php
namespace Magento\Sales\Api\Data;

/**
 * Extension class for @see \Magento\Sales\Api\Data\OrderInterface
 */
class OrderExtension extends \Magento\Framework\Api\AbstractSimpleObject implements OrderExtensionInterface
{
    /**
     * @return \Magento\Sales\Api\Data\ShippingAssignmentInterface[]|null
     */
    public function getShippingAssignments()
    {
        return $this->_get('shipping_assignments');
    }

    /**
     * @param \Magento\Sales\Api\Data\ShippingAssignmentInterface[] $shippingAssignments
     * @return $this
     */
    public function setShippingAssignments($shippingAssignments)
    {
        $this->setData('shipping_assignments', $shippingAssignments);
        return $this;
    }

    /**
     * @return \Magento\Payment\Api\Data\PaymentAdditionalInfoInterface[]|null
     */
    public function getPaymentAdditionalInfo()
    {
        return $this->_get('payment_additional_info');
    }

    /**
     * @param \Magento\Payment\Api\Data\PaymentAdditionalInfoInterface[] $paymentAdditionalInfo
     * @return $this
     */
    public function setPaymentAdditionalInfo($paymentAdditionalInfo)
    {
        $this->setData('payment_additional_info', $paymentAdditionalInfo);
        return $this;
    }

    /**
     * @return \Magento\GiftMessage\Api\Data\MessageInterface|null
     */
    public function getGiftMessage()
    {
        return $this->_get('gift_message');
    }

    /**
     * @param \Magento\GiftMessage\Api\Data\MessageInterface $giftMessage
     * @return $this
     */
    public function setGiftMessage(\Magento\GiftMessage\Api\Data\MessageInterface $giftMessage)
    {
        $this->setData('gift_message', $giftMessage);
        return $this;
    }

    /**
     * @return \Magento\Tax\Api\Data\OrderTaxDetailsAppliedTaxInterface[]|null
     */
    public function getAppliedTaxes()
    {
        return $this->_get('applied_taxes');
    }

    /**
     * @param \Magento\Tax\Api\Data\OrderTaxDetailsAppliedTaxInterface[] $appliedTaxes
     * @return $this
     */
    public function setAppliedTaxes($appliedTaxes)
    {
        $this->setData('applied_taxes', $appliedTaxes);
        return $this;
    }

    /**
     * @return \Magento\Tax\Api\Data\OrderTaxDetailsItemInterface[]|null
     */
    public function getItemAppliedTaxes()
    {
        return $this->_get('item_applied_taxes');
    }

    /**
     * @param \Magento\Tax\Api\Data\OrderTaxDetailsItemInterface[] $itemAppliedTaxes
     * @return $this
     */
    public function setItemAppliedTaxes($itemAppliedTaxes)
    {
        $this->setData('item_applied_taxes', $itemAppliedTaxes);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getConvertingFromQuote()
    {
        return $this->_get('converting_from_quote');
    }

    /**
     * @param boolean $convertingFromQuote
     * @return $this
     */
    public function setConvertingFromQuote($convertingFromQuote)
    {
        $this->setData('converting_from_quote', $convertingFromQuote);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmextrafeeFeeId()
    {
        return $this->_get('amextrafee_fee_id');
    }

    /**
     * @param string $amextrafeeFeeId
     * @return $this
     */
    public function setAmextrafeeFeeId($amextrafeeFeeId)
    {
        $this->setData('amextrafee_fee_id', $amextrafeeFeeId);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmextrafeeFeeAmount()
    {
        return $this->_get('amextrafee_fee_amount');
    }

    /**
     * @param float $amextrafeeFeeAmount
     * @return $this
     */
    public function setAmextrafeeFeeAmount($amextrafeeFeeAmount)
    {
        $this->setData('amextrafee_fee_amount', $amextrafeeFeeAmount);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmextrafeeBaseFeeAmount()
    {
        return $this->_get('amextrafee_base_fee_amount');
    }

    /**
     * @param float $amextrafeeBaseFeeAmount
     * @return $this
     */
    public function setAmextrafeeBaseFeeAmount($amextrafeeBaseFeeAmount)
    {
        $this->setData('amextrafee_base_fee_amount', $amextrafeeBaseFeeAmount);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmextrafeeTaxAmount()
    {
        return $this->_get('amextrafee_tax_amount');
    }

    /**
     * @param float $amextrafeeTaxAmount
     * @return $this
     */
    public function setAmextrafeeTaxAmount($amextrafeeTaxAmount)
    {
        $this->setData('amextrafee_tax_amount', $amextrafeeTaxAmount);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmextrafeeBaseTaxAmount()
    {
        return $this->_get('amextrafee_base_tax_amount');
    }

    /**
     * @param float $amextrafeeBaseTaxAmount
     * @return $this
     */
    public function setAmextrafeeBaseTaxAmount($amextrafeeBaseTaxAmount)
    {
        $this->setData('amextrafee_base_tax_amount', $amextrafeeBaseTaxAmount);
        return $this;
    }
}
