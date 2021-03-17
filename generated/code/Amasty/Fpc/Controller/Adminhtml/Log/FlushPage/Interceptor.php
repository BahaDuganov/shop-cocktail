<?php
namespace Amasty\Fpc\Controller\Adminhtml\Log\FlushPage;

/**
 * Interceptor class for @see \Amasty\Fpc\Controller\Adminhtml\Log\FlushPage
 */
class Interceptor extends \Amasty\Fpc\Controller\Adminhtml\Log\FlushPage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Fpc\Model\ResourceModel\Log\CollectionFactory $logCollectionFactory, \Amasty\Fpc\Model\FlushPagesManager $flushPagesManager, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $logCollectionFactory, $flushPagesManager, $logger);
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
