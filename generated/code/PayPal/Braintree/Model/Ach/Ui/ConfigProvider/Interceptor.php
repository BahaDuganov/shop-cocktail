<?php
namespace PayPal\Braintree\Model\Ach\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\Ach\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\Ach\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($adapter, $braintreeConfig, $scopeConfig);
    }
}
