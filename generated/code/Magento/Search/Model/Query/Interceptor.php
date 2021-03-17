<?php
namespace Magento\Search\Model\Query;

/**
 * Interceptor class for @see \Magento\Search\Model\Query
 */
class Interceptor extends \Magento\Search\Model\Query implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Search\Model\ResourceModel\Query\CollectionFactory $queryCollectionFactory, \Magento\Search\Model\SearchCollectionFactory $searchCollectionFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $queryCollectionFactory, $searchCollectionFactory, $storeManager, $scopeConfig, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function loadByQueryText($text)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'loadByQueryText');
        if (!$pluginInfo) {
            return parent::loadByQueryText($text);
        } else {
            return $this->___callPlugins('loadByQueryText', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function saveIncrementalPopularity()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'saveIncrementalPopularity');
        if (!$pluginInfo) {
            return parent::saveIncrementalPopularity();
        } else {
            return $this->___callPlugins('saveIncrementalPopularity', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function saveNumResults($numResults)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'saveNumResults');
        if (!$pluginInfo) {
            return parent::saveNumResults($numResults);
        } else {
            return $this->___callPlugins('saveNumResults', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($modelId, $field = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        if (!$pluginInfo) {
            return parent::load($modelId, $field);
        } else {
            return $this->___callPlugins('load', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        if (!$pluginInfo) {
            return parent::save();
        } else {
            return $this->___callPlugins('save', func_get_args(), $pluginInfo);
        }
    }
}
