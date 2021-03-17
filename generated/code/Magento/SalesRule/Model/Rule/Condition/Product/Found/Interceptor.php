<?php
namespace Magento\SalesRule\Model\Rule\Condition\Product\Found;

/**
 * Interceptor class for @see \Magento\SalesRule\Model\Rule\Condition\Product\Found
 */
class Interceptor extends \Magento\SalesRule\Model\Rule\Condition\Product\Found implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\SalesRule\Model\Rule\Condition\Product $ruleConditionProduct, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $ruleConditionProduct, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validate');
        if (!$pluginInfo) {
            return parent::validate($model);
        } else {
            return $this->___callPlugins('validate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNewChildSelectOptions()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getNewChildSelectOptions');
        if (!$pluginInfo) {
            return parent::getNewChildSelectOptions();
        } else {
            return $this->___callPlugins('getNewChildSelectOptions', func_get_args(), $pluginInfo);
        }
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
