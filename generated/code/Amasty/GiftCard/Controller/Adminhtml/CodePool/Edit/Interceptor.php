<?php
namespace Amasty\GiftCard\Controller\Adminhtml\CodePool\Edit;

/**
 * Interceptor class for @see \Amasty\GiftCard\Controller\Adminhtml\CodePool\Edit
 */
class Interceptor extends \Amasty\GiftCard\Controller\Adminhtml\CodePool\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GiftCard\Model\CodePool\Repository $repository, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $repository, $registry);
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
