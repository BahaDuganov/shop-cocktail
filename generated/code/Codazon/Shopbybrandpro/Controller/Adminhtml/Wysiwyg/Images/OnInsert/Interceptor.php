<?php
namespace Codazon\Shopbybrandpro\Controller\Adminhtml\Wysiwyg\Images\OnInsert;

/**
 * Interceptor class for @see \Codazon\Shopbybrandpro\Controller\Adminhtml\Wysiwyg\Images\OnInsert
 */
class Interceptor extends \Codazon\Shopbybrandpro\Controller\Adminhtml\Wysiwyg\Images\OnInsert implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Controller\Result\Json $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultJsonFactory);
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
