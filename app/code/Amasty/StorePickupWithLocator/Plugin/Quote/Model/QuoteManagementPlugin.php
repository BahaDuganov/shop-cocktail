<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_StorePickupWithLocator
 */


namespace Amasty\StorePickupWithLocator\Plugin\Quote\Model;

use Amasty\StorePickupWithLocator\Model\Carrier\Shipping;
use Magento\Braintree\Model\Ui\PayPal\ConfigProvider as BraintreeConfig;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Model\Order\Address;

class QuoteManagementPlugin
{
    /**
     * @var CartRepositoryInterface
     */
    private $quoteRepository;

    public function __construct(
        CartRepositoryInterface $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param QuoteManagement $subject
     * @param $cartId
     * @param PaymentInterface|null $paymentMethod
     */
    public function beforePlaceOrder(
        QuoteManagement $subject,
        $cartId,
        PaymentInterface $paymentMethod = null
    ) {
        $quote = $this->quoteRepository->getActive($cartId);
        if ($quote->getPayment()->getMethod() == BraintreeConfig::PAYPAL_CODE
            && $quote->getShippingAddress()->getShippingMethod() == Shipping::SHIPPING_NAME
        ) {
            $shipping = $quote->getShippingAddress();
            $cloneShippingObject = clone $shipping;
            $cloneShippingObject->setId(null);
            $cloneShippingObject->setAddressType(Address::TYPE_BILLING);
            $quote->setBillingAddress($cloneShippingObject);
            $quote->setDataChanges(true);
        }
    }
}
