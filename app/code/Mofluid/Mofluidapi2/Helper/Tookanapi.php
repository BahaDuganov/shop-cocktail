<?php
namespace Mofluid\Mofluidapi2\Helper;


class Tookanapi{
    private $api_url='https://api.tookanapp.com/v2/';
    private $api_token='5667678cf44656025e4775671058254315e1c7f82adc7a395e1d09';
    private $team_id='576829';
    private  $tookan_shared_secret='VMMGhcMbudAkReRq';
    public $driver_statuses=[
        0=>'Assigned',
        1=>'Started	',
        2=>'Successful',
        3=>'Failed',
        4=>'InProgress',
      //  5=>'Unassigned',
        6=>'Unassigned',
        7=>'Accepted',
        8=>'Decline',
        9=>'Cancel',
        10=>'Deleted'
    ];
    public $statusesfordriver=[
        0=>'Assigned',
        1=>'in_transit',//
        2=>'delivered',//
        3=>'canceled',//
        4=>'InProgress',
        6=>'Unassigned',
        7=>'Accepted',
        8=>'Decline',
        9=>'Cancel',
        10=>'Deleted'
    ];
    public function __construct(){
        
    }
    

    private  function createTask($order,$driver_id){


        $params = [
            "api_key" => $this->api_token,
            "order_id" =>$order['order_id'],
            "job_description" => $order['job_description'],
            "customer_email" => $order['email'],
            "customer_username" => $order['name'],
            "customer_phone" => $order['phone'],
            "customer_address" => $order['address'],
            "latitude" => "",
            "longitude" => "",
            "job_delivery_datetime" => $order['time'],
            "custom_field_template" => "Template_1",
            "meta_data" =>$order['template_data'],
            "team_id" => $this->team_id,
            "auto_assignment" => "0",
            "has_pickup" => "0",
            "has_delivery" => "1",
            "layout_type" => "0",
            "tracking_link" => 1,
            "timezone" => "-330",
            "fleet_id" => $driver_id,
//            "ref_images" => [
//                "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png",
//                "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png"
//            ],
            "notify" => 1,
            "tags" => "",
            "geofence" => 0
        ];



        $resp=$this->callApi('create_task','POST',json_encode($params));
        $resp=!empty($resp)?json_decode($resp):$resp;
        if($resp &&  $resp->status==200){
            return $resp->data;
        }
        return '';

    }

    public  function getDrivers(){
        $params=[
            "api_key"=>$this->api_token,
            /*
            "tags"=>"mini,suv",
            "name"=>"manish",
            "fleet_ids"=>[49322, 42947],
            "include_any_tag"=>1,
            "status"=>0,
            "fleet_type"=>1
            */
        ];
        $resp=$this->callApi('get_all_fleets','POST',json_encode($params));
        $resp=!empty($resp)?json_decode($resp):$resp;
        if($resp &&  $resp->status==200){
            return $resp->data;
        }
        return '';
    }

    public  function assignDrivers($job_ids){
        $params=[
            "api_key"=>$this->api_token,
            "job_ids"=>$job_ids,
            /*
            "user_id"=>12345,
            "team_id"=>123,
            "fleet_id"=>123456,
            */
        ];
        $resp=$this->callApi('reassign_open_tasks','POST',json_encode($params));
        $resp=!empty($resp)?json_decode($resp):$resp;
        if($resp &&  $resp->status==200){
          return $resp->data;
        }
        return '';
    }

    public  function createAssignTask($orders,$driver_id){
        $params = [
            "api_key" =>$this->api_token,
            "fleet_id" => $driver_id,
            "timezone" => -330,
            "has_pickup" => 0,
            "has_delivery" => 1,
            "layout_type" => 0,
            "geofence" => 0,
            "team_id" =>$this->team_id,
            "auto_assignment" => 0,
            "tags" => "",
            "deliveries" =>$orders
        ];


        $resp=$this->callApi('create_multiple_tasks','POST',json_encode($params));
        $resp=!empty($resp)?json_decode($resp):$resp;
        if($resp &&  $resp->status==200){
            return $resp->data;
        }
        return '';
    }
    public  function getTasks(){

//        https://api.tookanapp.com/v2/get_all_tasks
//            {
//            "api_key": "5667678cf44656025e4775671058254315e1c7f82adc7a395e1d09",
//            "job_type": 1,
//
//            "order_id": ["1033", "1048"]
//
//
//            }
    }

    public  function createDriver($params){ 
        //$requestData = array(
            $requestData["api_key"]=$this->api_token;
            $requestData["email"]=$params['email'];
            $requestData["phone"]=$params['phone'];
            $requestData["transport_type"]=1;
            $requestData["transport_desc"]="auto";
            $requestData["license"]="demo";
            $requestData["color"]="blue";
            $requestData["timezone"]="-330";
            $requestData["team_id"]="835274";
            $requestData["password"]=$params['password'];
            $requestData["username"]=$params['email'];
            $requestData["first_name"]=$params['name']; 
            $requestData["last_name"]="";
            $requestData["rule_id"]=$params['id'];
            $requestData["profile_url"]=$params['profile_image'];
            $requestData["profile_thumb_url"]=$params['profile_image'];
         
        $resp=$this->callApi('add_agent','POST',json_encode($requestData)); 
        $resp=!empty($resp)?json_decode($resp):$resp;
        $requestData['url']=$this->api_url;
        //print_r($insertdata);die;
        return [$resp->status,json_encode($requestData),$resp->data];
        /*if($resp &&  $resp->status==200){
            return $resp->data;
        }
        return '';*/
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

        return $result = curl_exec($ch);
    }
}
