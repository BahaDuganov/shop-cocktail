<?php
namespace Amasty\Deliverydate\Controller\Adminhtml\Tinterval\Setup;

/**
 * Interceptor class for @see \Amasty\Deliverydate\Controller\Adminhtml\Tinterval\Setup
 */
class Interceptor extends \Amasty\Deliverydate\Controller\Adminhtml\Tinterval\Setup implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $coreRegistry, \Psr\Log\LoggerInterface $logInterface, \Amasty\Deliverydate\Model\ResourceModel\Tinterval $resourceModel, \Amasty\Deliverydate\Model\TintervalFactory $model, \Amasty\Deliverydate\Model\ResourceModel\Tinterval\Collection $tintervalCollection, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Amasty\Deliverydate\Helper\Data $deliveryHelper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreRegistry, $logInterface, $resourceModel, $model, $tintervalCollection, $filter, $storeManager, $date, $deliveryHelper);
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
