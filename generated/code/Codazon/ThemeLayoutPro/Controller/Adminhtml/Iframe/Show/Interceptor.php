<?php
namespace Codazon\ThemeLayoutPro\Controller\Adminhtml\Iframe\Show;

/**
 * Interceptor class for @see \Codazon\ThemeLayoutPro\Controller\Adminhtml\Iframe\Show
 */
class Interceptor extends \Codazon\ThemeLayoutPro\Controller\Adminhtml\Iframe\Show implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Codazon\ThemeLayoutPro\Helper\Media $swatchHelper, \Magento\Framework\Image\AdapterFactory $adapterFactory, \Magento\Catalog\Model\Product\Media\Config $config, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory)
    {
        $this->___init();
        parent::__construct($context, $swatchHelper, $adapterFactory, $config, $filesystem, $uploaderFactory);
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
