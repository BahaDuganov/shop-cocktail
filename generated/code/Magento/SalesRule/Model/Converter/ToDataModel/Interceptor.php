<?php
namespace Magento\SalesRule\Model\Converter\ToDataModel;

/**
 * Interceptor class for @see \Magento\SalesRule\Model\Converter\ToDataModel
 */
class Interceptor extends \Magento\SalesRule\Model\Converter\ToDataModel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\SalesRule\Model\RuleFactory $ruleFactory, \Magento\SalesRule\Api\Data\RuleInterfaceFactory $ruleDataFactory, \Magento\SalesRule\Api\Data\ConditionInterfaceFactory $conditionDataFactory, \Magento\SalesRule\Api\Data\RuleLabelInterfaceFactory $ruleLabelFactory, \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null, ?\Magento\SalesRule\Api\Data\RuleExtensionFactory $extensionFactory = null)
    {
        $this->___init();
        parent::__construct($ruleFactory, $ruleDataFactory, $conditionDataFactory, $ruleLabelFactory, $dataObjectProcessor, $serializer, $extensionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function toDataModel(\Magento\SalesRule\Model\Rule $ruleModel)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toDataModel');
        if (!$pluginInfo) {
            return parent::toDataModel($ruleModel);
        } else {
            return $this->___callPlugins('toDataModel', func_get_args(), $pluginInfo);
        }
    }
}
