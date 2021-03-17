<?php
namespace Mirasvit\Report\Controller\Adminhtml\Api\Request;

/**
 * Interceptor class for @see \Mirasvit\Report\Controller\Adminhtml\Api\Request
 */
class Interceptor extends \Mirasvit\Report\Controller\Adminhtml\Api\Request implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\ReportApi\Api\RequestBuilderInterface $requestBuilder, \Mirasvit\Report\Api\Repository\ReportRepositoryInterface $reportRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($requestBuilder, $reportRepository, $context);
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
