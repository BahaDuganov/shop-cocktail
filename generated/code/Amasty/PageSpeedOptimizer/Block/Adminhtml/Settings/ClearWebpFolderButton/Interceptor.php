<?php
namespace Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\ClearWebpFolderButton;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\ClearWebpFolderButton
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\ClearWebpFolderButton implements \Magento\Framework\Interception\InterceptorInterface
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
