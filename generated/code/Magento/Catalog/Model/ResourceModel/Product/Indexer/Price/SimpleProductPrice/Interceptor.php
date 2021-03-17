<?php
namespace Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\SimpleProductPrice;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\SimpleProductPrice
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\SimpleProductPrice implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\Query\BaseFinalPrice $baseFinalPrice, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\IndexTableStructureFactory $indexTableStructureFactory, \Magento\Catalog\Model\Indexer\Product\Price\TableMaintainer $tableMaintainer, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\BasePriceModifier $basePriceModifier, $productType = 'simple')
    {
        $this->___init();
        parent::__construct($baseFinalPrice, $indexTableStructureFactory, $tableMaintainer, $basePriceModifier, $productType);
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
