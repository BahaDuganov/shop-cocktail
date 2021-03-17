<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\GetDeliveryInformation;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\GetDeliveryInformation
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\GetDeliveryInformation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\CheckoutGraphQl\Model\Utils\CartProvider $cartProvider, \Amasty\Checkout\Model\Delivery $delivery)
    {
        $this->___init();
        parent::__construct($cartProvider, $delivery);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        if (!$pluginInfo) {
            return parent::resolve($field, $context, $info, $value, $args);
        } else {
            return $this->___callPlugins('resolve', func_get_args(), $pluginInfo);
        }
    }
}
