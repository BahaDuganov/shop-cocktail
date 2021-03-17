<?php
namespace Mirasvit\Report\Controller\Adminhtml\Api\Export;

/**
 * Interceptor class for @see \Mirasvit\Report\Controller\Adminhtml\Api\Export
 */
class Interceptor extends \Mirasvit\Report\Controller\Adminhtml\Api\Export implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Mirasvit\Report\Model\Export\ConvertToXml $convertToXml, \Mirasvit\Report\Model\Export\ConvertToCsv $convertToCsv, \Mirasvit\ReportApi\Api\RequestBuilderInterface $requestBuilder, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($fileFactory, $convertToXml, $convertToCsv, $requestBuilder, $context);
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
