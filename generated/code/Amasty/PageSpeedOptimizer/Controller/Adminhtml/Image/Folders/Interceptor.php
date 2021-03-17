<?php
namespace Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Folders;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Folders
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Folders implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\PageSpeedOptimizer\Model\Image\ResourceModel\CollectionFactory $imageCollectionFactory, \Magento\Framework\Filesystem $filesystem)
    {
        $this->___init();
        parent::__construct($context, $imageCollectionFactory, $filesystem);
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
