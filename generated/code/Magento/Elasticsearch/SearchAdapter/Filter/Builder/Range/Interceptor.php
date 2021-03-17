<?php
namespace Magento\Elasticsearch\SearchAdapter\Filter\Builder\Range;

/**
 * Interceptor class for @see \Magento\Elasticsearch\SearchAdapter\Filter\Builder\Range
 */
class Interceptor extends \Magento\Elasticsearch\SearchAdapter\Filter\Builder\Range implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Elasticsearch\Model\Adapter\FieldMapperInterface $fieldMapper)
    {
        $this->___init();
        parent::__construct($fieldMapper);
    }

    /**
     * {@inheritdoc}
     */
    public function buildFilter(\Magento\Framework\Search\Request\FilterInterface $filter)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'buildFilter');
        if (!$pluginInfo) {
            return parent::buildFilter($filter);
        } else {
            return $this->___callPlugins('buildFilter', func_get_args(), $pluginInfo);
        }
    }
}
