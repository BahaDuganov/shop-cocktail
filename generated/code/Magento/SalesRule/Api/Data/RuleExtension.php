<?php
namespace Magento\SalesRule\Api\Data;

/**
 * Extension class for @see \Magento\SalesRule\Api\Data\RuleInterface
 */
class RuleExtension extends \Magento\Framework\Api\AbstractSimpleObject implements RuleExtensionInterface
{
    /**
     * @return \Amasty\BannersLite\Api\Data\BannerInterface[]|null
     */
    public function getPromoBannersLite()
    {
        return $this->_get('promo_banners_lite');
    }

    /**
     * @param \Amasty\BannersLite\Api\Data\BannerInterface[] $promoBannersLite
     * @return $this
     */
    public function setPromoBannersLite($promoBannersLite)
    {
        $this->setData('promo_banners_lite', $promoBannersLite);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBannerProductSku()
    {
        return $this->_get('banner_product_sku');
    }

    /**
     * @param string $bannerProductSku
     * @return $this
     */
    public function setBannerProductSku($bannerProductSku)
    {
        $this->setData('banner_product_sku', $bannerProductSku);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBannerProductCategories()
    {
        return $this->_get('banner_product_categories');
    }

    /**
     * @param string $bannerProductCategories
     * @return $this
     */
    public function setBannerProductCategories($bannerProductCategories)
    {
        $this->setData('banner_product_categories', $bannerProductCategories);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getShowBannerFor()
    {
        return $this->_get('show_banner_for');
    }

    /**
     * @param int $showBannerFor
     * @return $this
     */
    public function setShowBannerFor($showBannerFor)
    {
        $this->setData('show_banner_for', $showBannerFor);
        return $this;
    }

    /**
     * @return \Amasty\Rules\Api\Data\RuleInterface|null
     */
    public function getAmrules()
    {
        return $this->_get('amrules');
    }

    /**
     * @param \Amasty\Rules\Api\Data\RuleInterface $amrules
     * @return $this
     */
    public function setAmrules(\Amasty\Rules\Api\Data\RuleInterface $amrules)
    {
        $this->setData('amrules', $amrules);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->_get('limit');
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->setData('limit', $limit);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount()
    {
        return $this->_get('count');
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->setData('count', $count);
        return $this;
    }
}
