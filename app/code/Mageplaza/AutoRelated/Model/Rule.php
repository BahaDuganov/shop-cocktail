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

namespace Mageplaza\AutoRelated\Model;

use Exception;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\CatalogRule\Model\Rule\Condition\Combine;
use Magento\Checkout\Model\Session;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\ResourceModel\Iterator;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Rule\Model\AbstractModel;
use Magento\SalesRule\Model\Rule\Condition\CombineFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Rule
 * @package Mageplaza\AutoRelated\Model
 */
class Rule extends AbstractModel
{
    /**
     * Store matched product Ids
     *
     * @var array
     */
    protected $productIds;

    /**
     * Store matched product Ids in condition tab
     *
     * @var array
     */
    protected $productConditionsIds;

    /**
     * Store matched product Ids with rule id
     *
     * @var array
     */
    protected $dataProductIds;

    /**
     * @var Iterator
     */
    protected $resourceIterator;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @var Status
     */
    protected $productStatus;

    /**
     * @var \Magento\CatalogRule\Model\Rule\Condition\CombineFactory
     */
    protected $_productCombineFactory;

    /**
     * @var CombineFactory
     */
    protected $_salesCombineFactory;

    /**
     * @var \Mageplaza\AutoRelated\Helper\Rule
     */
    protected $helper;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * Rule constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param TimezoneInterface $localeDate
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param ProductFactory $productFactory
     * @param \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $catalogCombineFactory
     * @param CombineFactory $salesCombineFactory
     * @param Iterator $resourceIterator
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        TimezoneInterface $localeDate,
        Status $productStatus,
        Visibility $productVisibility,
        ProductFactory $productFactory,
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $catalogCombineFactory,
        CombineFactory $salesCombineFactory,
        Iterator $resourceIterator,
        \Mageplaza\AutoRelated\Helper\Rule $helper,
        Session $checkoutSession,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_productCombineFactory = $catalogCombineFactory;
        $this->_salesCombineFactory   = $salesCombineFactory;
        $this->resourceIterator       = $resourceIterator;
        $this->productFactory         = $productFactory;
        $this->productVisibility      = $productVisibility;
        $this->productStatus          = $productStatus;
        $this->helper                 = $helper;
        $this->checkoutSession        = $checkoutSession;

        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('Mageplaza\AutoRelated\Model\ResourceModel\Rule');
        $this->setIdFieldName('rule_id');
    }

    /**
     * Get rule condition combine model instance
     *
     * @return Combine|\Magento\SalesRule\Model\Rule\Condition\Combine
     */
    public function getConditionsInstance()
    {
        $type = $this->_registry->registry('autorelated_type');
        if ($type == 'cart' || $type == 'osc') {
            return $this->_salesCombineFactory->create();
        }

        return $this->_productCombineFactory->create();
    }

    /**
     * Get rule condition product combine model instance
     *
     * @return Combine
     */
    public function getActionsInstance()
    {
        return $this->_productCombineFactory->create();
    }

    /**
     * @param string $formName
     *
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * @param string $formName
     *
     * @return string
     */
    public function getActionsFieldSetId($formName = '')
    {
        return $formName . 'rule_actions_fieldset_' . $this->getId();
    }

    /**
     * @return bool
     */
    public function hasChild()
    {
        $ruleChild = $this->getChild();
        if (!empty($ruleChild)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasChildActive()
    {
        $ruleChild = $this->getChild();
        if (!empty($ruleChild) && $ruleChild['is_active'] == 1) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getChild()
    {
        return $this->getResource()->getRuleData($this->getId(), 'parent_id');
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave()
    {
        if ($this->getCustomerGroupIds() || $this->getStoreIds()) {
            $this->getResource()->deleteOldData($this->getId());
            if ($storeIds = $this->getStoreIds()) {
                $this->getResource()->updateStore($storeIds, $this->getId());
            }
            if ($groupIds = $this->getCustomerGroupIds()) {
                $this->getResource()->updateCustomerGroup($groupIds, $this->getId());
            }
        }

        $this->reindex();

        return parent::afterSave();
    }

    /**
     * @return $this
     */
    public function reindex()
    {
        $this->getMatchingProductIds();
        $this->getResource()->deleteActionIndex($this->getId());
        if (!empty($this->dataProductIds) && is_array($this->dataProductIds)) {
            $this->getResource()->insertActionIndex($this->dataProductIds);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getApplyProductIds()
    {
        $productIds = [];
        switch ($this->getData('block_type')) {
            case 'product':
                $product = $this->helper->getCurrentProduct();
                if ($this->getConditions()->validate($product)) {
                    $productIds = $this->getResource()->getProductListByRuleId($this->getId(), $product->getId());
                }
                break;
            case 'category':
                if ($condition = $this->getCategoryConditionsSerialized()) {
                    try {
                        $categoryIds = $this->helper->unserialize($condition);
                        $category    = $this->helper->getCurrentCategory();
                        if (in_array($category->getId(), $categoryIds)) {
                            $productIds = $this->getResource()->getProductListByRuleId($this->getId());
                        }
                    } catch (Exception $e) {
                        $this->_logger->critical($e->getMessage());
                    }
                }
                break;
            case 'cart':
                $quote   = $this->checkoutSession->getQuote();
                $address = $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
                if ($this->getConditions()->validate($address)) {
                    $productIds = $this->getResource()->getProductListByRuleId($this->getId());
                }
                break;
            case 'osc':
                $quote   = $this->checkoutSession->getQuote();
                $address = $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
                if ($this->getConditions()->validate($address)) {
                    $productIds = $this->getResource()->getProductListByRuleId($this->getId());
                }
                break;
        }

        return $productIds;
    }

    /**
     * Get array of product ids which are matched by rule
     *
     * @return array|null
     */
    public function getMatchingProductIds()
    {
        if ($this->productIds === null) {
            $this->productIds = [];
            $this->setCollectedAttributes([]);

            $productCollection = $this->getProductCollection();
            $this->getActions()->collectValidatedAttributes($productCollection);

            $this->resourceIterator->walk(
                $productCollection->getSelect(),
                [[$this, 'callbackValidateProduct']],
                [
                    'attributes' => $this->getCollectedAttributes(),
                    'product'    => $this->productFactory->create()
                ]
            );
        }

        return $this->productIds;
    }

    /**
     * @return array|null
     */
    public function getMatchingProductIdsByCondition()
    {
        if ($this->productConditionsIds === null) {
            $this->productConditionsIds = [];
            $this->setCollectedAttributes([]);

            $productCollection = $this->getProductCollection();
            $this->getConditions()->collectValidatedAttributes($productCollection);

            $this->resourceIterator->walk(
                $productCollection->getSelect(),
                [[$this, 'callbackValidateProductConditions']],
                [
                    'attributes' => $this->getCollectedAttributes(),
                    'product'    => $this->productFactory->create()
                ]
            );
        }

        return $this->productConditionsIds;
    }

    /**
     * @return Collection
     */
    protected function getProductCollection()
    {
        /** @var $productCollection Collection */
        $productCollection = $this->productFactory->create()->getCollection();
        $productCollection->addAttributeToSelect('*')
            ->setVisibility([
                Visibility::VISIBILITY_IN_CATALOG,
                Visibility::VISIBILITY_BOTH
            ])
            ->addAttributeToFilter('status', 1);

        return $productCollection;
    }

    /**
     * Callback function for product matching
     *
     * @param array $args
     *
     * @return void
     */
    public function callbackValidateProduct($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $ruleId = $this->getRuleId();
        if ($ruleId && $this->getActions()->validate($product)) {
            $this->productIds[]     = $product->getId();
            $this->dataProductIds[] = ['rule_id' => $ruleId, 'product_id' => $product->getId()];
        }
    }

    /**
     * Callback function for product matching (conditions)
     *
     * @param array $args
     *
     * @return void
     */
    public function callbackValidateProductConditions($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $ruleId = $this->getRuleId();
        if ($ruleId && $this->getConditions()->validate($product)) {
            $this->productConditionsIds[] = $product->getId();
        }
    }
}
