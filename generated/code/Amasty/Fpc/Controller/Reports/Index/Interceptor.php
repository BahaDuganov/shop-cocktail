<?php
namespace Amasty\Fpc\Controller\Reports\Index;

/**
 * Interceptor class for @see \Amasty\Fpc\Controller\Reports\Index
 */
class Interceptor extends \Amasty\Fpc\Controller\Reports\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Fpc\Model\ReportsFactory $reportsFactory, \Amasty\Fpc\Model\ResourceModel\Reports $reports, \Magento\Framework\Session\SessionManager $sessionManager)
    {
        $this->___init();
        parent::__construct($context, $reportsFactory, $reports, $sessionManager);
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
