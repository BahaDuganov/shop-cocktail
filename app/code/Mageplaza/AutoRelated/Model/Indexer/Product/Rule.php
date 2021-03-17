<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AutoRelated
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AutoRelated\Model\Indexer\Product;

use Magento\Catalog\Model\Product;
use Magento\CatalogRule\Model\Indexer\AbstractIndexer;
use Magento\CatalogRule\Model\Indexer\IndexBuilder;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\AutoRelated\Model\Indexer\RuleIndexer;

/**
 * Class Rule
 * @package Mageplaza\AutoRelated\Model\Indexer\Product
 */
class Rule extends AbstractIndexer
{
    /**
     * @var CacheInterface
     */
    private $cacheManager;

    /**
     * @var RuleIndexer
     */
    protected $_ruleindex;

    /**
     * Rule constructor.
     *
     * @param IndexBuilder $indexBuilder
     * @param ManagerInterface $eventManager
     * @param RuleIndexer $ruleIndexer
     */
    public function __construct(
        IndexBuilder $indexBuilder,
        ManagerInterface $eventManager,
        RuleIndexer $ruleIndexer
    ) {
        parent::__construct($indexBuilder, $eventManager);

        $this->_ruleindex = $ruleIndexer;
    }

    /**
     * Execute full indexation
     *
     * @return void
     * @throws LocalizedException
     */
    public function executeFull()
    {
        $this->_ruleindex->reindexFull();
        $this->_eventManager->dispatch('clean_cache_by_tags', ['object' => $this]);
        $this->getCacheManager()->clean($this->getIdentities());
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecuteList($ids)
    {
        $this->_ruleindex->reindexByIds(array_unique($ids));
        $this->getCacheContext()->registerEntities(Product::CACHE_TAG, $ids);
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecuteRow($id)
    {
        $this->_ruleindex->reindexById($id);
    }

    /**
     * @return CacheInterface|mixed
     *
     * @deprecated 100.0.7
     */
    private function getCacheManager()
    {
        if ($this->cacheManager === null) {
            $this->cacheManager = ObjectManager::getInstance()->get(
                CacheInterface::class
            );
        }

        return $this->cacheManager;
    }
}
