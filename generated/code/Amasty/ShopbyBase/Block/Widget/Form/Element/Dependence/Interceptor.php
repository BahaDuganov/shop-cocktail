<?php
namespace Amasty\ShopbyBase\Block\Widget\Form\Element\Dependence;

/**
 * Interceptor class for @see \Amasty\ShopbyBase\Block\Widget\Form\Element\Dependence
 */
class Interceptor extends \Amasty\ShopbyBase\Block\Widget\Form\Element\Dependence implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Context $context, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory, \Amasty\ShopbyBase\Model\Source\DisplayMode $displayModeSource, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $jsonEncoder, $fieldFactory, $displayModeSource, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldDependence($fieldName, $fieldNameFrom, $refField)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFieldDependence');
        if (!$pluginInfo) {
            return parent::addFieldDependence($fieldName, $fieldNameFrom, $refField);
        } else {
            return $this->___callPlugins('addFieldDependence', func_get_args(), $pluginInfo);
        }
    }
}
