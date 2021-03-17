<?php
namespace Amasty\Orderattr\Model\ResourceModel\Entity\Entity;

/**
 * Interceptor class for @see \Amasty\Orderattr\Model\ResourceModel\Entity\Entity
 */
class Interceptor extends \Amasty\Orderattr\Model\ResourceModel\Entity\Entity implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Eav\Model\Entity\Context $context, $data = [], ?\Magento\Eav\Model\Entity\Attribute\UniqueValidationInterface $uniqueValidator = null)
    {
        $this->___init();
        parent::__construct($context, $data, $uniqueValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        if (!$pluginInfo) {
            return parent::save($object);
        } else {
            return $this->___callPlugins('save', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'delete');
        if (!$pluginInfo) {
            return parent::delete($object);
        } else {
            return $this->___callPlugins('delete', func_get_args(), $pluginInfo);
        }
    }
}
