<?php
namespace Amasty\RulesPro\Model\Rule\Condition\Total;

/**
 * Interceptor class for @see \Amasty\RulesPro\Model\Rule\Condition\Total
 */
class Interceptor extends \Amasty\RulesPro\Model\Rule\Condition\Total implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\RulesPro\Helper\Calculator $calculator, \Magento\Rule\Model\Condition\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($calculator, $context, $data);
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
