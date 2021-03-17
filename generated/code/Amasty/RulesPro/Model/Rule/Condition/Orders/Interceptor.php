<?php
namespace Amasty\RulesPro\Model\Rule\Condition\Orders;

/**
 * Interceptor class for @see \Amasty\RulesPro\Model\Rule\Condition\Orders
 */
class Interceptor extends \Amasty\RulesPro\Model\Rule\Condition\Orders implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Amasty\RulesPro\Model\ResourceModel\Order $orderResource, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $orderResource, $data);
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
