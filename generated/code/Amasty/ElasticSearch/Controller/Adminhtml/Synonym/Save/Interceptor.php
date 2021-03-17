<?php
namespace Amasty\ElasticSearch\Controller\Adminhtml\Synonym\Save;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Controller\Adminhtml\Synonym\Save
 */
class Interceptor extends \Amasty\ElasticSearch\Controller\Adminhtml\Synonym\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Amasty\ElasticSearch\Model\SynonymRepository $synonymRepository, \Amasty\ElasticSearch\Model\SynonymFactory $synonymFactory, \Magento\Framework\Registry $registry, \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry)
    {
        $this->___init();
        parent::__construct($context, $resultForwardFactory, $synonymRepository, $synonymFactory, $registry, $indexerRegistry);
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
