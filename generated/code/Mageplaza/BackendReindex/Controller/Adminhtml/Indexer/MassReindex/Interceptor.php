<?php
namespace Mageplaza\BackendReindex\Controller\Adminhtml\Indexer\MassReindex;

/**
 * Interceptor class for @see \Mageplaza\BackendReindex\Controller\Adminhtml\Indexer\MassReindex
 */
class Interceptor extends \Mageplaza\BackendReindex\Controller\Adminhtml\Indexer\MassReindex implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry)
    {
        $this->___init();
        parent::__construct($context, $indexerRegistry);
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
