<?php
namespace Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Start;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Start
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Start implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\PageSpeedOptimizer\Model\ConfigProvider $configProvider, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\App\Cache\TypeListInterface $cache, \Magento\Framework\App\Config\Storage\WriterInterface $configWriter, \Amasty\PageSpeedOptimizer\Model\Bundle\ResourceModel\Bundle $bundleResource, \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $urlRewriteCollectionFactory, \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory, \Magento\Framework\Math\Random $random, \Magento\Framework\View\DesignInterface $design, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($configProvider, $storeManager, $scopeConfig, $cache, $configWriter, $bundleResource, $urlRewriteCollectionFactory, $themeCollectionFactory, $random, $design, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
