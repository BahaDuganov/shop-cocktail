<?php
namespace Amasty\Rgrid\Controller\Adminhtml\Promo\Quote\MassPriority;

/**
 * Interceptor class for @see \Amasty\Rgrid\Controller\Adminhtml\Promo\Quote\MassPriority
 */
class Interceptor extends \Amasty\Rgrid\Controller\Adminhtml\Promo\Quote\MassPriority implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rgrid\Model\ResourceModel\Rule\CollectionFactory $collectionFactory, \Amasty\Rgrid\Model\SalesRuleProvider $ruleProvider)
    {
        $this->___init();
        parent::__construct($context, $collectionFactory, $ruleProvider);
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
