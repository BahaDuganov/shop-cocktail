<?php
namespace Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\Diagnostic;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\Diagnostic
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\Diagnostic implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Locale\Resolver $localeResolver, \Magento\Backend\Block\Template\Context $context, \Magento\Framework\Url $urlBuilder, array $data = [])
    {
        $this->___init();
        parent::__construct($localeResolver, $context, $urlBuilder, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
