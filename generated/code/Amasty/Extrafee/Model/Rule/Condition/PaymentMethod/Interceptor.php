<?php
namespace Amasty\Extrafee\Model\Rule\Condition\PaymentMethod;

/**
 * Interceptor class for @see \Amasty\Extrafee\Model\Rule\Condition\PaymentMethod
 */
class Interceptor extends \Amasty\Extrafee\Model\Rule\Condition\PaymentMethod implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Payment\Model\Config\Source\Allmethods $allMethods, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $allMethods, $data);
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
