<?php
namespace Amasty\Storelocator\Controller\Adminhtml\Schedule\Index;

/**
 * Interceptor class for @see \Amasty\Storelocator\Controller\Adminhtml\Schedule\Index
 */
class Interceptor extends \Amasty\Storelocator\Controller\Adminhtml\Schedule\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Storelocator\Model\Schedule $scheduleModel, \Psr\Log\LoggerInterface $logger, \Amasty\Base\Model\Serializer $serializer, \Magento\Ui\Component\MassAction\Filter $filter, \Amasty\Storelocator\Model\ResourceModel\Schedule\Collection $scheduleCollection)
    {
        $this->___init();
        parent::__construct($context, $scheduleModel, $logger, $serializer, $filter, $scheduleCollection);
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
