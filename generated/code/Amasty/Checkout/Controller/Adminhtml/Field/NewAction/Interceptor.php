<?php
namespace Amasty\Checkout\Controller\Adminhtml\Field\NewAction;

/**
 * Interceptor class for @see \Amasty\Checkout\Controller\Adminhtml\Field\NewAction
 */
class Interceptor extends \Amasty\Checkout\Controller\Adminhtml\Field\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Checkout\Model\ResourceModel\Field $fieldResource, \Amasty\Checkout\Model\FieldFactory $fieldFactory, \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->___init();
        parent::__construct($context, $fieldResource, $fieldFactory, $eavSetupFactory);
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
