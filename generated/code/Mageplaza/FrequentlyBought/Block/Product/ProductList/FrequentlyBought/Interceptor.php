<?php
namespace Mageplaza\FrequentlyBought\Block\Product\ProductList\FrequentlyBought;

/**
 * Interceptor class for @see \Mageplaza\FrequentlyBought\Block\Product\ProductList\FrequentlyBought
 */
class Interceptor extends \Mageplaza\FrequentlyBought\Block\Product\ProductList\FrequentlyBought implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Checkout\Model\ResourceModel\Cart $checkoutCart, \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Module\Manager $moduleManager, \Magento\Framework\Pricing\Helper\Data $priceHelper, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Mageplaza\FrequentlyBought\Helper\Data $fbtDataHelper, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Mageplaza\FrequentlyBought\Model\FrequentlyBoughtFactory $fbtModelFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $checkoutCart, $catalogProductVisibility, $checkoutSession, $moduleManager, $priceHelper, $productRepository, $fbtDataHelper, $localeFormat, $productCollectionFactory, $fbtModelFactory, $data);
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
