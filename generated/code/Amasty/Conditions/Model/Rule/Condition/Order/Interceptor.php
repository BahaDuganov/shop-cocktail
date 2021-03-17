<?php
namespace Amasty\Conditions\Model\Rule\Condition\Order;

/**
 * Interceptor class for @see \Amasty\Conditions\Model\Rule\Condition\Order
 */
class Interceptor extends \Amasty\Conditions\Model\Rule\Condition\Order implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Amasty\Conditions\Model\Order\ResourceModel\CollectionFactory $reportsFactory, \Magento\SalesRule\Model\Rule\Condition\Product $ruleConditionProduct, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $reportsFactory, $ruleConditionProduct, $data);
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
