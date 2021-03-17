<?php
namespace Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Duplicate;

/**
 * Interceptor class for @see \Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Duplicate
 */
class Interceptor extends \Mirasvit\ReportBuilder\Controller\Adminhtml\Api\Duplicate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Report\Api\Repository\ReportRepositoryInterface $reportRepository, \Mirasvit\ReportBuilder\Repository\ReportRepository $builderReportRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($reportRepository, $builderReportRepository, $context);
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
