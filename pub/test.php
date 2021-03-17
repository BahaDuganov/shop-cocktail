<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
require '../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$id = 8206;
$product = $objectManager->create('\Magento\Catalog\Model\Product')->load($id);

echo $product->getName();



$orderId = '129';
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
// $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
 $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);
 $quote= $objectManager->create('Magento\Quote\Model\Quote')->load($order->getQuoteId());
 $items=$quote->getAllVisibleItems();
$quoteToOrder = $objectManager
            ->create(
                'Magento\Quote\Model\Quote\Item\ToOrderItem'
            );
 
$order = $objectManager
           ->create(
                     'Magento\Sales\Model\Order'
           )->load($orderId);
 
$quote = $objectManager
        ->create(
            '\Magento\Quote\Model\Quote'
        )->load($order->getQuoteId());


foreach ($items as $quoteItem) {
    $origOrderItem = $order->getItemByQuoteItemId($quoteItem->getId());
    $orderItemId = $origOrderItem->getItemId();
    //update quote item according your need 
}
$quote->collectTotals();
$quote->save();

foreach ($items as $quoteItem) {
    $orderItem = $quoteToOrder->convert($quoteItem);
    $origOrderItemNew = $order->getItemByQuoteItemId($quoteItem->getId());

    if ($origOrderItemNew) {
        $origOrderItemNew->addData($orderItem->getData());
    } else {
        if ($quoteItem->getParentItem()) {
            $orderItem->setParentItem(
                $order->getItemByQuoteItemId($orderItem->getParentItem()->getId())
            );
        }
        $order->addItem($orderItem);
    }
}
$order->setSubtotal($quote->getSubtotal())
    ->setBaseSubtotal($quote->getBaseSubtotal())
    ->setGrandTotal($quote->getGrandTotal())
    ->setBaseGrandTotal($quote->getBaseGrandTotal());
$quote->save();
$order->save();


// $orderId = 129;//order id = 100 
// $itemRemoves = ['605'=> true];//item id= 100
// $itemQtys = ['1001'=> 1,'1002'=>2];//item ids 1001 with qty=1, 1002 with qty=2 
// $newProductQty = ['1003'=> 3,'1004'=>4];// product id 1003 with qty=3, 1004 with qty=4 


// $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
// $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);

// $quote= $objectManager->create('Magento\Quote\Model\Quote')->load($order->getQuoteId());


// foreach ($itemRemoves as $id => $value){


//     if($value){

//       foreach ($quote->getAllVisibleItems() as $quoteItem) {

//             if ($id == $quoteItem->getId()){
//                 $quoteItem->delete();
//                 $quote->collectTotals();



//                 foreach ($order->getItemsCollection() as $orderItem){

//                     if($orderItem->getQuoteItemId() == $id){
//                        $orderItem->delete($orderItem->getId());

//                     }
//                 }
//             }
//             else
//             {
               
//             }
//        }
//        unset($itemQtys[$id]);
//     }
// }
