<?php
namespace Mageplaza\AutoRelated\Block\Product\ProductList\ProductList;

/**
 * Interceptor class for @see \Mageplaza\AutoRelated\Block\Product\ProductList\ProductList
 */
class Interceptor extends \Mageplaza\AutoRelated\Block\Product\ProductList\ProductList implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Framework\App\ResourceConnection $resource, \Magento\CatalogInventory\Helper\Stock $stockHelper, \Mageplaza\AutoRelated\Helper\Data $helperData, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $productFactory, $productCollectionFactory, $resource, $stockHelper, $helperData, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
