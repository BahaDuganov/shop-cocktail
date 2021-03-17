<?php
namespace Magestore\Sociallogin\Controller\Sociallogin\Twlogin;

/**
 * Interceptor class for @see \Magestore\Sociallogin\Controller\Sociallogin\Twlogin
 */
class Interceptor extends \Magestore\Sociallogin\Controller\Sociallogin\Twlogin implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magestore\Sociallogin\Helper\Data $helperData, \Magento\Framework\Session\SessionManagerInterface $session, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magestore\Sociallogin\Model\ResourceModel\Customer\CollectionFactory $customerSocialCollectionFactory, \Magestore\Sociallogin\Model\ResourceModel\Vklogin\CollectionFactory $vkloginCollectionFactory, \Magestore\Sociallogin\Model\CustomerFactory $customerSocialFactory, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($customerSession, $storeManager, $scopeConfig, $helperData, $session, $customerFactory, $customerSocialCollectionFactory, $vkloginCollectionFactory, $customerSocialFactory, $context);
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
