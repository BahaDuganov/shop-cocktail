<?php
namespace Magento\Catalog\Model\Indexer\Product\Eav\Action\Full;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Indexer\Product\Eav\Action\Full
 */
class Interceptor extends \Magento\Catalog\Model\Indexer\Product\Eav\Action\Full implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\DecimalFactory $eavDecimalFactory, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\SourceFactory $eavSourceFactory, ?\Magento\Framework\EntityManager\MetadataPool $metadataPool = null, ?\Magento\Framework\Indexer\BatchProviderInterface $batchProvider = null, ?\Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\BatchSizeCalculator $batchSizeCalculator = null, ?\Magento\Catalog\Model\ResourceModel\Indexer\ActiveTableSwitcher $activeTableSwitcher = null, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null, ?\Magento\Framework\DB\Query\Generator $batchQueryGenerator = null)
    {
        $this->___init();
        parent::__construct($eavDecimalFactory, $eavSourceFactory, $metadataPool, $batchProvider, $batchSizeCalculator, $activeTableSwitcher, $scopeConfig, $batchQueryGenerator);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($ids = null) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            parent::execute($ids);
        } else {
            $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
