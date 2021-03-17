<?php
namespace Amasty\ElasticSearch\Model\Indexer\Structure\EntityBuilder\Product;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Indexer\Structure\EntityBuilder\Product
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Indexer\Structure\EntityBuilder\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Eav\Model\Config $eavConfig, \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $customerGroupCollectionFactory)
    {
        $this->___init();
        parent::__construct($eavConfig, $customerGroupCollectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEntityFields()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'buildEntityFields');
        if (!$pluginInfo) {
            return parent::buildEntityFields();
        } else {
            return $this->___callPlugins('buildEntityFields', func_get_args(), $pluginInfo);
        }
    }
}
