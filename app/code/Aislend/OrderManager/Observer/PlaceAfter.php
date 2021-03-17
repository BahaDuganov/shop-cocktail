<?php
/*
namespace Aislend\OrderManager\Observer;
use \Mofluid\Mofluidapi2\Helper\Data;

class PlaceAfter 
{
  
    protected $logger;
    protected $helper;

	public function __construct(\Psr\Log\LoggerInterface $logger, Data $helper)
	{
	    $this->logger = $logger;
      $this->helper=$helper;
	}
  

   
   
    public function afterPlace(\Magento\Sales\Api\OrderManagementInterface $orderManagementInterface , $order)
    {
        $order_id = $order->getId();
                       $this->logger->info("Current order ALL ITEMS REMOVED " );

              // $this->logger->info("Current order id " .$order_id);

               $order_type=$order->getShippingMethod();
     $statuscode=$order->getStatus();

               $this->logger->info("Current order id " .$order_id);
               $this->logger->info("Current order type " .$order_type);
               $this->logger->info("Current order status " .$statuscode);
     if($order_id){

       $pickup_delivery_time= $this->helper->getDeliveryPickupTime($order_id,$order_type);
          $this->logger->info("Current order time " .$pickup_delivery_time);

        if( $pickup_delivery_time){
          $this->logger->info("Current order time " .$pickup_delivery_time);
                         $order_type=$order->getShippingMethod() == "amstorepickup_amstorepickup" ? 'Pickup' : 'Delivery';

           $this->helper->assignOrderToPicker($order_id,$order_type,$pickup_delivery_time);
     
        }

     }

        // do something with order object (Interceptor )
//
       return $order;
    }
	
}

*/