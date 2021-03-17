<?php
namespace Magento\Framework\View\Asset\Bundle;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\Bundle
 */
class Interceptor extends \Magento\Framework\View\Asset\Bundle implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Magento\Framework\View\Asset\Bundle\ConfigInterface $bundleConfig, \Magento\Framework\View\Asset\Minification $minification)
    {
        $this->___init();
        parent::__construct($filesystem, $bundleConfig, $minification);
    }

    /**
     * {@inheritdoc}
     */
    public function addAsset(\Magento\Framework\View\Asset\LocalInterface $asset)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAsset');
        if (!$pluginInfo) {
            return parent::addAsset($asset);
        } else {
            return $this->___callPlugins('addAsset', func_get_args(), $pluginInfo);
        }
    }
}
