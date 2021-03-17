<?php
namespace Webkul\DistanceRateShipping\Controller\Product\ProductShipping;

/**
 * Interceptor class for @see \Webkul\DistanceRateShipping\Controller\Product\ProductShipping
 */
class Interceptor extends \Webkul\DistanceRateShipping\Controller\Product\ProductShipping implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\DistanceRateShipping\Helper\Data $helper, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Pricing\Helper\Data $formatePrice, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Customer\Model\Session $customerSession, \Webkul\DistanceRateShipping\Logger\Logger $logger, \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $drshipping)
    {
        $this->___init();
        parent::__construct($context, $helper, $resultPageFactory, $formatePrice, $resultJsonFactory, $customerSession, $logger, $drshipping);
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
