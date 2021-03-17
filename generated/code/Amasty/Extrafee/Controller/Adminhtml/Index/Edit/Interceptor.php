<?php
namespace Amasty\Extrafee\Controller\Adminhtml\Index\Edit;

/**
 * Interceptor class for @see \Amasty\Extrafee\Controller\Adminhtml\Index\Edit
 */
class Interceptor extends \Amasty\Extrafee\Controller\Adminhtml\Index\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Extrafee\Model\FeeRepository $feeRepository, \Amasty\Extrafee\Model\Rule\RuleRepository $ruleRepository)
    {
        $this->___init();
        parent::__construct($context, $feeRepository, $ruleRepository);
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
