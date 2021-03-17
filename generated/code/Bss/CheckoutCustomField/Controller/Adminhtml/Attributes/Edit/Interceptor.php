<?php
namespace Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Edit;

/**
 * Interceptor class for @see \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Edit
 */
class Interceptor extends \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Cache\FrontendInterface $attributeLabelCache, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Bss\CheckoutCustomField\Model\Attribute $model)
    {
        $this->___init();
        parent::__construct($context, $attributeLabelCache, $coreRegistry, $resultPageFactory, $model);
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
