<?php
namespace Mirasvit\Reports\Controller\Adminhtml\Report\View;

/**
 * Interceptor class for @see \Mirasvit\Reports\Controller\Adminhtml\Report\View
 */
class Interceptor extends \Mirasvit\Reports\Controller\Adminhtml\Report\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Reports\Model\Manager $manager, \Magento\Framework\Registry $registry, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($manager, $registry, $context);
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
