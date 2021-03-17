<?php
namespace Amasty\RulesPro\Model\Rule\Condition\Customer;

/**
 * Interceptor class for @see \Amasty\RulesPro\Model\Rule\Condition\Customer
 */
class Interceptor extends \Amasty\RulesPro\Model\Rule\Condition\Customer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Customer\Model\ResourceModel\Customer $resource, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Customer\Model\Session $customerSession, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $resource, $customerFactory, $customerSession, $data);
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
