<?php
namespace Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\DefaultPrice;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\DefaultPrice
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\DefaultPrice implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Framework\Indexer\Table\StrategyInterface $tableStrategy, \Magento\Eav\Model\Config $eavConfig, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\Module\Manager $moduleManager, $connectionName = null, ?\Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\IndexTableStructureFactory $indexTableStructureFactory = null, array $priceModifiers = [])
    {
        $this->___init();
        parent::__construct($context, $tableStrategy, $eavConfig, $eventManager, $moduleManager, $connectionName, $indexTableStructureFactory, $priceModifiers);
    }

    /**
     * {@inheritdoc}
     */
    public function reindexAll()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'reindexAll');
        if (!$pluginInfo) {
            return parent::reindexAll();
        } else {
            return $this->___callPlugins('reindexAll', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reindexEntity($entityIds)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'reindexEntity');
        if (!$pluginInfo) {
            return parent::reindexEntity($entityIds);
        } else {
            return $this->___callPlugins('reindexEntity', func_get_args(), $pluginInfo);
        }
    }
}
