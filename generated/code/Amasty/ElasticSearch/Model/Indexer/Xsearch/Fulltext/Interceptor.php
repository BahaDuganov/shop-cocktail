<?php
namespace Amasty\ElasticSearch\Model\Indexer\Xsearch\Fulltext;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Indexer\Xsearch\Fulltext
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Indexer\Xsearch\Fulltext implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Indexer\CacheContext $cacheContext, \Amasty\ElasticSearch\Model\Debug $debug, \Magento\Framework\App\State $appState, \Amasty\ElasticSearch\Model\Config $config, \Amasty\ElasticSearch\Model\Client\Elasticsearch $elasticClient, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($cacheContext, $debug, $appState, $config, $elasticClient, $storeManager);
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
    public function executeRow($id)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeRow');
        if (!$pluginInfo) {
            return parent::executeRow($id);
        } else {
            return $this->___callPlugins('executeRow', func_get_args(), $pluginInfo);
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
}
