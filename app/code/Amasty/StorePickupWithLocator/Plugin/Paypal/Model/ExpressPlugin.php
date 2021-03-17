<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_StorePickupWithLocator
 */


namespace Amasty\StorePickupWithLocator\Plugin\Paypal\Model;

use Amasty\StorePickupWithLocator\Controller\Paypal\SaveShippingAddress;
use Amasty\StorePickupWithLocator\Model\Carrier\Shipping;
use Magento\Braintree\Model\Ui\PayPal\ConfigProvider as BraintreeConfig;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Payment\Model\InfoInterface;
use Magento\Paypal\Model\Config;
use Magento\Paypal\Model\Express;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * reset shipping address to default for match address on paypal
 * we return the location address to back in Observer/Sales/Order/AfterPlaceOrder.php
 */
class ExpressPlugin
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        CheckoutSession $checkoutSession,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Express $subject
     * @param InfoInterface $payment
     * @param float $amount
     */
    public function beforeOrder(Express $subject, InfoInterface $payment, $amount)
    {
        $paymentMethod = $payment->getMethod();
        /** @var Order $order */
        $order = $payment->getOrder();
        if (($paymentMethod === BraintreeConfig::PAYPAL_CODE || $paymentMethod === Config::METHOD_EXPRESS)
            && $order->getShippingMethod() === Shipping::SHIPPING_NAME
            && $stepData = $this->checkoutSession->getStepData(
                'checkout',
                SaveShippingAddress::DEFAULT_SHIPPING_ADDRESS . '_' . $order->getQuoteId()
            )
        ) {
            $order->getShippingAddress()->setData($stepData);
        }
    }
}
