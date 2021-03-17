<?php
namespace Mirasvit\ReportBuilder\Controller\Adminhtml\Config\NewAction;

/**
 * Interceptor class for @see \Mirasvit\ReportBuilder\Controller\Adminhtml\Config\NewAction
 */
class Interceptor extends \Mirasvit\ReportBuilder\Controller\Adminhtml\Config\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\ReportBuilder\Api\Repository\ConfigRepositoryInterface $configRepository, \Mirasvit\ReportBuilder\Service\BuilderService $builderService, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($configRepository, $builderService, $context);
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
