<?php
namespace Mageplaza\AutoRelated\Block\Product\Block;

/**
 * Interceptor class for @see \Mageplaza\AutoRelated\Block\Product\Block
 */
class Interceptor extends \Mageplaza\AutoRelated\Block\Product\Block implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Wishlist\Controller\WishlistProviderInterface $wishListProvider, \Mageplaza\AutoRelated\Helper\Rule $helper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $productCollectionFactory, $checkoutSession, $wishListProvider, $helper, $data);
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
