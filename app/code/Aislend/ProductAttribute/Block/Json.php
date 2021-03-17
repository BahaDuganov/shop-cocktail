<?php

namespace Aislend\ProductAttribute\Block;

use \Magento\Framework\Registry;
use \Magento\Catalog\Api\Data\ProductInterface;
use \Magento\Checkout\Model\Session;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\ConfigurableProduct\Model\Product\Type\Configurable;


class Json extends Template
{


    private $checkoutSession;
    protected $_registry;
    protected $configurableAttributes;

    public function __construct(
        Registry $registry,
        Session $checkoutSession,
        Configurable $configurableAttributes,
        Context $context,
        array $data
    )
    {
        parent::__construct($context, $data);
        $this->_registry = $registry;
        $this->checkoutSession = $checkoutSession;
        $this->configAttributes = $configurableAttributes;
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function isInCart(ProductInterface $product)
    {
        $productId = $product->getId();
        $cartItems = $this->checkoutSession->getQuote()->getAllVisibleItems();
        $itemsIds = array();
        foreach ($cartItems as $cartItem) {
            $itemsIds[] = $cartItem->getProduct()->getId();
        }

        return in_array($productId, $itemsIds);
    }


    public function countItemsInCart()
    {
        $cartItems = $this->checkoutSession->getQuote()->getAllVisibleItems();
        $cartItemsCount = count($cartItems);

        return $cartItemsCount;
    }


    public function getConfigAssociatedProducts($product)
    {
        $associatedProducts = $product->getTypeInstance()->getConfigurableOptions($product);
        $productsOptions = array();

    /**********Get Configurable Product Options*************/
        foreach($associatedProducts as $attrWithAsso){
            foreach($attrWithAsso as $getData){
                $productsOptions[$getData['sku']][$getData['attribute_code']] = $getData['option_title'];
            }
        }
//        print_r($productsOptions);
//        die;
    /**************Get Associated Products data****************/
        $_configChild = $product->getTypeInstance()->getUsedProducts($product);
        foreach ($_configChild  as $child) {
            print_r($child->getData());
            die;
//            echo $this->getConfigurableAttributes($child);
            $productsOptions[$child->getSku()]['productid'] = $child->getId();
            $productsOptions[$child->getSku()]['image'] = $child->getImage();
            $productsOptions[$child->getSku()]['price'] = $child->getPrice();
            $productsOptions[$child->getSku()]['name'] = $child->getName();
        }
        echo "<pre>";
        print_r($productsOptions);
        die;
        return json_encode($productsOptions);
        die;
    }


    public function getConfigurableAttributes($product)
    {

        if($product->getTypeId() != 'configurable'):
            return;
        endif;

        $attributeList = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        foreach ($attributeList as $productAttribute) {
            $attributeLable = $productAttribute['label'];
            $attributeId = $productAttribute['attribute_id'];
            $attributeCode = $productAttribute['attribute_code'];
            $attributeOptions[$attributeCode]['label'] = $attributeLable;
            $attributeOptions[$attributeCode]['id'] = $attributeId;
            $attributeOptions[$attributeCode]['attribute_code'] = $attributeCode;
            foreach ($productAttribute['values'] as $attribute) {
                $attributeOptions[$attributeCode]['options'][$attribute['value_index']] = $attribute['store_label'];
            }
        }
        echo "<pre>";
        print_r($attributeOptions);

        return $attributeOptions;
    }
}