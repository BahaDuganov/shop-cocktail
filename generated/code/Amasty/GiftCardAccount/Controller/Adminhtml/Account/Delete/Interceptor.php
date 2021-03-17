<?php
namespace Amasty\GiftCardAccount\Controller\Adminhtml\Account\Delete;

/**
 * Interceptor class for @see \Amasty\GiftCardAccount\Controller\Adminhtml\Account\Delete
 */
class Interceptor extends \Amasty\GiftCardAccount\Controller\Adminhtml\Account\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GiftCardAccount\Model\GiftCardAccount\Repository $repository, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $repository, $logger);
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
