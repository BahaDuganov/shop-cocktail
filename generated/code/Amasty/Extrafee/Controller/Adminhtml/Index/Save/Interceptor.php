<?php
namespace Amasty\Extrafee\Controller\Adminhtml\Index\Save;

/**
 * Interceptor class for @see \Amasty\Extrafee\Controller\Adminhtml\Index\Save
 */
class Interceptor extends \Amasty\Extrafee\Controller\Adminhtml\Index\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Extrafee\Model\FeeRepository $feeRepository, \Amasty\Extrafee\Model\Rule\FeeConditionProcessorFactory $ruleFactory, \Magento\Framework\Serialize\Serializer\FormData $formDataSerializer)
    {
        $this->___init();
        parent::__construct($context, $feeRepository, $ruleFactory, $formDataSerializer);
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
