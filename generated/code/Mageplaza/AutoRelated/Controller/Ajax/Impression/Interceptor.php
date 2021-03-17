<?php
namespace Mageplaza\AutoRelated\Controller\Ajax\Impression;

/**
 * Interceptor class for @see \Mageplaza\AutoRelated\Controller\Ajax\Impression
 */
class Interceptor extends \Mageplaza\AutoRelated\Controller\Ajax\Impression implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Mageplaza\AutoRelated\Helper\Rule $helper, \Mageplaza\AutoRelated\Model\ResourceModel\RuleFactory $autoRelatedRuleFac)
    {
        $this->___init();
        parent::__construct($context, $logger, $helper, $autoRelatedRuleFac);
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
