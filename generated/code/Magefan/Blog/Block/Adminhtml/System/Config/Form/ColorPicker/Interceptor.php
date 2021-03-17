<?php
namespace Magefan\Blog\Block\Adminhtml\System\Config\Form\ColorPicker;

/**
 * Interceptor class for @see \Magefan\Blog\Block\Adminhtml\System\Config\Form\ColorPicker
 */
class Interceptor extends \Magefan\Blog\Block\Adminhtml\System\Config\Form\ColorPicker implements \Magento\Framework\Interception\InterceptorInterface
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
