<?php
namespace Amasty\Orderattr\Model\ResourceModel\Attribute\Attribute;

/**
 * Interceptor class for @see \Amasty\Orderattr\Model\ResourceModel\Attribute\Attribute
 */
class Interceptor extends \Amasty\Orderattr\Model\ResourceModel\Attribute\Attribute implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Eav\Model\ResourceModel\Entity\Type $eavEntityType, \Amasty\Orderattr\Model\Attribute\InputType\InputTypeProvider $inputTypeProvider, $connectionName = null)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $eavEntityType, $inputTypeProvider, $connectionName);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreLabelsByAttributeId($attributeId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStoreLabelsByAttributeId');
        if (!$pluginInfo) {
            return parent::getStoreLabelsByAttributeId($attributeId);
        } else {
            return $this->___callPlugins('getStoreLabelsByAttributeId', func_get_args(), $pluginInfo);
        }
    }
}
