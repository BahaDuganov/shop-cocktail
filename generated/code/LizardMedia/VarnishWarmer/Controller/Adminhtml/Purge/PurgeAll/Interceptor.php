<?php
namespace LizardMedia\VarnishWarmer\Controller\Adminhtml\Purge\PurgeAll;

/**
 * Interceptor class for @see \LizardMedia\VarnishWarmer\Controller\Adminhtml\Purge\PurgeAll
 */
class Interceptor extends \LizardMedia\VarnishWarmer\Controller\Adminhtml\Purge\PurgeAll implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface $varnishActionManager, \LizardMedia\VarnishWarmer\Api\ProgressHandler\QueueProgressLoggerInterface $queueProgressLogger, \LizardMedia\VarnishWarmer\Api\ProgressHandler\ProgressBarRendererInterface $queueProgressBarRenderer, \Magento\Framework\Message\Factory $messageFactory)
    {
        $this->___init();
        parent::__construct($context, $directoryList, $varnishActionManager, $queueProgressLogger, $queueProgressBarRenderer, $messageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \Magento\Framework\Controller\Result\Redirect
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
