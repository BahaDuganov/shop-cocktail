<?php
namespace WeSupply\Toolbox\Block\System\Config\StoreIdsList;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Block\System\Config\StoreIdsList
 */
class Interceptor extends \WeSupply\Toolbox\Block\System\Config\StoreIdsList implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Escaper $escaper, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($storeManager, $escaper, $context, $data);
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
