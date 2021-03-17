<?php
namespace Magento\SalesRule\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\SalesRule\Api\Data\RuleInterface
 */
interface RuleExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return \Amasty\BannersLite\Api\Data\BannerInterface[]|null
     */
    public function getPromoBannersLite();

    /**
     * @param \Amasty\BannersLite\Api\Data\BannerInterface[] $promoBannersLite
     * @return $this
     */
    public function setPromoBannersLite($promoBannersLite);

    /**
     * @return string|null
     */
    public function getBannerProductSku();

    /**
     * @param string $bannerProductSku
     * @return $this
     */
    public function setBannerProductSku($bannerProductSku);

    /**
     * @return string|null
     */
    public function getBannerProductCategories();

    /**
     * @param string $bannerProductCategories
     * @return $this
     */
    public function setBannerProductCategories($bannerProductCategories);

    /**
     * @return int|null
     */
    public function getShowBannerFor();

    /**
     * @param int $showBannerFor
     * @return $this
     */
    public function setShowBannerFor($showBannerFor);

    /**
     * @return \Amasty\Rules\Api\Data\RuleInterface|null
     */
    public function getAmrules();

    /**
     * @param \Amasty\Rules\Api\Data\RuleInterface $amrules
     * @return $this
     */
    public function setAmrules(\Amasty\Rules\Api\Data\RuleInterface $amrules);

    /**
     * @return int|null
     */
    public function getLimit();

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit);

    /**
     * @return int|null
     */
    public function getCount();

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count);
}
