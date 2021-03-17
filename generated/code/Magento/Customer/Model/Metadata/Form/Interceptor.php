<?php
namespace Magento\Customer\Model\Metadata\Form;

/**
 * Interceptor class for @see \Magento\Customer\Model\Metadata\Form
 */
class Interceptor extends \Magento\Customer\Model\Metadata\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService, \Magento\Customer\Api\AddressMetadataInterface $addressMetadataService, \Magento\Customer\Model\Metadata\ElementFactory $elementFactory, \Magento\Framework\App\RequestInterface $httpRequest, \Magento\Framework\Module\Dir\Reader $modulesReader, \Magento\Framework\Validator\ConfigFactory $validatorConfigFactory, $entityType, $formCode, array $attributeValues = [], $ignoreInvisible = true, $filterAttributes = [], $isAjax = false)
    {
        $this->___init();
        parent::__construct($customerMetadataService, $addressMetadataService, $elementFactory, $httpRequest, $modulesReader, $validatorConfigFactory, $entityType, $formCode, $attributeValues, $ignoreInvisible, $filterAttributes, $isAjax);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAttributes');
        if (!$pluginInfo) {
            return parent::getAttributes();
        } else {
            return $this->___callPlugins('getAttributes', func_get_args(), $pluginInfo);
        }
    }
}
