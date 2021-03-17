<?php
namespace Magento\Elasticsearch\SearchAdapter\Query\Builder\Sort;

/**
 * Interceptor class for @see \Magento\Elasticsearch\SearchAdapter\Query\Builder\Sort
 */
class Interceptor extends \Magento\Elasticsearch\SearchAdapter\Query\Builder\Sort implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\AttributeProvider $attributeAdapterProvider, \Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\FieldProvider\FieldName\ResolverInterface $fieldNameResolver, array $skippedFields = [], array $map = [])
    {
        $this->___init();
        parent::__construct($attributeAdapterProvider, $fieldNameResolver, $skippedFields, $map);
    }

    /**
     * {@inheritdoc}
     */
    public function getSort(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSort');
        if (!$pluginInfo) {
            return parent::getSort($request);
        } else {
            return $this->___callPlugins('getSort', func_get_args(), $pluginInfo);
        }
    }
}
