<?php
namespace Amasty\ElasticSearch\Model\Search\GetRequestQuery\SortingProvider;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Search\GetRequestQuery\SortingProvider
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Search\GetRequestQuery\SortingProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Eav\Model\Config $eavConfig, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Registry $registry, \Magento\Store\Model\StoreManager $storeManager, array $skippedFields = [], array $map = [])
    {
        $this->___init();
        parent::__construct($eavConfig, $customerSession, $registry, $storeManager, $skippedFields, $map);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestedSorting(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequestedSorting');
        if (!$pluginInfo) {
            return parent::getRequestedSorting($request);
        } else {
            return $this->___callPlugins('getRequestedSorting', func_get_args(), $pluginInfo);
        }
    }
}
