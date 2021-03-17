<?php namespace Aislend\Tookan\Observer; 
use Magento\Framework\Event\ObserverInterface; 

class Observer implements ObserverInterface { 

	private $api_url='https://api.tookanapp.com/v2/';
	private $api_token='5667618cf141534a544477395447254315e4c1f222de7936581805';
    private $data=[];

    protected $connector; public function __construct() { 
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       
    }
    private function callApi($apiroute,$method='GET',$params){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->api_url.$apiroute);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: '.strlen($params)));
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

      $result = curl_exec($ch);
    }
    private function createRequest($apiroute,$method='GET',$params){
        
        $token = 'token';
        $httpHeaders = new \Zend\Http\Headers();
        $httpHeaders->addHeaders([
          // 'Authorization' => 'Bearer ' . $token,
          // 'Accept' => 'application/json',
           //'Content-Type' => 'application/json'
        ]);
         $request = new \Zend\Http\Request();
         $request->setHeaders($httpHeaders);
         $request->setUri($this->api_url.$apiroute);
         $request->setMethod(\Zend\Http\Request::METHOD_POST);

         $params = new \Zend\Stdlib\Parameters($params);
         $request->setQuery($params);

         $client = new \Zend\Http\Client();
        $options = [
           'adapter'   => 'Zend\Http\Client\Adapter\Curl',
           'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
           'maxredirects' => 0,
           'timeout' => 30
         ];
         $client->setOptions($options);

         $response = $client->send($request);
    }

    public function execute(\Magento\Framework\Event\Observer $observer) { 
        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        

        if($customerId){

            $billingaddress=$order->getBillingAddress();
              $shippingaddress=$order->getShippingAddress();        


            $customername=$order->getCustomerFirstname().' '.$order->getCustomerLastname();
            $params=[
                  "api_key"=>$this->api_token,
                  "order_id"=> $order->getId(),
                  "team_id"=> "",
                  "auto_assignment"=> "1",

                  "job_description"=> "Product Delivery",

                  "job_pickup_phone"=> "Pickup User Phone",
                  "job_pickup_name"=> "Pickup User Name",
                  "job_pickup_email"=> "Pickup User Email",
                  "job_pickup_address"=> "Pickup Address",
                  //"job_pickup_latitude"=> "30.7188978",
                  //"job_pickup_longitude"=> "76.810296",
                  "job_pickup_datetime"=> "Pickup User Email",

                  "customer_email"=> $order->getCustomerEmail(),
                  "customer_username"=> $customername,
                  "customer_phone"=> $billingaddress->getTelephone(),
                  "customer_address"=> $billingaddress->getStreet(),
                 // "latitude"=> "30.7188978",
                  //"longitude"=> "76.810298",
                 "job_delivery_datetime"=> "Deliver Date Time", 
                  "has_pickup"=> "1",
                  "has_delivery"=> "1",
                  "layout_type"=> "0",
                  "tracking_link"=> 1,
                  "timezone"=> "-330",
                  // "custom_field_template"=> "Template_1",
                  // "meta_data"=> [
                  //   {
                  //     "label"=> "Price",
                  //     "data"=> "100"
                  //   },
                  //   {
                  //     "label"=> "Quantity",
                  //     "data"=> "100"
                  //   }
                  // ],
                  // "pickup_custom_field_template"=> "Template_2",
                  // "pickup_meta_data"=> [
                  //   {
                  //     "label"=> "Price",
                  //     "data"=> "100"
                  //   },
                  //   {
                  //     "label"=> "Quantity",
                  //     "data"=> "100"
                  //   }
                  // ],
                  "fleet_id"=> "",
                  // "p_ref_images"=> [
                  //   "http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png",
                  //   "http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png"
                  // ],
                  // "ref_images"=> [
                  //   "http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png",
                  //   "http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png"
                  // ],
                  "notify"=> 1,
                  "tags"=> "",
                  "geofence"=> 0,
                  "ride_type"=> 0
            ];
           // $this->callApi('create_task','POST',json_encode($params));

            $this->createRequest('create_task','POST',json_encode($params));

            #do something with order an customer
    }
  }
}