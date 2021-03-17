<?php
namespace Amasty\Deliverydate\Controller\Guest\Save;

/**
 * Interceptor class for @see \Amasty\Deliverydate\Controller\Guest\Save
 */
class Interceptor extends \Amasty\Deliverydate\Controller\Guest\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Deliverydate\Model\DeliverydateRepository $deliverydateRepository, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Sales\Controller\AbstractController\OrderViewAuthorization $orderAuthorization, \Magento\Sales\Model\OrderRepository $orderRepository, \Psr\Log\LoggerInterface $logInterface, \Amasty\Deliverydate\Helper\Data $deliveryHelper, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Sales\Helper\Guest $guestHelper)
    {
        $this->___init();
        parent::__construct($context, $deliverydateRepository, $coreRegistry, $resultPageFactory, $orderAuthorization, $orderRepository, $logInterface, $deliveryHelper, $date, $transportBuilder, $guestHelper);
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
