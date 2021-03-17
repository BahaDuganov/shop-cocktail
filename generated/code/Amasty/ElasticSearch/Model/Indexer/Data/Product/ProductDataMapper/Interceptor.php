<?php
namespace Amasty\ElasticSearch\Model\Indexer\Data\Product\ProductDataMapper;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Model\Indexer\Data\Product\ProductDataMapper
 */
class Interceptor extends \Amasty\ElasticSearch\Model\Indexer\Data\Product\ProductDataMapper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\ElasticSearch\Model\Indexer\Data\Product\AttributeDataProvider $attributeDataProvider, \Amasty\ElasticSearch\Model\ResourceModel\ConfigurableResolver $configurableResolver, array $excludedAttributes = [])
    {
        $this->___init();
        parent::__construct($attributeDataProvider, $configurableResolver, $excludedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $documentData, $storeId, array $context = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'map');
        if (!$pluginInfo) {
            return parent::map($documentData, $storeId, $context);
        } else {
            return $this->___callPlugins('map', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepareProductData($productId, $value, \Magento\Eav\Model\Entity\Attribute $attribute)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepareProductData');
        if (!$pluginInfo) {
            return parent::prepareProductData($productId, $value, $attribute);
        } else {
            return $this->___callPlugins('prepareProductData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeOptions(\Magento\Eav\Model\Entity\Attribute $attribute)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAttributeOptions');
        if (!$pluginInfo) {
            return parent::getAttributeOptions($attribute);
        } else {
            return $this->___callPlugins('getAttributeOptions', func_get_args(), $pluginInfo);
        }
    }
}
