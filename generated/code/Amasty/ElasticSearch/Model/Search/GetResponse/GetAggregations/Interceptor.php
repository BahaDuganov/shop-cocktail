<?php
namespace Amasty\ElasticSearch\Model\Search\GetResponse\GetAggregations;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Search\GetResponse\GetAggregations
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Search\GetResponse\GetAggregations implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Search\Dynamic\Algorithm\Repository $dynamicAlgorithmRepository, \Magento\Framework\Search\Dynamic\EntityStorageFactory $dynamicEntityStorageFactory, \Amasty\ElasticSearch\Model\Search\DataProvider $dataProvider)
    {
        $this->___init();
        parent::__construct($dynamicAlgorithmRepository, $dynamicEntityStorageFactory, $dataProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function getTermBucket(\Magento\Framework\Search\Request\BucketInterface $bucket, array $elasticResponse)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTermBucket');
        if (!$pluginInfo) {
            return parent::getTermBucket($bucket, $elasticResponse);
        } else {
            return $this->___callPlugins('getTermBucket', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDynamicBucket(\Magento\Framework\Search\Request\BucketInterface $bucket, array $dimensions, array $elasticResponse)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDynamicBucket');
        if (!$pluginInfo) {
            return parent::getDynamicBucket($bucket, $dimensions, $elasticResponse);
        } else {
            return $this->___callPlugins('getDynamicBucket', func_get_args(), $pluginInfo);
        }
    }
}
