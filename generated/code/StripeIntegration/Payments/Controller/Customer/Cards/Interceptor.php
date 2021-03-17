<?php
namespace StripeIntegration\Payments\Controller\Customer\Cards;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Customer\Cards
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Customer\Cards implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $session, \StripeIntegration\Payments\Model\Config $config, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Model\StripeCustomer $stripeCustomer)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $session, $config, $helper, $stripeCustomer);
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
