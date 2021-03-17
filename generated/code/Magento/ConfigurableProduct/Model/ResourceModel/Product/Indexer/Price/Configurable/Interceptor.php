<?php
namespace Magento\ConfigurableProduct\Model\ResourceModel\Product\Indexer\Price\Configurable;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Model\ResourceModel\Product\Indexer\Price\Configurable
 */
class Interceptor extends \Magento\ConfigurableProduct\Model\ResourceModel\Product\Indexer\Price\Configurable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\Query\BaseFinalPrice $baseFinalPrice, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\IndexTableStructureFactory $indexTableStructureFactory, \Magento\Catalog\Model\Indexer\Product\Price\TableMaintainer $tableMaintainer, \Magento\Framework\EntityManager\MetadataPool $metadataPool, \Magento\Framework\App\ResourceConnection $resource, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\BasePriceModifier $basePriceModifier, $fullReindexAction = false, $connectionName = 'indexer', ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null)
    {
        $this->___init();
        parent::__construct($baseFinalPrice, $indexTableStructureFactory, $tableMaintainer, $metadataPool, $resource, $basePriceModifier, $fullReindexAction, $connectionName, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function executeByDimensions(array $dimensions, \Traversable $entityIds)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeByDimensions');
        if (!$pluginInfo) {
            return parent::executeByDimensions($dimensions, $entityIds);
        } else {
            return $this->___callPlugins('executeByDimensions', func_get_args(), $pluginInfo);
        }
    }
}
