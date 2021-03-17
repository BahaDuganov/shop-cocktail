<?php
namespace Magento\Elasticsearch\SearchAdapter\Aggregation\Builder\Term;

/**
 * Interceptor class for @see \Magento\Elasticsearch\SearchAdapter\Aggregation\Builder\Term
 */
class Interceptor extends \Magento\Elasticsearch\SearchAdapter\Aggregation\Builder\Term implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function build(\Magento\Framework\Search\Request\BucketInterface $bucket, array $dimensions, array $queryResult, \Magento\Framework\Search\Dynamic\DataProviderInterface $dataProvider)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'build');
        if (!$pluginInfo) {
            return parent::build($bucket, $dimensions, $queryResult, $dataProvider);
        } else {
            return $this->___callPlugins('build', func_get_args(), $pluginInfo);
        }
    }
}
