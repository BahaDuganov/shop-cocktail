<?php
namespace Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Save;

/**
 * Interceptor class for @see \Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Save
 */
class Interceptor extends \Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\ReportBuilder\Repository\ReportRepository $builderReportRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($builderReportRepository, $context);
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
