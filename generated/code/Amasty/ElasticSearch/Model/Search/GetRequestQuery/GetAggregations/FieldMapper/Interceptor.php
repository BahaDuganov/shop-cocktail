<?php
namespace Amasty\ElasticSearch\Model\Search\GetRequestQuery\GetAggregations\FieldMapper;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Search\GetRequestQuery\GetAggregations\FieldMapper
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Search\GetRequestQuery\GetAggregations\FieldMapper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($customerSession, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFieldName($fieldName)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'mapFieldName');
        if (!$pluginInfo) {
            return parent::mapFieldName($fieldName);
        } else {
            return $this->___callPlugins('mapFieldName', func_get_args(), $pluginInfo);
        }
    }
}
