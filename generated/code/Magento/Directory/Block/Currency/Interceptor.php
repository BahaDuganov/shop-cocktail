<?php
namespace Magento\Directory\Block\Currency;

/**
 * Interceptor class for @see \Magento\Directory\Block\Currency
 */
class Interceptor extends \Magento\Directory\Block\Currency implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Framework\Data\Helper\PostHelper $postDataHelper, \Magento\Framework\Locale\ResolverInterface $localeResolver, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $currencyFactory, $postDataHelper, $localeResolver, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getSwitchCurrencyPostData($code)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSwitchCurrencyPostData');
        if (!$pluginInfo) {
            return parent::getSwitchCurrencyPostData($code);
        } else {
            return $this->___callPlugins('getSwitchCurrencyPostData', func_get_args(), $pluginInfo);
        }
    }
}
