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
 * @category  Mageplaza
 * @package   Mageplaza_FrequentlyBought
 * @copyright Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license   https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\FrequentlyBought\Block\Product\ProductList;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ProductList\Related;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Checkout\Model\ResourceModel\Cart;
use Magento\Checkout\Model\Session;
use Magento\Downloadable\Block\Catalog\Product\Links;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Module\Manager;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Element\FormKey;
use Magento\GroupedProduct\Block\Product\View\Type\Grouped;
use Mageplaza\FrequentlyBought\Block\Product\View\Type\Configurable;
use Mageplaza\FrequentlyBought\Helper\Data as FbtData;
use Mageplaza\FrequentlyBought\Model\Config\Source\Method;
use Mageplaza\FrequentlyBought\Model\FrequentlyBought as FrequentlyBoughtModel;
use Mageplaza\FrequentlyBought\Model\FrequentlyBoughtFactory;
use Mageplaza\FrequentlyBought\Model\ResourceModel\FrequentlyBought\Product\Collection as FrequentlyBoughtCollection;

/**
 * Class FrequentlyBought
 *
 * @package Mageplaza\FrequentlyBought\Block\Product\ProductList
 */
class FrequentlyBought extends Related
{
    /**
     * @var Data
     */
    protected $priceHelper;

    /**
     * @var FbtData
     */
    protected $fbtDataHelper;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var FormatInterface
     */
    protected $_localeFormat;

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var FrequentlyBoughtModel
     */
    protected $fbtModelFactory;

    /**
     * @var Collection
     */
    protected $_productCollection;

    /**
     * @type string
     */
    protected $formKey;

    /**
     * FrequentlyBought constructor.
     *
     * @param Context $context
     * @param Cart $checkoutCart
     * @param Visibility $catalogProductVisibility
     * @param Session $checkoutSession
     * @param Manager $moduleManager
     * @param Data $priceHelper
     * @param ProductRepositoryInterface $productRepository
     * @param FbtData $fbtDataHelper
     * @param FormatInterface $localeFormat
     * @param CollectionFactory $productCollectionFactory
     * @param FrequentlyBoughtFactory $fbtModelFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Cart $checkoutCart,
        Visibility $catalogProductVisibility,
        Session $checkoutSession,
        Manager $moduleManager,
        Data $priceHelper,
        ProductRepositoryInterface $productRepository,
        FbtData $fbtDataHelper,
        FormatInterface $localeFormat,
        CollectionFactory $productCollectionFactory,
        FrequentlyBoughtFactory $fbtModelFactory,
        array $data = []
    ) {
        $this->priceHelper              = $priceHelper;
        $this->productRepository        = $productRepository;
        $this->fbtDataHelper            = $fbtDataHelper;
        $this->_localeFormat            = $localeFormat;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->fbtModelFactory          = $fbtModelFactory;

        parent::__construct(
            $context,
            $checkoutCart,
            $catalogProductVisibility,
            $checkoutSession,
            $moduleManager,
            $data
        );
    }

    /**
     * @return bool
     */
    public function isShow()
    {
        return !(!$this->fbtDataHelper->isEnabled() || $this->getRequest()->isAjax());
    }

    /**
     * @return Collection|FrequentlyBoughtCollection
     * @throws LocalizedException
     */
    public function getItems()
    {
        if (!in_array(Method::FBT, $this->fbtDataHelper->getProductMethod(), true)) {
            return parent::getItems();
        }

        if (!in_array(Method::RELATED, $this->fbtDataHelper->getProductMethod(), true)) {
            return $this->getFbtProducts();
        }

        return $this->getProductCollection();
    }

    /**
     * @return Collection|FrequentlyBoughtCollection
     */
    protected function getFbtProducts()
    {
        if ($this->_productCollection === null) {
            /** @var FrequentlyBoughtModel $model */
            $model                    = $this->fbtModelFactory->create();
            $this->_productCollection = $model->getProductCollection($this->getProduct());
            $this->_productCollection->addAttributeToSelect('required_options')->setPositionOrder()->addStoreFilter();
            if ($this->moduleManager->isEnabled('Magento_Checkout')) {
                $this->_addProductAttributesAndPrices($this->_productCollection);
            }
            $this->_productCollection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

            $this->_productCollection->load();

            foreach ($this->_productCollection as $product) {
                $product->setDoNotUseCategoryId(true);
            }
        }

        return $this->_productCollection;
    }

    /**
     * @return Collection|FrequentlyBoughtCollection
     * @throws LocalizedException
     */
    protected function getProductCollection()
    {
        $product   = $this->getProduct();
        $productId = $product->getId();
        if (!$this->fbtDataHelper->hasProductLinks($productId)) {
            return parent::getItems();
        }
        $fbtProducts = $this->getFbtProducts();
        $limit       = (int) $this->fbtDataHelper->getConfigGeneral('item_limit');
        $size        = $fbtProducts->getSize();
        if ($limit && $size >= $limit) {
            return $fbtProducts;
        }
        $fbtProductIds   = $fbtProducts->getAllIds();
        $relatedProducts = parent::getItems();
        foreach ($relatedProducts as $product) {
            if ($limit && $size >= $limit) {
                return $fbtProducts;
            }
            if (!in_array($product->getId(), $fbtProductIds, true)) {
                $product->setProductId($product->getId());
                $product->setId(null);
                $fbtProducts->addItem($product);
                $size++;
            }
        }

        return $fbtProducts;
    }

    /**
     * @inheritdoc
     */
    protected function _addProductAttributesAndPrices(Collection $collection)
    {
        $collection = parent::_addProductAttributesAndPrices($collection);

        $itemLimit = (int) $this->fbtDataHelper->getConfigGeneral('item_limit');
        if ($itemLimit) {
            $collection->getSelect()
                ->limit($itemLimit);
        }

        return $collection;
    }

    /**
     * @return string
     */
    public function getJsonConfig()
    {
        $config = [
            'priceFormat' => $this->_localeFormat->getPriceFormat(),
            'usePopup'    => $this->usePopup()
        ];

        return FbtData::jsonEncode($config);
    }

    /**
     * Get heading label
     *
     * @return string
     */
    public function getTitleBlock()
    {
        return $this->fbtDataHelper->getConfigGeneral('block_name');
    }

    /**
     * Get price with currency
     *
     * @param float $price
     *
     * @return string
     */
    public function getPriceWithCurrency($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }

    /**
     * Get price without currency
     *
     * @param object $product
     *
     * @return float
     */
    public function getPriceAmount($product)
    {
        $productType = $product->getTypeId();
        if ($productType === 'grouped' || $productType === 'bundle') {
            return 0;
        }

        return $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
    }

    /**
     * Get all custom option product
     *
     * @param null $productId
     *
     * @return mixed
     * @throws LocalizedException
     */
    public function getCustomOption($productId = null)
    {
        $product = $this->getProductById($productId);
        $option  = $this->getLayout()->getBlock('mageplaza.frequently.bought.product.info.options')
            ->setProduct($product)
            ->toHtml();

        return $option;
    }

    /**
     * Get option product
     *
     * @param null $productId
     *
     * @return bool|BlockInterface|string
     * @throws LocalizedException
     */
    public function getOptionWrapper($productId = null)
    {
        $html        = '';
        $product     = $this->getProductById($productId);
        $productType = $product->getTypeId();
        switch ($productType) {
            case 'configurable':
                $html = $this->getLayout()->createBlock(Configurable::class);
                break;
            case 'grouped':
                $html = $this->getLayout()->createBlock(Grouped::class)
                    ->setTemplate('Mageplaza_FrequentlyBought::product/view/type/grouped.phtml');
                break;
            case 'bundle':
                $html = $this->getLayout()->getBlock('mageplaza.fbt.product.info.bundle.options');
                break;
            case 'downloadable':
                $html = $this->getLayout()->createBlock(Links::class)
                    ->setTemplate('Mageplaza_FrequentlyBought::product/view/type/downloadable/links.phtml');
                break;
        }
        if ($html) {
            return $html->setProduct($product)->toHtml();
        }

        return $html;
    }

    /**
     * Get product by id
     *
     * @param null $productId
     *
     * @return ProductInterface|Product
     * @throws NoSuchEntityException
     */
    protected function getProductById($productId = null)
    {
        $storeId = $this->_storeManager->getStore()->getId();
        if ($productId) {
            $product = $this->productRepository->getById($productId, false, $storeId);
        } else {
            $product = $this->getProduct();
        }

        return $product;
    }

    /**
     * Get separator image config
     *
     * @return string
     */
    public function getSeparatorImage()
    {
        return $this->fbtDataHelper->getIcon();
    }

    /**
     * Get add to wishlist config
     *
     * @return mixed
     */
    public function getShowWishList()
    {
        return $this->fbtDataHelper->getConfigGeneral('enable_add_to_wishlist');
    }

    /**
     * Use Popup to select product options
     * @return bool
     */
    public function usePopup()
    {
        return $this->fbtDataHelper->usePopup();
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getFormKeyHtml()
    {
        if (!$this->formKey) {
            $this->formKey = $this->getLayout()->createBlock(FormKey::class)->toHtml();
        }

        return $this->formKey;
    }
}
