<?php
namespace WeSupply\Toolbox\Block\System\Config\SpecificEstimationRanges;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Block\System\Config\SpecificEstimationRanges
 */
class Interceptor extends \WeSupply\Toolbox\Block\System\Config\SpecificEstimationRanges implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Escaper $escaper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $escaper, $data);
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
