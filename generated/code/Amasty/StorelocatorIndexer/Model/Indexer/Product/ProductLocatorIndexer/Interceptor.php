<?php
namespace Amasty\StorelocatorIndexer\Model\Indexer\Product\ProductLocatorIndexer;

/**
 * Interceptor class for @see \Amasty\StorelocatorIndexer\Model\Indexer\Product\ProductLocatorIndexer
 */
class Interceptor extends \Amasty\StorelocatorIndexer\Model\Indexer\Product\ProductLocatorIndexer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\StorelocatorIndexer\Model\Indexer\AbstractIndexBuilder $indexBuilder, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\Indexer\CacheContext $cacheContext)
    {
        $this->___init();
        parent::__construct($indexBuilder, $eventManager, $cacheContext);
    }

    /**
     * {@inheritdoc}
     */
    public function executeFull()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeFull');
        if (!$pluginInfo) {
            return parent::executeFull();
        } else {
            return $this->___callPlugins('executeFull', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeList(array $ids)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeList');
        if (!$pluginInfo) {
            return parent::executeList($ids);
        } else {
            return $this->___callPlugins('executeList', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeRow($id)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeRow');
        if (!$pluginInfo) {
            return parent::executeRow($id);
        } else {
            return $this->___callPlugins('executeRow', func_get_args(), $pluginInfo);
        }
    }
}
