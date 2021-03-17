<?php
namespace StripeIntegration\Payments\Controller\Payment\Index;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Payment\Index
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Payment\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Checkout\Helper\Data $checkoutHelper, \Magento\Sales\Model\OrderFactory $orderFactory, \StripeIntegration\Payments\Helper\Generic $helper, \Magento\Sales\Model\Service\InvoiceService $invoiceService, \Magento\Framework\DB\Transaction $dbTransaction)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $checkoutHelper, $orderFactory, $helper, $invoiceService, $dbTransaction);
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
