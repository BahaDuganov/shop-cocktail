<?php
namespace Amasty\Storelocator\Controller\Adminhtml\Reviews\MassAction;

/**
 * Interceptor class for @see \Amasty\Storelocator\Controller\Adminhtml\Reviews\MassAction
 */
class Interceptor extends \Amasty\Storelocator\Controller\Adminhtml\Reviews\MassAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Storelocator\Api\ReviewRepositoryInterface $reviewRepository, \Amasty\Storelocator\Model\ResourceModel\Review\Collection $collection, \Amasty\Storelocator\Model\ResourceModel\Review\CollectionFactory $collectionFactory, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $reviewRepository, $collection, $collectionFactory, $filter, $logger);
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
