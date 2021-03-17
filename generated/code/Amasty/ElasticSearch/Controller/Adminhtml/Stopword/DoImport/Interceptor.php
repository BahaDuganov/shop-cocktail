<?php
namespace Amasty\ElasticSearch\Controller\Adminhtml\Stopword\DoImport;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Controller\Adminhtml\Stopword\DoImport
 */
class Interceptor extends \Amasty\ElasticSearch\Controller\Adminhtml\Stopword\DoImport implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Filesystem\Io\File $ioFile, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Amasty\ElasticSearch\Model\StopWordRepository $stopWordRepository, \Amasty\ElasticSearch\Model\StopWordFactory $stopWordFactory, \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry)
    {
        $this->___init();
        parent::__construct($context, $filesystem, $ioFile, $fileUploaderFactory, $stopWordRepository, $stopWordFactory, $indexerRegistry);
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
