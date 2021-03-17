<?php

namespace Aislend\OrderManager\Cron;
use \Mofluid\Mofluidapi2\Helper\Data;

class OrderProcess
{
    protected $helper;

	public function __construct(Data $helper)
	{
        $this->helper=$helper;
	}

    public function getOrderCollectionByStatus($statuses = [])
   {

      $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
      $orderDatamodel = $objectManager->get('Magento\Sales\Model\Order')->getCollection()->addFieldToSelect('*')->addFieldToFilter('status', array('in' =>$statuses))->setOrder('created_at', 'desc');

     return $orderDatamodel;

    }

	public function execute()
	{

		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);

		$orders=$this->getOrderCollectionByStatus('placed');
		$logger->info("CRON TESTING ");
		$logger->info("TOTAL PLACED ORDERS COUNT =>".count($orders));
        if(count($orders)){
        	foreach ($orders as $key => $order) {
					$order_id = $order->getId();

					if(!$this->helper->isOrderAssigned($order_id)){

					$order_type=$order->getShippingMethod();
					$statuscode=$order->getStatus();

					$logger->info("Current order id " .$order_id);
					$logger->info("Current order type " .$order_type);
					$logger->info("Current order status " .$statuscode);

					 $pickup_delivery_time= $this->helper->getDeliveryPickupTimeAndDate($order_id,$order_type);

					if( $pickup_delivery_time){

                        $logger->info("Current order time " .$pickup_delivery_time['date']);
						$order_type=$order->getShippingMethod() == "flatrate_flatrate" ? 'Pickup' : 'Delivery';
						$logger->info("Assign to Picker Star");

						$this->helper->assignOrderToPicker($order_id,$order_type,$pickup_delivery_time['date'],$pickup_delivery_time['time']);

						$logger->info("Assign to Picker Stop");

					}


			  }

        	}
        }


		$logger->info(__METHOD__);

		return $this;

	}
}
