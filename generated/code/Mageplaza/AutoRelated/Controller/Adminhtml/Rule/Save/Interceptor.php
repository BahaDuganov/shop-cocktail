<?php
namespace Mageplaza\AutoRelated\Controller\Adminhtml\Rule\Save;

/**
 * Interceptor class for @see \Mageplaza\AutoRelated\Controller\Adminhtml\Rule\Save
 */
class Interceptor extends \Mageplaza\AutoRelated\Controller\Adminhtml\Rule\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Mageplaza\AutoRelated\Model\RuleFactory $autoRelatedRuleFactory, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, \Magento\Framework\Registry $coreRegistry, \Mageplaza\AutoRelated\Helper\Data $helperData, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $resultForwardFactory, $resultPageFactory, $autoRelatedRuleFactory, $dateFilter, $coreRegistry, $helperData, $logger);
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
