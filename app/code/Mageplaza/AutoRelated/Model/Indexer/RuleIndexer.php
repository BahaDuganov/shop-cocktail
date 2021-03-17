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

namespace Mageplaza\AutoRelated\Model\Indexer;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\AutoRelated\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Mageplaza\AutoRelated\Model\Rule;
use Psr\Log\LoggerInterface;

/**
 * Class RuleIndexer
 * @package Mageplaza\AutoRelated\Model\Indexer
 */
class RuleIndexer
{
    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var AdapterInterface
     */
    protected $connection;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var ReindexRuleProduct
     */
    private $reindexRuleProduct;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ProductLoader
     */
    private $productLoader;

    /**
     * RuleIndexer constructor.
     *
     * @param ResourceConnection $resource
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param ReindexRuleProduct $reindexRuleProduct
     * @param LoggerInterface $logger
     * @param ProductLoader|null $productLoader
     */
    public function __construct(
        ResourceConnection $resource,
        RuleCollectionFactory $ruleCollectionFactory,
        ReindexRuleProduct $reindexRuleProduct,
        LoggerInterface $logger,
        ProductLoader $productLoader = null
    ) {
        $this->resource              = $resource;
        $this->connection            = $resource->getConnection();
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->reindexRuleProduct    = $reindexRuleProduct;
        $this->logger                = $logger;
        $this->productLoader         = $productLoader ?: ObjectManager::getInstance()->get(ProductLoader::class);
    }

    /**
     * Reindex by id
     *
     * @param int $id
     *
     * @return void
     * @throws LocalizedException
     * @api
     */
    public function reindexById($id)
    {
        $this->reindexByIds([$id]);
    }

    /**
     * Reindex by ids
     *
     * @param array $ids
     *
     * @return void
     * @throws LocalizedException
     * @api
     */
    public function reindexByIds(array $ids)
    {
        try {
            $this->doReindexByIds($ids);
        } catch (Exception $e) {
            $this->critical($e);
            throw new LocalizedException(
                __("Mageplaza AutoRelated indexing failed. See details in exception log.")
            );
        }
    }

    /**
     * Reindex by ids. Template method
     *
     * @param array $ids
     *
     * @return void
     * @throws Exception
     */
    protected function doReindexByIds($ids)
    {
        $this->cleanByIds($ids);

        $products = $this->productLoader->getProducts($ids);
        foreach ($this->getActiveRules() as $rule) {
            foreach ($products as $product) {
                $this->applyRule($rule, $product);
            }
        }
    }

    /**
     * Full reindex
     *
     * @return void
     * @throws LocalizedException
     * @api
     */
    public function reindexFull()
    {
        try {
            $this->doReindexFull();
        } catch (Exception $e) {
            $this->critical($e);
            throw new LocalizedException(
                __("Mageplaza AutoRelated indexing failed. See details in exception log.")
            );
        }
    }

    /**
     * Full reindex Template method
     *
     * @return void
     */
    protected function doReindexFull()
    {
        $this->connection->truncateTable(
            $this->getTable('mageplaza_autorelated_actions_index')
        );

        foreach ($this->getAllRules() as $rule) {
            $this->reindexRuleProduct->execute($rule, 1000);
        }
    }

    /**
     * Clean by product ids
     *
     * @param array $productIds
     *
     * @return void
     */
    protected function cleanByIds($productIds)
    {
        $query = $this->connection->deleteFromSelect(
            $this->connection
                ->select()
                ->from($this->resource->getTableName('mageplaza_autorelated_actions_index'), 'product_id')
                ->distinct()
                ->where('product_id IN (?)', $productIds),
            $this->resource->getTableName('mageplaza_autorelated_actions_index')
        );
        $this->connection->query($query);
    }

    /**
     * @param Rule $rule
     * @param Product $product
     *
     * @return $this
     * @throws Exception
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function applyRule(Rule $rule, $product)
    {
        $ruleId          = $rule->getId();
        $productEntityId = $product->getId();

        if (!$rule->validate($product)) {
            return $this;
        }

        $this->connection->delete(
            $this->resource->getTableName('mageplaza_autorelated_actions_index'),
            [
                $this->connection->quoteInto('rule_id = ?', $ruleId),
                $this->connection->quoteInto('product_id = ?', $productEntityId)
            ]
        );

        $rows = [];
        try {
            $rows[] = [
                'rule_id'    => $ruleId,
                'product_id' => $productEntityId,
            ];

            if (count($rows) == 1000) {
                $this->connection->insertMultiple($this->getTable('mageplaza_autorelated_actions_index'), $rows);
                $rows = [];
            }

            if (!empty($rows)) {
                $this->connection->insertMultiple(
                    $this->resource->getTableName('mageplaza_autorelated_actions_index'),
                    $rows
                );
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @param string $tableName
     *
     * @return string
     */
    protected function getTable($tableName)
    {
        return $this->resource->getTableName($tableName);
    }

    /**
     * Get active rules
     *
     * @return array
     */
    protected function getAllRules()
    {
        return $this->ruleCollectionFactory->create();
    }

    /**
     * Get active rules
     *
     * @return array
     */
    protected function getActiveRules()
    {
        return $this->getAllRules()->addFieldToFilter('is_active', 1);
    }

    /**
     * @param Exception $e
     *
     * @return void
     */
    protected function critical($e)
    {
        $this->logger->critical($e);
    }
}
