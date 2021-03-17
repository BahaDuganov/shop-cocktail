<?php
namespace Amasty\Shopby\Model\Search\RequestGenerator;

/**
 * Interceptor class for @see \Amasty\Shopby\Model\Search\RequestGenerator
 */
class Interceptor extends \Amasty\Shopby\Model\Search\RequestGenerator implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $productAttributeCollectionFactory, \Amasty\Shopby\Helper\FilterSetting $settingHelper)
    {
        $this->___init();
        parent::__construct($productAttributeCollectionFactory, $settingHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'generate');
        if (!$pluginInfo) {
            return parent::generate();
        } else {
            return $this->___callPlugins('generate', func_get_args(), $pluginInfo);
        }
    }
}
