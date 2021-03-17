<?php
namespace Amasty\Xsearch\Controller\Product\Click;

/**
 * Interceptor class for @see \Amasty\Xsearch\Controller\Product\Click
 */
class Interceptor extends \Amasty\Xsearch\Controller\Product\Click implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Xsearch\Model\ResourceModel\UserSearch\Collection $userSearchCollection, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $userSearchCollection, $customerSession);
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
