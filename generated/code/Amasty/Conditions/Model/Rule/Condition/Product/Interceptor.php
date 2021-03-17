<?php
namespace Amasty\Conditions\Model\Rule\Condition\Product;

/**
 * Interceptor class for @see \Amasty\Conditions\Model\Rule\Condition\Product
 */
class Interceptor extends \Amasty\Conditions\Model\Rule\Condition\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\CatalogInventory\Api\StockStateInterface $stockItem, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $stockItem, $data);
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
