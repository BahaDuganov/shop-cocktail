<?php
namespace StripeIntegration\Payments\Block\Adminhtml\Payment\Info;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Block\Adminhtml\Payment\Info
 */
class Interceptor extends \StripeIntegration\Payments\Block\Adminhtml\Payment\Info implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Payment\Gateway\ConfigInterface $config, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Api $api, \Magento\Directory\Model\Country $country, \Magento\Payment\Model\Info $info, \Magento\Framework\Registry $registry, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $config, $helper, $api, $country, $info, $registry, $data);
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
