<?php
namespace Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Save;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Save
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Image\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\PageSpeedOptimizer\Api\ImageSettingRepositoryInterface $repository, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Amasty\PageSpeedOptimizer\Model\Image\ToolChecker $toolChecker)
    {
        $this->___init();
        parent::__construct($context, $repository, $dataPersistor, $toolChecker);
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
