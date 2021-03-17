<?php
/*
namespace Aislend\OrderManager\Observer;
use \Mofluid\Mofluidapi2\Helper\Data;

class Salesorderplaceafter implements \Magento\Framework\Event\ObserverInterface
{
  private $api_url='https://creator.zoho.in/api/';
    private $store_user='raks.bisht';
    private $app_name='order-management';
    private $authtoken="0f2097bf0c92c8bc8c402a58bac6542b";
    private $scope="creatorapi";


    private $data=[];

    protected $connector; 
    protected $messageManager;
    protected $redirect;
    protected $logger;
    protected $helper;

	public function __construct(\Psr\Log\LoggerInterface $logger, Data $helper)
	{
	    $this->logger = $logger;
      $this->helper=$helper;
	}
    private function getUrl($action){
      
      return   $this->api_url.$this->store_user."/json/".$this->app_name.$action;

    }

    public function callAPI($method, $url, $data=[], $headers = false){

      if($data){

        $data['authtoken']=$this->authtoken;
        $data['scope']=$this->scope;
        $data['raw']=true;

      }

      $this->logger->info("ORDER PLACED EVENT TRACKER CALLING ZOHO params=>" .json_encode($data));
 
       $curl = curl_init();
       switch ($method){
          case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
          case "PUT":
             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
             break;
          default:
             if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
       }
       // OPTIONS:
       curl_setopt($curl, CURLOPT_URL, $url);
       // if(!$headers){
       //     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       //       // 'APIKEY: 111111111111111111111',
       //        'Content-Type: application/json',
       //     ));
       // }else{
       //     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       //        //'APIKEY: 111111111111111111111',
       //        'Content-Type: application/json',
       //        $headers
       //     ));
       // }
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       // EXECUTE:
       $result = curl_exec($curl);
       if(!$result){die("Connection Failure");}
       curl_close($curl);
       return $result;
    }

  public function execute(\Magento\Framework\Event\Observer $observer) 
  {  $order = $observer->getEvent()->getOrder();
     $order_id=$order->getEntityId();
     $order_type=$order->getShippingMethod();
     $item=$order->getAllItems();

               $this->logger->info("Current order id " .$order_id);
               $this->logger->info("Current order type " .$order_type);
     if($order_id){

       $pickup_delivery_time= $this->helper->getDeliveryPickupTime($order_id,$order_type);
          $this->logger->info("Current order time " .$pickup_delivery_time);

        if( $pickup_delivery_time){
          $this->logger->info("Current order time " .$pickup_delivery_time);
                         $order_type=$order->getShippingMethod() == "amstorepickup_amstorepickup" ? 'Pickup' : 'Delivery';

           $this->helper->assignOrderToPicker($order_id,$order_type,$pickup_delivery_time);
     
        }

     }

   

  }
	public function execute123(\Magento\Framework\Event\Observer $observer) 
	{ $this->logger->info("ORDER PLACED EVENT TRACKER");

        $order = $observer->getEvent()->getOrder();
        $statuscode=$order->getStatus();
        $customerId = $order->getCustomerId();
        		$this->logger->info("New ORDER PLACED EVENT TRACKER STATUS=>" .$statuscode);

        if($statuscode== "placed"){
        		$this->logger->info("ORDER PLACED EVENT TRACKER CALLING ZOHO=>" .$statuscode);

          $api_url=$this->getUrl("/form/New_Order/record/add");
        		$this->logger->info("ORDER PLACED EVENT TRACKER CALLING ZOHO API=>" .$api_url);


          // $billingaddress=$order->getBillingAddress();
          // $shippingaddress=$order->getShippingAddress();        
          $customername=$order->getCustomerFirstname().' '.$order->getCustomerLastname();
          // $customer_email=$order->getCustomerEmail();

          $order_id=$order->getId();
          $ordertype=$order->getShippingMethod();
          if($ordertype=='amstorepickup_amstorepickup'){
             $ordertype="Pickup";
          }else{

            $ordertype="Delivery";
          }

          $this->logger->info("ORDER PLACED SHIPPING METHOD /ORDER TYPE=>" .$ordertype);


          // $customer_username=$customername;
          // $customer_phone=$billingaddress->getTelephone();
          // $customer_address=$billingaddress->getStreet();
          $params=[
                "User_Order_Id"=>$order_id,
                "Order_Type"=>$ordertype,
                "Sales_Owner"=>1,
               // "Customer"=>$customername,
                "Order_Date"=>"12-Jun-2020",
                "Sub_Total"=>$order->getSubtotal(),
                "Tax"=>1,
                "Net_Total"=>$order->getGrandTotal(),
                "Total_Quantity"=>$order->getTotalQtyOrdered(),
                "Total_Items"=>$order->getTotalItemCount(),
             //   "Order_Preparation_Time"=>"",
                "Pickup_Time"=>"",
                "Delivery_Time"=>"",
                "Order_Time"=>"",
                "Payment_Method"=>"Card",
                "Address"=>"1009  Adams Avenue",
                "Order_Preparation_Time"=>"",
                "Status"=>"Pending"

               ];



          $response = $this->callAPI('POST', $api_url, $params);

        		$this->logger->info("ORDER PLACED EVENT TRACKER CALLING ZOHO API RESPONSE=>" .$response);




             $controller = $observer->getControllerAction();

            if($order->getState() == "confirmed")
            { 
              //$order->getShippingMethod();

                // $this->messageManager->addSuccess(__('Order status change successfully')); 
                // $this->redirect->redirect($controller->getResponse(), $this->redirect->getRefererUrl()); 
            }

    }
  }
}

*/