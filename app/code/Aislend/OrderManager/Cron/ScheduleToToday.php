<?php

namespace Aislend\OrderManager\Cron;
use \Mofluid\Mofluidapi2\Helper\Data;

class ScheduleToToday
{
    protected $helper;
    public function __construct(Data $helper)
    {
        $this->helper=$helper;
    }
    public function execute()
    {

        //$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
        //$logger = new \Zend\Log\Logger();
        //$logger->addWriter($writer);

        $orders=$this->helper->getScheduledOrders();

        //$logger->info("CRON move to today from schedule ");
        //$logger->info("TOTAL  ORDERS COUNT =>".count($orders));

        if(count($orders)){
            foreach ($orders as $key => $orders) {
                $picker_id=$key;
                $order_ids=array_column($orders, 'order_id');
                $totalorders=count($order_ids);
                if($totalorders==1){
                    $order_tot=$totalorders.' order ';
                }else{
                    $order_tot=$totalorders.' orders ';
                }
        	$order_ids_db = "'".implode ("','", $order_ids )."'";
		$ordersmoved=$this->helper->moveScheduleToToday($order_ids_db);
				
        	if($ordersmoved){
                    //foreach($order_ids as $key =>$ordId){
                    $notification_params=[
                        'order_id'=>0,
                        'user_id'=>$picker_id,
                        'user_type'=>'picker',
                        'notification_type'=>'normal',
                        'channel'=>$this->helper->PICKER_CHANNEL.$picker_id,
                        'type'=>"move-order-to-today",
                        'subject'=>'scheduled order for today',
                        'message'=>$totalorders.' scheduled order(s) are available to shop today.',
                        'platform'=>'ios',
                        'created_at'=>date('Y-m-d h:i:s')
                    ];

                    $resp= $this->helper->pushNotification($notification_params);
                    //}
                }
            }
    	}
	// $logger->info(__METHOD__);
	 return true;
    }
}
