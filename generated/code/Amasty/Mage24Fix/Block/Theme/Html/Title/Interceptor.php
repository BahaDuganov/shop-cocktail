<?php
namespace Amasty\Mage24Fix\Block\Theme\Html\Title;

/**
 * Interceptor class for @see \Amasty\Mage24Fix\Block\Theme\Html\Title
 */
class Interceptor extends \Amasty\Mage24Fix\Block\Theme\Html\Title implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $scopeConfig, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
