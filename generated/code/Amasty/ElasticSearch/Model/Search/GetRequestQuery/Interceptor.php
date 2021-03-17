<?php
namespace Amasty\ElasticSearch\Model\Search\GetRequestQuery;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Search\GetRequestQuery
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Search\GetRequestQuery implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\ElasticSearch\Model\Config $config, \Amasty\ElasticSearch\Model\Client\ClientRepository $clientRepository, \Amasty\ElasticSearch\Model\Search\GetRequestQuery\GetAggregations $getAggregations, \Amasty\ElasticSearch\Model\Search\GetRequestQuery\SortingProvider $sortingProvider, array $subqueryInjectors)
    {
        $this->___init();
        parent::__construct($config, $clientRepository, $getAggregations, $sortingProvider, $subqueryInjectors);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute($request);
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
