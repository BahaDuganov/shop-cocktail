<?php
namespace StripeIntegration\Payments\Block\Sepa;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Block\Sepa
 */
class Interceptor extends \StripeIntegration\Payments\Block\Sepa implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Payment\Gateway\ConfigInterface $config, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $config, $data);
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
