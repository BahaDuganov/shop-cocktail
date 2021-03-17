<?php
namespace Codazon\ThemeLayoutPro\Block\Adminhtml\Config\Form\Field\Editor;

/**
 * Interceptor class for @see \Codazon\ThemeLayoutPro\Block\Adminhtml\Config\Form\Field\Editor
 */
class Interceptor extends \Codazon\ThemeLayoutPro\Block\Adminhtml\Config\Form\Field\Editor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $wysiwygConfig, $data);
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
