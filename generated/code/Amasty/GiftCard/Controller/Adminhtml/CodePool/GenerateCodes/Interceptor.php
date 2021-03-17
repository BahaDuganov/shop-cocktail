<?php
namespace Amasty\GiftCard\Controller\Adminhtml\CodePool\GenerateCodes;

/**
 * Interceptor class for @see \Amasty\GiftCard\Controller\Adminhtml\CodePool\GenerateCodes
 */
class Interceptor extends \Amasty\GiftCard\Controller\Adminhtml\CodePool\GenerateCodes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GiftCard\Model\Code\CodeGeneratorManagement $codeGeneratorManagement, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $codeGeneratorManagement, $logger);
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
