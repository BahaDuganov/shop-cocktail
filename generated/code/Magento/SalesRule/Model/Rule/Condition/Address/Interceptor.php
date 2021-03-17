<?php
namespace Magento\SalesRule\Model\Rule\Condition\Address;

/**
 * Interceptor class for @see \Magento\SalesRule\Model\Rule\Condition\Address
 */
class Interceptor extends \Magento\SalesRule\Model\Rule\Condition\Address implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Directory\Model\Config\Source\Country $directoryCountry, \Magento\Directory\Model\Config\Source\Allregion $directoryAllregion, \Magento\Shipping\Model\Config\Source\Allmethods $shippingAllmethods, \Magento\Payment\Model\Config\Source\Allmethods $paymentAllmethods, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $directoryCountry, $directoryAllregion, $shippingAllmethods, $paymentAllmethods, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getValueParsed()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getValueParsed');
        if (!$pluginInfo) {
            return parent::getValueParsed();
        } else {
            return $this->___callPlugins('getValueParsed', func_get_args(), $pluginInfo);
        }
    }
}
