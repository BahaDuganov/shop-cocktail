<?php
namespace Magento\CatalogSearch\Block\Result;

/**
 * Interceptor class for @see \Magento\CatalogSearch\Block\Result
 */
class Interceptor extends \Magento\CatalogSearch\Block\Result implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Catalog\Model\Layer\Resolver $layerResolver, \Magento\CatalogSearch\Helper\Data $catalogSearchData, \Magento\Search\Model\QueryFactory $queryFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $layerResolver, $catalogSearchData, $queryFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getResultCount()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResultCount');
        if (!$pluginInfo) {
            return parent::getResultCount();
        } else {
            return $this->___callPlugins('getResultCount', func_get_args(), $pluginInfo);
        }
    }
}
