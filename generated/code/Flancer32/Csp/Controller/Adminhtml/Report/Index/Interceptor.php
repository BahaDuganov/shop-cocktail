<?php
namespace Flancer32\Csp\Controller\Adminhtml\Report\Index;

/**
 * Interceptor class for @see \Flancer32\Csp\Controller\Adminhtml\Report\Index
 */
class Interceptor extends \Flancer32\Csp\Controller\Adminhtml\Report\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\HttpFactory $factHttpResponse, \Flancer32\Csp\Helper\Config $hlpCfg, \Flancer32\Csp\Service\Report\Save $srvReportSave)
    {
        $this->___init();
        parent::__construct($context, $factHttpResponse, $hlpCfg, $srvReportSave);
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
