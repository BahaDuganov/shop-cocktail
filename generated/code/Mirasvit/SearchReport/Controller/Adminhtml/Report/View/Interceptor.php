<?php
namespace Mirasvit\SearchReport\Controller\Adminhtml\Report\View;

/**
 * Interceptor class for @see \Mirasvit\SearchReport\Controller\Adminhtml\Report\View
 */
class Interceptor extends \Mirasvit\SearchReport\Controller\Adminhtml\Report\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Report\Api\Repository\ReportRepositoryInterface $repository, \Magento\Framework\Registry $registry, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($repository, $registry, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \Magento\Backend\Model\View\Result\Page
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
