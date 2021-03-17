<?php
namespace PayPal\Braintree\Model\Venmo\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\Venmo\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\Venmo\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \Magento\Framework\View\Asset\Repository $assetRepo, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($adapter, $assetRepo, $braintreeConfig, $scopeConfig);
    }
}
