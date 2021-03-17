<?php
namespace Amasty\GiftCardAccount\Controller\Cart\Check;

/**
 * Interceptor class for @see \Amasty\GiftCardAccount\Controller\Cart\Check
 */
class Interceptor extends \Amasty\GiftCardAccount\Controller\Cart\Check implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\GiftCardAccount\Model\GiftCardAccount\Repository $accountRepository, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Serialize\Serializer\Json $serializer, \Amasty\GiftCardAccount\Model\GiftCardAccountFormatter $accountFormatter)
    {
        $this->___init();
        parent::__construct($context, $accountRepository, $logger, $serializer, $accountFormatter);
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
