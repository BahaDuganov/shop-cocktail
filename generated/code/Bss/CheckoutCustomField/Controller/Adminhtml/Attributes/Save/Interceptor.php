<?php
namespace Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Save;

/**
 * Interceptor class for @see \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Save
 */
class Interceptor extends \Bss\CheckoutCustomField\Controller\Adminhtml\Attributes\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory $validatorFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\Json\Helper\Data $jsonHelper, \Bss\CheckoutCustomField\Model\Attribute $model, \Magento\Catalog\Model\Product\Url $catalogUrl, \Magento\Framework\Registry $resigtry, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $validatorFactory, $layoutFactory, $jsonHelper, $model, $catalogUrl, $resigtry, $storeManager);
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
