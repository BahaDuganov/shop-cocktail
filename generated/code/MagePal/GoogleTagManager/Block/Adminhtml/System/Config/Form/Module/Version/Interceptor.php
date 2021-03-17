<?php
namespace MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Module\Version;

/**
 * Interceptor class for @see \MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Module\Version
 */
class Interceptor extends \MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Module\Version implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Module\ModuleListInterface $moduleList, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleList, $data);
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
