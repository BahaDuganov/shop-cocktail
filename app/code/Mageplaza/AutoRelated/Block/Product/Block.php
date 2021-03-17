<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AutoRelated
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AutoRelated\Block\Product;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Checkout\Model\Session;
use Magento\Widget\Block\BlockInterface;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Mageplaza\AutoRelated\Helper\Data;
use Mageplaza\AutoRelated\Helper\Rule;
use Mageplaza\AutoRelated\Model\Config\Source\AddProductTypes;
use Mageplaza\AutoRelated\Model\Config\Source\Direction;
use Mageplaza\AutoRelated\Model\Config\Source\ProductNotDisplayed;

/**
 * Class ProductList
 * @package Mageplaza\AutoRelated\Block\Product\ProductList
 */
class Block extends AbstractProduct implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'Mageplaza_AutoRelated::product/block.phtml';

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Mageplaza\AutoRelated\Model\Rule
     */
    protected $rule;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var array
     */
    protected $displayTypes;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var WishlistProviderInterface
     */
    protected $wishListProvider;

    /**
     * Block constructor.
     *
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Session $checkoutSession
     * @param WishlistProviderInterface $wishListProvider
     * @param Rule $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Session $checkoutSession,
        WishlistProviderInterface $wishListProvider,
        Rule $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->productCollectionFactory = $productCollectionFactory;
        $this->checkoutSession          = $checkoutSession;
        $this->wishListProvider         = $wishListProvider;
        $this->helper                   = $helper;
    }

    /**
     * @param \Mageplaza\AutoRelated\Model\Rule $rule
     *
     * @return $this
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        $location = $rule->getData('location');
        if ($location == 'left-popup-content' || $location == 'right-popup-content') {
            $this->setTemplate('Mageplaza_AutoRelated::product/block-floating.phtml');
        }

        return $this;
    }

    public function getLocationBlock()
    {
        return $this->rule->getData('location');
    }

    /**
     * Get heading label
     *
     * @return string
     */
    public function getTitleBlock()
    {
        return $this->rule->getData('block_name');
    }

    /**
     * @return mixed
     */
    public function getRuleId()
    {
        return $this->rule->getId();
    }

    /**
     * @return string
     */
    public function getJsData()
    {
        return Rule::jsonEncode([
            'type'      => $this->isSliderType() ? 'slider' : 'grid',
            'rule_id'   => $this->rule->getId(),
            'parent_id' => $this->rule->getData('parent_id'),
            'location'  => $this->rule->getData('location'),
            'mode'      => $this->rule->getData('display_mode')
        ]);
    }

    /**
     * Get layout config
     *
     * @return int
     */
    public function isSliderType()
    {
        return !$this->rule->getData('product_layout');
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function canShow($type)
    {
        if (is_null($this->displayTypes)) {
            $this->displayTypes = $this->rule->getData('display_additional') ? explode(
                ',',
                $this->rule->getData('display_additional')
            ) : [];
        }

        return in_array($type, $this->displayTypes);
    }

    /**
     * @return array|Collection
     */
    public function getProductCollection()
    {
        $rule = $this->rule;
        if (!$rule || !$rule->getId()) {
            return [];
        }

        $productIds = $rule->getApplyProductIds();
        if ($rule->getData('add_ruc_product')) {
            $productIds = array_unique(array_merge($productIds, $this->addAdditionProducts()));
        }
        if ($this->rule->getData('product_not_displayed')) {
            $productIds = array_diff($productIds, $this->removeProducts());
        }

        if (empty($productIds)) {
            return [];
        }

        $collection = $this->productCollectionFactory->create()
            ->addIdFilter($productIds)
            ->addStoreFilter();
        $this->_addProductAttributesAndPrices($collection);

        if ($rule->getData('display_out_of_stock')) {
            $collection->setFlag('has_stock_status_filter', true);
        }
        if ($limit = $rule->getData('limit_number')) {
            $collection->setPageSize($limit);
        }

        switch ($rule->getData('sort_order_direction')) {
            case Direction::BESTSELLER:
                $collection->getSelect()->joinLeft(
                    ['soi' => $collection->getTable('sales_bestsellers_aggregated_yearly')],
                    'e.entity_id = soi.product_id',
                    ['qty_ordered' => 'SUM(soi.qty_ordered)']
                )
                    ->group('e.entity_id')
                    ->order('qty_ordered DESC');
                break;
            case Direction::PRICE_LOW:
                $collection->addAttributeToSort('price', 'ASC');
                break;
            case Direction::PRICE_HIGH:
                $collection->addAttributeToSort('price', 'DESC');
                break;
            case Direction::NEWEST:
                $collection->getSelect()->order('e.created_at DESC');
                break;
            default:
                $collection->getSelect()->order('rand()');
                break;
        }

        return $collection;
    }

    /**
     * @return array|string
     */
    protected function addAdditionProducts()
    {
        $productIds = [];
        if ($this->rule->getData('block_type') != 'product') {
            return $productIds;
        }

        $product = $this->helper->getCurrentProduct();

        $addProductTypes = explode(',', $this->rule['add_ruc_product']);
        if (in_array(AddProductTypes::RELATED_PRODUCT, $addProductTypes)) {
            $productIds += $product->getRelatedProductIds();
        }
        if (in_array(AddProductTypes::UP_SELL_PRODUCT, $addProductTypes)) {
            $productIds += $product->getUpSellProductIds();
        }
        if (in_array(AddProductTypes::CROSS_SELL_PRODUCT, $addProductTypes)) {
            $productIds += $product->getCrossSellProductIds();
        }

        return $productIds;
    }

    /**
     * @return array
     */
    protected function removeProducts()
    {
        $productIds = [];

        $productNotDisplayed = explode(',', $this->rule['product_not_displayed']);
        if (in_array(ProductNotDisplayed::IN_CART, $productNotDisplayed)) {
            $productInfo = $this->checkoutSession->getQuote()->getItemsCollection();
            foreach ($productInfo as $item) {
                $productIds[] = $item->getProductId();
            }
        }
        if (in_array(
            ProductNotDisplayed::IN_WISHLIST,
            $productNotDisplayed
        ) && ($currentUserWishList = $this->wishListProvider->getWishlist())) {
            $wishListItems = $currentUserWishList->getItemCollection();
            foreach ($wishListItems as $item) {
                $productIds[] = $item->getProductId();
            }
        }

        return $productIds;
    }
}
