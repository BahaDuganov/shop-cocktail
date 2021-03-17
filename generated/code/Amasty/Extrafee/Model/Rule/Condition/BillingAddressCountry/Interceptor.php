<?php
namespace Amasty\Extrafee\Model\Rule\Condition\BillingAddressCountry;

/**
 * Interceptor class for @see \Amasty\Extrafee\Model\Rule\Condition\BillingAddressCountry
 */
class Interceptor extends \Amasty\Extrafee\Model\Rule\Condition\BillingAddressCountry implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Directory\Model\Config\Source\Country $country, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $country, $data);
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
