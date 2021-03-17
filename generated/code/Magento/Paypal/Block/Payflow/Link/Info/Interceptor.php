<?php
namespace Magento\Paypal\Block\Payflow\Link\Info;

/**
 * Interceptor class for @see \Magento\Paypal\Block\Payflow\Link\Info
 */
class Interceptor extends \Magento\Paypal\Block\Payflow\Link\Info implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Payment\Model\Config $paymentConfig, \Magento\Paypal\Model\InfoFactory $paypalInfoFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $paymentConfig, $paypalInfoFactory, $data);
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
