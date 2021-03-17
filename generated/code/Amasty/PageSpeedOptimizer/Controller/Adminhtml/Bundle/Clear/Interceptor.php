<?php
namespace Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Clear;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Clear
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Clear implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\PageSpeedOptimizer\Model\Bundle\ResourceModel\Bundle $bundleResource, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($bundleResource, $context);
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
