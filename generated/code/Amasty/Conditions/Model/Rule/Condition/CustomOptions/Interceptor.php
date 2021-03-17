<?php
namespace Amasty\Conditions\Model\Rule\Condition\CustomOptions;

/**
 * Interceptor class for @see \Amasty\Conditions\Model\Rule\Condition\CustomOptions
 */
class Interceptor extends \Amasty\Conditions\Model\Rule\Condition\CustomOptions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Backend\Model\UrlInterface $url, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $url, $data);
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
