<?php
namespace Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Validate;

/**
 * Interceptor class for @see \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Validate
 */
class Interceptor extends \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Validate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Bss\CheckoutCustomField\Model\Attribute $attribute, \Magento\Catalog\Model\Product\Url $productUrl, \Magento\Framework\DataObject $response)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $layoutFactory, $attribute, $productUrl, $response);
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
