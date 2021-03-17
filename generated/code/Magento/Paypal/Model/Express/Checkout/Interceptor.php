<?php
namespace Magento\Paypal\Model\Express\Checkout;

/**
 * Interceptor class for @see \Magento\Paypal\Model\Express\Checkout
 */
class Interceptor extends \Magento\Paypal\Model\Express\Checkout implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Psr\Log\LoggerInterface $logger, \Magento\Customer\Model\Url $customerUrl, \Magento\Tax\Helper\Data $taxData, \Magento\Checkout\Helper\Data $checkoutData, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\Cache\Type\Config $configCacheType, \Magento\Framework\Locale\ResolverInterface $localeResolver, \Magento\Paypal\Model\Info $paypalInfo, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\UrlInterface $coreUrl, \Magento\Paypal\Model\CartFactory $cartFactory, \Magento\Checkout\Model\Type\OnepageFactory $onepageFactory, \Magento\Quote\Api\CartManagementInterface $quoteManagement, \Magento\Paypal\Model\Billing\AgreementFactory $agreementFactory, \Magento\Paypal\Model\Api\Type\Factory $apiTypeFactory, \Magento\Framework\DataObject\Copy $objectCopyService, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Customer\Model\AccountManagement $accountManagement, \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender, \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, \Magento\Quote\Model\Quote\TotalsCollector $totalsCollector, $params = [])
    {
        $this->___init();
        parent::__construct($logger, $customerUrl, $taxData, $checkoutData, $customerSession, $configCacheType, $localeResolver, $paypalInfo, $storeManager, $coreUrl, $cartFactory, $onepageFactory, $quoteManagement, $agreementFactory, $apiTypeFactory, $objectCopyService, $checkoutSession, $encryptor, $messageManager, $customerRepository, $accountManagement, $orderSender, $quoteRepository, $totalsCollector, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function returnFromPaypal($token, ?string $payerIdentifier = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'returnFromPaypal');
        if (!$pluginInfo) {
            return parent::returnFromPaypal($token, $payerIdentifier);
        } else {
            return $this->___callPlugins('returnFromPaypal', func_get_args(), $pluginInfo);
        }
    }
}
