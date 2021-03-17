<?php
namespace Aislend\Alert\Controller\Add\Guest;

/**
 * Interceptor class for @see \Aislend\Alert\Controller\Add\Guest
 */
class Interceptor extends \Aislend\Alert\Controller\Add\Guest implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Aislend\Alert\Model\GuestAlertFactory $guestalert, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->___init();
        parent::__construct($context, $customerFactory, $storeManager, $guestalert, $productRepository);
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
