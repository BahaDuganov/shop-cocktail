<?php
namespace StripeIntegration\Payments\Block\SepaCreditInfo;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Block\SepaCreditInfo
 */
class Interceptor extends \StripeIntegration\Payments\Block\SepaCreditInfo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Payment\Gateway\ConfigInterface $config, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \StripeIntegration\Payments\Helper\Generic $paymentsHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $config, $pricingHelper, $paymentsHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toPdf()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toPdf');
        if (!$pluginInfo) {
            return parent::toPdf();
        } else {
            return $this->___callPlugins('toPdf', func_get_args(), $pluginInfo);
        }
    }
}
