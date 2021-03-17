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

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Profiler;
use Mageplaza\AutoRelated\Model\Rule;

/**
 * Class ReindexRuleProduct
 * @package Mageplaza\AutoRelated\Model\Indexer
 */
class ReindexRuleProduct
{
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * ReindexRuleProduct constructor.
     *
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Reindex information about rule relations with products.
     *
     * @param Rule $rule
     * @param $batchCount
     *
     * @return bool
     */
    public function execute(Rule $rule, $batchCount)
    {
        if (!$rule->getIsActive()) {
            return false;
        }

        $connection = $this->resource->getConnection();

        Profiler::start('__MATCH_PRODUCTS__');
        $productIds = $rule->getMatchingProductIds();
        Profiler::stop('__MATCH_PRODUCTS__');

        $indexTable = $this->resource->getTableName('mageplaza_autorelated_actions_index');

        $ruleId = $rule->getId();
        $rows   = [];

        foreach ($productIds as $productId) {
            $rows[] = [
                'rule_id'    => $ruleId,
                'product_id' => $productId
            ];

            if (count($rows) == $batchCount) {
                $connection->insertMultiple($indexTable, $rows);
                $rows = [];
            }
        }
        if (!empty($rows)) {
            $connection->insertMultiple($indexTable, $rows);
        }

        return true;
    }
}
