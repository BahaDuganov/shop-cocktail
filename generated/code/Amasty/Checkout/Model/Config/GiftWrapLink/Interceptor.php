<?php
namespace Amasty\Checkout\Model\Config\GiftWrapLink;

/**
 * Interceptor class for @see \Amasty\Checkout\Model\Config\GiftWrapLink
 */
class Interceptor extends \Amasty\Checkout\Model\Config\GiftWrapLink implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Module\Manager $moduleManager, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleManager, $data);
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
