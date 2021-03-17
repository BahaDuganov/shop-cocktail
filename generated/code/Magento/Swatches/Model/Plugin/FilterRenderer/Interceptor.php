<?php
namespace Magento\Swatches\Model\Plugin\FilterRenderer;

/**
 * Interceptor class for @see \Magento\Swatches\Model\Plugin\FilterRenderer
 */
class Interceptor extends \Magento\Swatches\Model\Plugin\FilterRenderer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\LayoutInterface $layout, \Magento\Swatches\Helper\Data $swatchHelper)
    {
        $this->___init();
        parent::__construct($layout, $swatchHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function aroundRender(\Magento\LayeredNavigation\Block\Navigation\FilterRenderer $subject, \Closure $proceed, \Magento\Catalog\Model\Layer\Filter\FilterInterface $filter)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'aroundRender');
        if (!$pluginInfo) {
            return parent::aroundRender($subject, $proceed, $filter);
        } else {
            return $this->___callPlugins('aroundRender', func_get_args(), $pluginInfo);
        }
    }
}
