<?php
namespace Magento\Framework\Search\Request;

/**
 * Interceptor class for @see \Magento\Framework\Search\Request
 */
class Interceptor extends \Magento\Framework\Search\Request implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($name, $indexName, \Magento\Framework\Search\Request\QueryInterface $query, $from = null, $size = null, array $dimensions = [], array $buckets = [], $sort = [])
    {
        $this->___init();
        parent::__construct($name, $indexName, $query, $from, $size, $dimensions, $buckets, $sort);
    }

    /**
     * {@inheritdoc}
     */
    public function getSort()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSort');
        if (!$pluginInfo) {
            return parent::getSort();
        } else {
            return $this->___callPlugins('getSort', func_get_args(), $pluginInfo);
        }
    }
}
