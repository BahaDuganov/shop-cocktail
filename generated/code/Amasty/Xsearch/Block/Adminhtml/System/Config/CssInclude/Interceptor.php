<?php
namespace Amasty\Xsearch\Block\Adminhtml\System\Config\CssInclude;

/**
 * Interceptor class for @see \Amasty\Xsearch\Block\Adminhtml\System\Config\CssInclude
 */
class Interceptor extends \Amasty\Xsearch\Block\Adminhtml\System\Config\CssInclude implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\Base\Helper\CssChecker $cssChecker, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $cssChecker, $data);
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
