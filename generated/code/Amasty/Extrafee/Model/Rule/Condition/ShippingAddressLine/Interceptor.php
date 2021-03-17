<?php
namespace Amasty\Extrafee\Model\Rule\Condition\ShippingAddressLine;

/**
 * Interceptor class for @see \Amasty\Extrafee\Model\Rule\Condition\ShippingAddressLine
 */
class Interceptor extends \Amasty\Extrafee\Model\Rule\Condition\ShippingAddressLine implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
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
