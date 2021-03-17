<?php
namespace Amasty\GiftCardAccount\Controller\Cart\Remove;

/**
 * Interceptor class for @see \Amasty\GiftCardAccount\Controller\Cart\Remove
 */
class Interceptor extends \Amasty\GiftCardAccount\Controller\Cart\Remove implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\GiftCardAccount\Model\GiftCardAccount\GiftCardAccountManagement $giftCardAccountManagement, \Magento\Checkout\Model\SessionFactory $checkoutSessionFactory)
    {
        $this->___init();
        parent::__construct($context, $giftCardAccountManagement, $checkoutSessionFactory);
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
