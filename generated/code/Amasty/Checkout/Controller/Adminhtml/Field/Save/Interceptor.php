<?php
namespace Amasty\Checkout\Controller\Adminhtml\Field\Save;

/**
 * Interceptor class for @see \Amasty\Checkout\Controller\Adminhtml\Field\Save
 */
class Interceptor extends \Amasty\Checkout\Controller\Adminhtml\Field\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Checkout\Model\ResourceModel\Field $fieldResource, \Amasty\Checkout\Model\FieldFactory $fieldFactory, \Amasty\Checkout\Model\ResourceModel\Field\CollectionFactory $fieldCollectionFactory, \Amasty\Checkout\Model\ModuleEnable $moduleEnable, \Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory $attributeCollectionFactory, \Magento\Customer\Model\ResourceModel\Attribute $attributeResource, \Magento\Customer\Model\AttributeFactory $attributeFactory, \Magento\Eav\Model\Entity\Attribute\FrontendLabelFactory $frontendLabelFactory, \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttributeResource, \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory $eavCollectionFactory, \Magento\Eav\Setup\EavSetup $eavSetup, \Amasty\Checkout\Model\Config $configProvider)
    {
        $this->___init();
        parent::__construct($context, $fieldResource, $fieldFactory, $fieldCollectionFactory, $moduleEnable, $attributeCollectionFactory, $attributeResource, $attributeFactory, $frontendLabelFactory, $eavAttributeResource, $eavCollectionFactory, $eavSetup, $configProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
