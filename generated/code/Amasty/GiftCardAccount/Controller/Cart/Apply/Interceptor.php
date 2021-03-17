<?php
namespace Amasty\GiftCardAccount\Controller\Cart\Apply;

/**
 * Interceptor class for @see \Amasty\GiftCardAccount\Controller\Cart\Apply
 */
class Interceptor extends \Amasty\GiftCardAccount\Controller\Cart\Apply implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Escaper $escaper, \Amasty\GiftCardAccount\Api\GiftCardAccountManagementInterface $accountManagement)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $escaper, $accountManagement);
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
