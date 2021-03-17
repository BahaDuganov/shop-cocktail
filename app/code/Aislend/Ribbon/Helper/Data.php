<?php
/**
 * @var \Magento\Search\Helper\Data $helper
 */
namespace Aislend\Ribbon\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	function getProductRibbon($product)
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
		$storeId = $storeManager->getStore()->getStoreId();
		$websiteId = $storeManager->getStore()->getWebsiteId();

		$productId = $product->getId();
		if(!($productId)):
			return;
		endif;

		if($this->getProductOutOfStock($product, $objectManager, $websiteId)):
			return 'Out Of Stock';
		endif;

        if($this->getCatalogRulePrice($productId)){
            return 'Special Offer';
        }

        if($this->getProductSpeicalOffer($product, $objectManager, $product->getTypeId(), $storeId, $websiteId)):
            return 'Special Offer';
        endif;

        /* if($this->getProductLowQuantity($productId)):
            return 'Low Quantity';
        endif; */

		if($this->getProductNew($product)):
			return 'New Product';
		endif;

		return '';		
	}
	
	/************ Check product is Saleble or not ***************/
	
	protected function getProductOutOfStock($product, $objectManager, $websiteId)
	{
		$productId = $product->getId();
		$typeId = $product->getTypeId();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');		
		 
		$ribbon = false;
		switch ($typeId)
		{
			case ('simple') :
				$inventory = $StockState->getStockQty($product->getId(), $websiteId);
				if (!$product->isSaleable() && $inventory == 0):
					$ribbon = true;
					return $ribbon;					
				endif;	
				
			break;
			
			case ('configurable') :	
				$stockArray = array();
				if (!$product->isSaleable()):
					$ribbon = true;
					return $ribbon;					
				endif;
				
				$allProducts = $product->getTypeInstance(true)
                ->getUsedProducts($product);
				$childArray = array();
				foreach ($allProducts as $associatedProduct) :
					$inventory = $StockState->getStockQty($associatedProduct->getId(), $websiteId);
					if ($associatedProduct->isSaleable()) :
						$childArray[] = $associatedProduct->getId();
					endif;
					if($inventory > 0):
						array_push($stockArray,$associatedProduct->getId());
					endif;
				endforeach;
				if(count($childArray) == 0):
					$ribbon = true;
				endif;
				
				if(count($stockArray) == 0):
					$ribbon = true;
				endif;
			break;
		}
		
		return $ribbon;		
	}
	
	/***************** Product Special Offer ****************/
	
	protected function getProductSpeicalOffer($product, $objectManager, $productType, $storeId, $websiteId)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
		$ribbon = false;
		
	
		if($productType == 'configurable') :
			$allProducts = $product->getTypeInstance(true)
							->getUsedProducts($product);
			$childArray = array();
			foreach ($allProducts as $associatedProduct) :				
				$finalPrice = $associatedProduct->getFinalPrice();
				$inventory = $StockState->getStockQty($associatedProduct->getId(), $websiteId);
				$oldPrice = $associatedProduct->getPrice();
				if(($finalPrice < $oldPrice) && ($inventory > 0)){
					$ribbon = true;
				}
				endforeach;	
		else:
			$finalPrice = $product->getFinalPrice();
			$oldPrice = $product->getPrice();
			if($finalPrice < $oldPrice):
				$ribbon = true;
			endif;	
		endif;
		return $ribbon;
	
    }
	
	/***************** Product Low Inventory ****************/
	
	protected function getProductLowQuantity($product_id)
     {
        $ribbon = false;
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productStockObj = $objectManager->get('Magento\CatalogInventory\Api\StockRegistryInterface')->getStockItem($product_id);
		if($productStockObj->getUseConfigMinQty() && $productStockObj->getTypeId() != 'configurable'):
            $scopeConfig = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');
            $minQty = $scopeConfig->getValue(
                \Magento\CatalogInventory\Block\Stockqty\AbstractStockqty::XML_PATH_STOCK_THRESHOLD_QTY,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        elseif($productStockObj->getTypeId() != 'configurable'):
            $minQty = $productStockObj->getMinQty();
        endif;
        $qty = $productStockObj->getQty();

        if(isset($minQty) && $qty <= $minQty):
            $ribbon = true;
        endif;
        return $ribbon;
     }
	
	
	/***************** Product New Ribbbon ****************/
	Protected function getProductNew($product)
	{
		$ribbon = false;
		$dateformat  = new \DateTime();
		$today = $dateformat->format('Y-m-d H:i:s');
        $productType = $product->getTypeId();
        $productid = $product->getId();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		if($productType == 'configurable') :
			$allProducts = $product->getTypeInstance(true)
							->getUsedProducts($product);
			$childArray = array();
			foreach ($allProducts as $associatedProduct) :	
				$associatedProductId = $associatedProduct->getId();
				$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
									->addAttributeToFilter('entity_id', $associatedProductId)
									->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $today))
									->addAttributeToSelect('*');
				foreach($productCollection->getData() as $collection):
					if($collection['news_from_date']):
						$ribbon = true;
					endif;
				endforeach;
			endforeach;	
		else:			
			$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
								->addAttributeToFilter('entity_id', $productid)
								->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $today))
								->addAttributeToSelect('*');		
			foreach($productCollection->getData() as $collection):
				if($collection['news_from_date']):
					$ribbon = true;
				endif;
			endforeach;
		endif;
		return $ribbon;		
	}

    protected function getCatalogRulePrice($product_id)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
        $ctPrice= $product->getPriceModel()->getFinalPrice(1,$product);
        $FPrice = $product->getFinalPrice();
        $newPrice = $product->getPrice();

        if ($product->getTypeId() != 'configurable' && $FPrice != $newPrice):
            return true;
        endif;

    }

}
?>