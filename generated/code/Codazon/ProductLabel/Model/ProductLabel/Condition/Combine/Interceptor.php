<?php
namespace Codazon\ProductLabel\Model\ProductLabel\Condition\Combine;

/**
 * Interceptor class for @see \Codazon\ProductLabel\Model\ProductLabel\Condition\Combine
 */
class Interceptor extends \Codazon\ProductLabel\Model\ProductLabel\Condition\Combine implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory $conditionFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $conditionFactory, $data);
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
