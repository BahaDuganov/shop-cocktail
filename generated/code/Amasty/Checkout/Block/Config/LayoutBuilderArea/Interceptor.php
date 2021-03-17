<?php
namespace Amasty\Checkout\Block\Config\LayoutBuilderArea;

/**
 * Interceptor class for @see \Amasty\Checkout\Block\Config\LayoutBuilderArea
 */
class Interceptor extends \Amasty\Checkout\Block\Config\LayoutBuilderArea implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\Checkout\Model\Config\CheckoutBlocksProvider $checkoutBlocksProvider, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $checkoutBlocksProvider, $scopeConfig, $data);
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
