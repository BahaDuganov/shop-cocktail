<?php
namespace Amasty\Fpc\Block\Adminhtml\Form\Field\ExcludeClasses;

/**
 * Interceptor class for @see \Amasty\Fpc\Block\Adminhtml\Form\Field\ExcludeClasses
 */
class Interceptor extends \Amasty\Fpc\Block\Adminhtml\Form\Field\ExcludeClasses implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [], ?\Magento\Framework\View\Helper\SecureHtmlRenderer $secureRenderer = null)
    {
        $this->___init();
        parent::__construct($context, $data, $secureRenderer);
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
