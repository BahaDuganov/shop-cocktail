<?php
namespace PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\GooglePay\Config $config, \PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \Magento\Framework\View\Asset\Repository $assetRepo, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig)
    {
        $this->___init();
        parent::__construct($config, $adapter, $assetRepo, $braintreeConfig);
    }
}
