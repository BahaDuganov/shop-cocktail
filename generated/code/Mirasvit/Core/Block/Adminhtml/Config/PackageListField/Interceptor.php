<?php
namespace Mirasvit\Core\Block\Adminhtml\Config\PackageListField;

/**
 * Interceptor class for @see \Mirasvit\Core\Block\Adminhtml\Config\PackageListField
 */
class Interceptor extends \Mirasvit\Core\Block\Adminhtml\Config\PackageListField implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Core\Service\ValidationService $validationService, \Mirasvit\Core\Service\PackageService $packageService, \Magento\Framework\Module\Manager $moduleManager, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($validationService, $packageService, $moduleManager, $context, $data);
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
