<?php
namespace Amasty\Xsearch\Block\Search\Product;

/**
 * Interceptor class for @see \Amasty\Xsearch\Block\Search\Product
 */
class Interceptor extends \Amasty\Xsearch\Block\Search\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Data\Helper\PostHelper $postDataHelper, \Magento\Catalog\Model\Layer\Resolver $layerResolver, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Magento\Framework\Url\Helper\Data $urlHelper, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Framework\Data\Form\FormKey $formKey, \Amasty\Xsearch\Helper\Data $xSearchHelper, \Magento\Framework\App\Response\RedirectInterface $redirector, \Magento\CatalogInventory\Helper\Stock $stockHelper, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Magento\Wishlist\Helper\Data $wishlistHelper, \Magento\Framework\View\DesignInterface $design, \Magento\Framework\Url $urlBuilder, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $string, $formKey, $xSearchHelper, $redirector, $stockHelper, $productFactory, $collectionFactory, $wishlistHelper, $design, $urlBuilder, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getResults()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResults');
        if (!$pluginInfo) {
            return parent::getResults();
        } else {
            return $this->___callPlugins('getResults', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductDetailsHtml');
        if (!$pluginInfo) {
            return parent::getProductDetailsHtml($product);
        } else {
            return $this->___callPlugins('getProductDetailsHtml', func_get_args(), $pluginInfo);
        }
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

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
