<?php
namespace MagePsycho\Easypathhints\Block\System\Config\Form\Field\Version;

/**
 * Interceptor class for @see \MagePsycho\Easypathhints\Block\System\Config\Form\Field\Version
 */
class Interceptor extends \MagePsycho\Easypathhints\Block\System\Config\Form\Field\Version implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \MagePsycho\Easypathhints\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $helper);
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
