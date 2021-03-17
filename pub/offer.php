<?php
use Magento\Framework\App\Bootstrap;
 
/**
 * If your external file is in root folder
 */
//require __DIR__ . '/app/bootstrap.php';
 
/**
 * If your external file is NOT in root folder
 * Let's suppose, your file is inside a folder named 'xyz'
 *
 * And, let's suppose, your root directory path is
 * /var/www/html/magento2
 */
$rootDirectoryPath = '/chroot/home/citymark/citymarketnorwalk.com/html';
require $rootDirectoryPath . '/app/bootstrap.php';
 
$params = $_SERVER;
 
$bootstrap = Bootstrap::create(BP, $params);
 
$obj = $bootstrap->getObjectManager();
 
error_reporting(E_ALL);
ini_set("display_errors", 1);

$AreaCode = $obj->get('Magento\Framework\App\State');
$AreaCode->setAreaCode('frontend');

$categoryFactory = $obj->get('\Magento\Catalog\Model\CategoryFactory');
$categoryId = 53;
$category = $categoryFactory->create()->load($categoryId);
$categoryProducts = $category->getProductCollection()->addAttributeToSelect('*');
                       
foreach ($categoryProducts as $product) {
	$sku = $product->getSku();
	$CategoryLinkRepository = $obj->get('Magento\Catalog\Api\CategoryLinkRepositoryInterface');
	$CategoryLinkRepository->deleteByIds($categoryId, $sku);
}

$minprice = 0;
$fromnow = date('Y-m-d H:i:s');
$tonow1 = date('Y-m-d H:i:s');
$tonow = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($tonow1)));
$collection = $obj->create('Magento\Catalog\Model\ResourceModel\Product\Collection');

$collection = $collection->addAttributeToSelect('*')->addAttributeToFilter('status', array('eq' => 1))->addAttributeToFilter('visibility', array('eq' => 4))->addAttributeToSelect('special_from_date')->addAttributeToSelect('special_to_date')->addAttributeToFilter('special_price', ['neq' => ''])->addAttributeToFilter('special_from_date',['lteq' => date('Y-m-d H:i:s', strtotime($fromnow))])->addAttributeToFilter('special_to_date',['gteq' => date('Y-m-d H:i:s', strtotime($tonow))]);

foreach ($collection as $product){
	$sku = $product->getSku();
	echo $sku;
	$category_id = array('53');
	
	$CategoryLinkManagement = $obj->get('Magento\Catalog\Api\CategoryLinkManagementInterface');
	$CategoryLinkManagement->assignProductToCategories($sku, $category_id);
}
/* $category_id = array('53');
$CategoryLinkManagement = $obj->get('Magento\Catalog\Api\CategoryLinkManagementInterface');
$CategoryLinkManagement->assignProductToCategories('012000809941', $category_id); */
?> 