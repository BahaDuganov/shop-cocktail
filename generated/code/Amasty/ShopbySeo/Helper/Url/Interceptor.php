<?php
namespace Amasty\ShopbySeo\Helper\Url;

/**
 * Interceptor class for @see \Amasty\ShopbySeo\Helper\Url
 */
class Interceptor extends \Amasty\ShopbySeo\Helper\Url implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Amasty\ShopbySeo\Helper\Data $helper, \Magento\Framework\Registry $coreRegistry, \Magento\Store\Model\StoreManagerInterface $storeManager, \Amasty\ShopbySeo\Helper\UrlParser $urlParser, \Amasty\ShopbySeo\Helper\Config $config, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $helper, $coreRegistry, $storeManager, $urlParser, $config, $dataPersistor);
    }

    /**
     * {@inheritdoc}
     */
    public function modifySeoIdentifier($identifier)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'modifySeoIdentifier');
        if (!$pluginInfo) {
            return parent::modifySeoIdentifier($identifier);
        } else {
            return $this->___callPlugins('modifySeoIdentifier', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function modifySeoIdentifierByAlias($identifier, $aliases = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'modifySeoIdentifierByAlias');
        if (!$pluginInfo) {
            return parent::modifySeoIdentifierByAlias($identifier, $aliases);
        } else {
            return $this->___callPlugins('modifySeoIdentifierByAlias', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasCategoryFilterParam()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasCategoryFilterParam');
        if (!$pluginInfo) {
            return parent::hasCategoryFilterParam();
        } else {
            return $this->___callPlugins('hasCategoryFilterParam', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parseQuery($query)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'parseQuery');
        if (!$pluginInfo) {
            return parent::parseQuery($query);
        } else {
            return $this->___callPlugins('parseQuery', func_get_args(), $pluginInfo);
        }
    }
}
