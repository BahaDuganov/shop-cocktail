<?php
namespace Aislend\Custometa\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;  

class Custometa implements \Magento\Framework\Event\ObserverInterface
{
	
	protected $registry;
    protected $request;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Registry $registry
    ) {
        $this->request      = $request;
        $this->registry = $registry;
    }
	
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
	  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	 $requestOb = $objectManager->get('Magento\Framework\App\Request\Http'); 
	 //$requestOb->getModuleName();$requestOb->getControllerName();
		if($requestOb->getActionName()== 'view') {
		

	 $category = '';
     $product = $observer->getProduct();
	   //if ($metaTitle = $product->getMetaTitle()) { 
			$metaTitle = '';
			$metaDescription = '';
			$metaKeywords = '';
			//$metaDescription = $product->getDescription();
			//echo $product->getId();
			//die();
			
			$proCats = $product->getCategoryIds();
			if(count($proCats) > 2) {
				$categoryId = $proCats[count($proCats)-2];
			} else {
				if(count($proCats) > 1)
					$categoryId = $proCats[1];
				else
					$categoryId = $proCats[0];
			}
				
				$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$category = $_objectManager->create('Magento\Catalog\Model\Category')
				->load($categoryId);
				$catName = $category->getName();

			//}
			//die();
			
			if($product->getPackSize()) {
				$Size = ' - '.$product->getPackSize();
			}
			else if($product->getProductWeight()) {
				$Size = ' - '.$product->getProductWeight();
			} else {
				$Size = '';
			}
			//die();
			//$Size = ' - '. $product->getProductWeight() != '' ? $product->getProductWeight() : $product->getPackSize() ;
			if($product->getMetaTitle() != '') {
				$metaTitle .= $product->getMetaTitle() ;
			} else {
				$metaTitle .= html_entity_decode($product->getName()).$Size.' - just at $'.$product->getFinalPrice().' - CityMarketNorwalk.com';
			}
			
			if($product->getMetaDescription() != '') {
				$metaDescription .= $product->getMetaDescription();
			} else {
				$metaDescription .= 'Buy '.html_entity_decode($product->getName()).$Size.' - Just at $'.$product->getFinalPrice().' from CityMarketNorwalk.com. Shop from the huge collection of '.$catName.'. ✓ Select Coverage Area ✓ Choose best convenient delivery time ✓ Same Day Delivery';
			}
			//die();
			if($product->getMetaKeyword() != '') {
				$metaKeywords .= $product->getMetaKeyword();
			} else {
				$metaKeywords .= html_entity_decode($product->getName()).', Buy '.html_entity_decode($product->getName()).' online, '.html_entity_decode($product->getName()).' near me, '.html_entity_decode($product->getName()).' $'.$product->getFinalPrice();
			}
			$product->setMetaTitle($metaTitle);
			$product->setMetaDescription($metaDescription);
			$product->setMetaKeyword($metaKeywords);
            $product->setIsMetaApplied(true);
        //}

     return $this;
	}
  }
}