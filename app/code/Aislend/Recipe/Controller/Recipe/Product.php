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
class Product extends \Magento\Framework\App\Action\Action
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
		$priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data'); // Instance of Pricing Helper
        $recipeIds = $this->getRequest()->getParam('ingredients');
		if($recipeIds == '')
		{
			$response[] = ['selectedProduct' =>array('status'=>'failed')];
			echo json_encode($response);			
			return;
		}
        $arrayList = explode(",",$recipeIds);
        $ingredientsCheck = array($arrayList);
        $countMoreOption = $this->getMoreOption($arrayList);
        $productcollection = $this->_productCollection->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('ingredients', $arrayList)
			->addAttributeToFilter('status', 1)
            ->load();
        $attribute = $this->_eavAttribute->getAttribute('catalog_product', 'ingredients');
        $response = array();
        $resultJson = $this->resultJsonFactory->create();
        $image = 'product_thumbnail_image';
        foreach($productcollection as $collection):
            if(in_array($collection->getIngredients(), $ingredientsCheck)):
                continue;
            else:
                $ingredientsCheck[] = $collection->getIngredients();
            endif;
            $productStock = $this->getProductIsStockOrNot($collection->getId());
			if($productStock == false): continue; endif;
			$productVisibility = $collection->getVisibility();
			if($productVisibility == 1): continue; endif;
			if($collection->getTypeId() == 'virtual'): continue; endif;			
            $getCount = count($countMoreOption['ingredient_'.$collection->getIngredients()]);
            $displayText = ($getCount > 1) ?  'More options' : '';            
			$ingredients = strtolower($attribute->getSource()->getOptionText($collection->getIngredients()));
			$ingredients = str_replace(' ', '_', $ingredients);
			$response[] = [
                'ingredientsID'=>$collection->getIngredients(),
                'ingredients' => $ingredients,
                'ingredientsName' => $attribute->getSource()->getOptionText($collection->getIngredients()),
				'more_option'=>$displayText,
				'checkboxId'=> 'checkbox__'.$collection->getIngredients(),
                'selectedProduct' =>array(
										'name' => $collection->getName(),
										'price' => $priceHelper->currency($collection->getPrice(), true, false),
										'price_check' => $collection->getPrice(),
										'src' => $this->_imageHelper->init($collection, $image)->resize('65','65')->getUrl(),
										'productId'=>$collection->getId(),
										'productUrl'=>$collection->getProductUrl(),										
										'qty'=> 'qty_'.$collection->getId(),
										'outofstock'=>$productStock								
									)
            ];
        endforeach;
        echo json_encode(($response));
        return ;
    }

    public function getMoreOption($ingredientsIds)
    {
        $countMoreOption = array();
        $productcollection = $this->_productCollection->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('ingredients', $ingredientsIds)
            ->load();
        foreach($productcollection as $collection):
            $ingredientsCheck['ingredient_'.$collection->getIngredients()][] = $collection->getIngredients();
        endforeach;
        return $ingredientsCheck ;
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