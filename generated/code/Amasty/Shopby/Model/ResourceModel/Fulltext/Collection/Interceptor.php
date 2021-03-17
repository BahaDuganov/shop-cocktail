<?php
namespace Amasty\Shopby\Model\ResourceModel\Fulltext\Collection;

/**
 * Interceptor class for @see \Amasty\Shopby\Model\ResourceModel\Fulltext\Collection
 */
class Interceptor extends \Amasty\Shopby\Model\ResourceModel\Fulltext\Collection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Eav\Model\Config $eavConfig, \Magento\Framework\App\ResourceConnection $resource, \Magento\Eav\Model\EntityFactory $eavEntityFactory, \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper, \Magento\Framework\Validator\UniversalFactory $universalFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Module\Manager $moduleManager, \Magento\Catalog\Model\Indexer\Product\Flat\State $catalogProductFlatState, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory, \Magento\Catalog\Model\ResourceModel\Url $catalogUrl, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Customer\Api\GroupManagementInterface $groupManagement, \Magento\Search\Model\QueryFactory $queryFactory, \Amasty\Shopby\Model\Request\BuilderFactory $requestBuilderFactory, \Magento\Search\Model\SearchEngine $searchEngine, \Magento\Framework\Search\Adapter\Mysql\TemporaryStorageFactory $temporaryStorageFactory, \Amasty\Shopby\Model\Layer\Cms\Manager $cmsManager, \Magento\CatalogInventory\Helper\Stock $stockHelper, \Amasty\Shopby\Helper\Group $groupHelper, \Amasty\Shopby\Model\Search\EmptyResponseFactory $emptyResponseFactory, $connection = null, $searchRequestName = 'catalog_view_container')
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $resource, $eavEntityFactory, $resourceHelper, $universalFactory, $storeManager, $moduleManager, $catalogProductFlatState, $scopeConfig, $productOptionFactory, $catalogUrl, $localeDate, $customerSession, $dateTime, $groupManagement, $queryFactory, $requestBuilderFactory, $searchEngine, $temporaryStorageFactory, $cmsManager, $stockHelper, $groupHelper, $emptyResponseFactory, $connection, $searchRequestName);
    }

    /**
     * {@inheritdoc}
     */
    public function getFacetedData($field, ?\Magento\Framework\Search\Response\QueryResponse $outerResponse = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFacetedData');
        if (!$pluginInfo) {
            return parent::getFacetedData($field, $outerResponse);
        } else {
            return $this->___callPlugins('getFacetedData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($printQuery = false, $logQuery = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        if (!$pluginInfo) {
            return parent::load($printQuery, $logQuery);
        } else {
            return $this->___callPlugins('load', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectCountSql()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelectCountSql');
        if (!$pluginInfo) {
            return parent::getSelectCountSql();
        } else {
            return $this->___callPlugins('getSelectCountSql', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItems');
        if (!$pluginInfo) {
            return parent::getItems();
        } else {
            return $this->___callPlugins('getItems', func_get_args(), $pluginInfo);
        }
    }
}
