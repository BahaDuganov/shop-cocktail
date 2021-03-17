<?php
namespace Magento\CatalogWidget\Model\Rule\Condition\Combine;

/**
 * Interceptor class for @see \Magento\CatalogWidget\Model\Rule\Condition\Combine
 */
class Interceptor extends \Magento\CatalogWidget\Model\Rule\Condition\Combine implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory $conditionFactory, array $data = [], array $excludedAttributes = [])
    {
        $this->___init();
        parent::__construct($context, $conditionFactory, $data, $excludedAttributes);
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
