<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aislend\Recipe\Controller\Recipe;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;

/**
 * Login controller
 *
 * @method \Magento\Framework\App\RequestInterface getRequest()
 * @method \Magento\Framework\App\Response\Http getResponse()
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MoreOption extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\Json\Helper\Data $helper
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;


    protected $resultLayoutFactory;

    protected $_productloader;	
	
	protected $imageHelper;
	protected $eavAttribute;
	
	/**
     * @var Item
     */
    protected $stockItem;
	

    /**
     * Initialize Login controller
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Json\Helper\Data $helper
     * @param AccountManagementInterface $customerAccountManagement
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
		\Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productloader,
		\Magento\Eav\Model\Config $eavAttribute,
		\Magento\CatalogInventory\Model\Stock\Item $stockItem
		
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
		$this->_imageHelper = $imageHelper;
        $this->_productCollection = $_productloader;
		$this->_eavAttribute = $eavAttribute;
		$this->stockItem = $stockItem;		
    }
    public function execute()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of Object Manager
		$attribute = $this->_eavAttribute->getAttribute('catalog_product', 'ingredients');
		$priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data'); // Instance of Pricing Helper
		$image = 'product_thumbnail_image';
		if($this->getRequest()->getParam('ingredients')):
			$recipeIds = $this->getRequest()->getParam('ingredients');	
			$productcollection = $this->_productCollection->create()
				->addAttributeToSelect('*')
				->addAttributeToFilter('ingredients', array($recipeIds))
				->addAttributeToFilter('status', 1)
				->load();					
			$response = array();
			$resultJson = $this->resultJsonFactory->create();			
			foreach($productcollection as $collection):			
				$productStock = $this->getProductIsStockOrNot($collection->getId());				
				$ingredients = strtolower($attribute->getSource()->getOptionText($collection->getIngredients()));
				if($productStock == false): continue; endif;
				$productVisibility = $collection->getVisibility();
				if($collection->getTypeId() == 'virtual'): continue; endif;	
				$ingredients = str_replace(' ', '_', $ingredients);
				$response[] = [                
				'selectedProduct' =>array(
										'name' => $collection->getName(),
										'price' => $priceHelper->currency($collection->getPrice(), true, false),
										'ingredients' => $ingredients,
										'ingredientsName' => $attribute->getSource()->getOptionText($collection->getIngredients()),
										'price_check' => $collection->getPrice(),
										'src' => $this->_imageHelper->init($collection, $image)->resize('65','65')->getUrl(),
										'productId'=>$collection->getId(),
										'productUrl'=>$collection->getProductUrl(),										
										'qty'=> 'qty_'.$collection->getId(),
										'checkboxId'=> 'checkbox__'.$collection->getIngredients(),
										'outofstock'=>$productStock								
									)
            ];		
			endforeach;
		else :
			$productId = $this->getRequest()->getParam('product');
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
			$productStock = $this->getProductIsStockOrNot($product->getId());
			/* $response[] = [
					'ingredientsID'=>$product->getIngredients(),
					'ingredients' => $attribute->getSource()->getOptionText($product->getIngredients()),
					'name' => $product->getName(),
					'price' => $priceHelper->currency($product->getPrice(), true, false),
					'src' => $this->_imageHelper->init($product, $image)->resize('65','65')->getUrl(),
					'productId'=>$product->getId(),
					'productUrl'=>$product->getProductUrl()
				]; */
			$ingredients = strtolower($attribute->getSource()->getOptionText($product->getIngredients()));
			$ingredients = str_replace(' ', '_', $ingredients);
			$response[] = [                
				'selectedProduct' =>array(
										'name' => $product->getName(),
										'price' => $priceHelper->currency($product->getPrice(), true, false),
										'price_check' => $product->getPrice(),
										'ingredients' => $ingredients,
										'src' => $this->_imageHelper->init($product, $image)->resize('65','65')->getUrl(),
										'productId'=>$product->getId(),
										'productUrl'=>$product->getProductUrl(),										
										'qty'=> 'qty_'.$product->getId(),
										'checkboxId'=> 'checkbox__'.$product->getIngredients(),
										'ingredientsName' => $attribute->getSource()->getOptionText($product->getIngredients()),
										'outofstock'=>$productStock								
									)
            ];		
		endif;
			 
        echo json_encode(($response)); 
        return ;
    }
	
	public function getProductIsStockOrNot($productId)
    {
		$stock = false;		
        $_productStock = $this->stockItem->load($productId, 'product_id');			
		if($_productStock->getQty() > $_productStock->getMinQty() && $_productStock->getIsInStock()):
			$stock = true;
		endif;
		return $stock;        
    }
	

}