<?php
namespace Magento\CatalogSearch\Model\Search\RequestGenerator;

/**
 * Interceptor class for @see \Magento\CatalogSearch\Model\Search\RequestGenerator
 */
class Interceptor extends \Magento\CatalogSearch\Model\Search\RequestGenerator implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $productAttributeCollectionFactory, ?\Magento\CatalogSearch\Model\Search\RequestGenerator\GeneratorResolver $generatorResolver = null)
    {
        $this->___init();
        parent::__construct($productAttributeCollectionFactory, $generatorResolver);
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
