<?php
namespace Magento\Elasticsearch\Elasticsearch5\SearchAdapter\Mapper;

/**
 * Interceptor class for @see \Magento\Elasticsearch\Elasticsearch5\SearchAdapter\Mapper
 */
class Interceptor extends \Magento\Elasticsearch\Elasticsearch5\SearchAdapter\Mapper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Elasticsearch\Elasticsearch5\SearchAdapter\Query\Builder $queryBuilder, \Magento\Elasticsearch\SearchAdapter\Query\Builder\Match $matchQueryBuilder, \Magento\Elasticsearch\SearchAdapter\Filter\Builder $filterBuilder)
    {
        $this->___init();
        parent::__construct($queryBuilder, $matchQueryBuilder, $filterBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function buildQuery(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'buildQuery');
        if (!$pluginInfo) {
            return parent::buildQuery($request);
        } else {
            return $this->___callPlugins('buildQuery', func_get_args(), $pluginInfo);
        }
    }
}
