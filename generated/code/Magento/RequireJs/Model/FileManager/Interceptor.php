<?php
namespace Magento\RequireJs\Model\FileManager;

/**
 * Interceptor class for @see \Magento\RequireJs\Model\FileManager
 */
class Interceptor extends \Magento\RequireJs\Model\FileManager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\RequireJs\Config $config, \Magento\Framework\Filesystem $appFilesystem, \Magento\Framework\App\State $appState, \Magento\Framework\View\Asset\Repository $assetRepo)
    {
        $this->___init();
        parent::__construct($config, $appFilesystem, $appState, $assetRepo);
    }

    /**
     * {@inheritdoc}
     */
    public function createStaticJsAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createStaticJsAsset');
        if (!$pluginInfo) {
            return parent::createStaticJsAsset();
        } else {
            return $this->___callPlugins('createStaticJsAsset', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createBundleJsPool()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createBundleJsPool');
        if (!$pluginInfo) {
            return parent::createBundleJsPool();
        } else {
            return $this->___callPlugins('createBundleJsPool', func_get_args(), $pluginInfo);
        }
    }
}
