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
 * @package     Mageplaza_FrequentlyBought
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\FrequentlyBought\Api;

/**
 * Interface FrequentlyBoughtRepositoryInterface
 * @package Mageplaza\FrequentlyBought\Api
 */
interface FrequentlyBoughtRepositoryInterface
{
    /**
     * Get product links list
     *
     * @param string $sku
     * @return \Mageplaza\FrequentlyBought\Api\Data\ProductLinkInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList($sku);

    /**
     * Save product link
     *
     * @param \Mageplaza\FrequentlyBought\Api\Data\ProductLinkInterface $entity
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function save(\Mageplaza\FrequentlyBought\Api\Data\ProductLinkInterface $entity);

    /**
     * Delete product link
     *
     * @param \Mageplaza\FrequentlyBought\Api\Data\ProductLinkInterface $entity
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function delete(\Mageplaza\FrequentlyBought\Api\Data\ProductLinkInterface $entity);

    /**
     * @param string $sku
     * @param string $linkedProductSku
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function deleteById($sku, $linkedProductSku);
}
