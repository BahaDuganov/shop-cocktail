<?php
namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Update;

/**
 * Interceptor class for @see \Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Update
 */
class Interceptor extends \Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Update implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $drshippingModel)
    {
        $this->___init();
        parent::__construct($context, $drshippingModel);
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
