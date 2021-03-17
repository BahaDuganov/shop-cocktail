<?php
namespace Magento\CatalogRule\Model\Indexer\RuleProductPricesPersistor;

/**
 * Interceptor class for @see \Magento\CatalogRule\Model\Indexer\RuleProductPricesPersistor
 */
class Interceptor extends \Magento\CatalogRule\Model\Indexer\RuleProductPricesPersistor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Stdlib\DateTime $dateFormat, \Magento\Framework\App\ResourceConnection $resource, \Magento\Catalog\Model\ResourceModel\Indexer\ActiveTableSwitcher $activeTableSwitcher, ?\Magento\CatalogRule\Model\Indexer\IndexerTableSwapperInterface $tableSwapper = null)
    {
        $this->___init();
        parent::__construct($dateFormat, $resource, $activeTableSwitcher, $tableSwapper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array $priceData, $useAdditionalTable = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute($priceData, $useAdditionalTable);
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
