<?php
namespace Amasty\Deliverydate\Controller\Adminhtml\Deliverydate\Save;

/**
 * Interceptor class for @see \Amasty\Deliverydate\Controller\Adminhtml\Deliverydate\Save
 */
class Interceptor extends \Amasty\Deliverydate\Controller\Adminhtml\Deliverydate\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Deliverydate\Model\ResourceModel\Deliverydate $resourceModel, \Amasty\Deliverydate\Model\DeliverydateFactory $model, \Amasty\Deliverydate\Model\ResourceModel\Deliverydate\Collection $deliverydateCollection, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Sales\Model\ResourceModel\Order $orderResource, \Psr\Log\LoggerInterface $logInterface, \Amasty\Deliverydate\Helper\Data $deliveryHelper, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder)
    {
        $this->___init();
        parent::__construct($context, $resourceModel, $model, $deliverydateCollection, $coreRegistry, $resultPageFactory, $orderFactory, $orderResource, $logInterface, $deliveryHelper, $date, $transportBuilder);
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
