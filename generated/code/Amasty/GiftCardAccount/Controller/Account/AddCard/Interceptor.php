<?php
namespace Amasty\GiftCardAccount\Controller\Account\AddCard;

/**
 * Interceptor class for @see \Amasty\GiftCardAccount\Controller\Account\AddCard
 */
class Interceptor extends \Amasty\GiftCardAccount\Controller\Account\AddCard implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $session, \Amasty\GiftCardAccount\Model\GiftCardAccount\Repository $accountRepository, \Amasty\GiftCardAccount\Model\CustomerCard\Repository $customerCardRepository, \Amasty\GiftCardAccount\Model\GiftCardAccountFormatter $accountFormatter, \Amasty\GiftCard\Model\ConfigProvider $configProvider)
    {
        $this->___init();
        parent::__construct($context, $session, $accountRepository, $customerCardRepository, $accountFormatter, $configProvider);
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
