<?php
namespace WeSupply\Toolbox\Block\System\Config\VersionCompare;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Block\System\Config\VersionCompare
 */
class Interceptor extends \WeSupply\Toolbox\Block\System\Config\VersionCompare implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory, \Magento\Framework\Component\ComponentRegistrarInterface $componentRegistrar, \WeSupply\Toolbox\Logger\Logger $logger)
    {
        $this->___init();
        parent::__construct($context, $readFactory, $componentRegistrar, $logger);
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
