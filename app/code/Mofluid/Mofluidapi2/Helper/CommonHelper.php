<?php
namespace Mofluid\Mofluidapi2\Helper;
use \Mofluid\Mofluidapi2\Helper\Data;
use \Mofluid\Mofluidapi2\Helper\JwtHandler;
//use \Mofluid\Mofluidapi2\Helper\Delivery;



class CommonHelper{
    //use Delivery;
    protected $token;
    protected $auth;    
    protected $datahelper;
    protected $apisource='https://mulberry.shopper.run/';

    protected $sms_api='https://api.clickatell.com/rest/message';
 
    protected $sms_secret_key1='eshAj9h3Jvi9f5jpv6xMP7Olz5g_A6x3688Wr5dAp61KwkFDLeM_sw9Ubu93q6vPtW2ClX.C';
    protected $sms_secret_key='_xewhtqMmxStlVy2JSUtzHtdEC1pqb1RCqy8hxdTY_M1xaLuZgr2cNaZnGoOi_gzvpLem';
 
    /**
     * Temporary In code as discussed
     */
    public $fix_shopper_earning=6;
    public $shopper_run_fees=2;
    public $store_lat='40.75202';
    public $store_lng='-73.97149';
    public $store_address='Amish Market East, New York';
    public $store_mail_from='sales@aislend.com';    

	public function __construct()
	{
        $this->auth=new JwtHandler();
	}
    private function callRestApi($apiroute,$params){
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

  public function getProductBySku($sku){
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

     $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
     return $Rootproduct = $productRepository->get($sku);
   }
    public function orderHistory($orderid,$type=null){

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection = $resource->getConnection();

    if(empty($type)){
        $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND  order_id=$orderid order by id desc"; //add picker and delivery date condition here
    return $resultparent = $connection->fetchAll($sqlparent);

    }else{
            $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND order_id=$orderid AND type in (".$type.") order by id desc"; //  add picker and delivery date condition here
    return $resultparent = $connection->fetchAll($sqlparent);
    }
}

    public function getSlots($orderid,$type=null){

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection = $resource->getConnection();

    if(empty($type)){
        $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND  order_id=$orderid order by id desc"; //add picker and delivery date condition here
    return $resultparent = $connection->fetchAll($sqlparent);

    }else{
            $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND order_id=$orderid AND type in (".$type.") order by id desc"; //  add picker and delivery date condition here
    return $resultparent = $connection->fetchAll($sqlparent);
    }
}




     public function getOrderHistory($internalid,$ordertypes){
	$om = \Magento\Framework\App\ObjectManager::getInstance();
	$_storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');

    $currency='';
    $media_url = $_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
   $basecurrencycode = $_storeManager->getStore()->getBaseCurrencyCode();


        $product=[];

         $orderhistory=$this->orderHistory($internalid,$ordertypes);

         $orderjson=json_encode($orderhistory);


        if($orderhistory){
            foreach ($orderhistory as $key => $value) {



                  $product_status=$value['type'];

                  if($product_status=='refund'){

                  $item=$this->getProductBySku($value['product_sku']);


                         $product[] = array(
                                    "order_item_id"=>'',
                                    "name" => $item->getName(),
                                    "sku" => $value['product_sku'],
                                    "id" => $item->getId(),
                                    "todo"=>0,
                                    "product_status"=>$product_status,
                                    "quantity" =>$item->getIsQtyDecimal()?'1': (string)$value['quantity'],
                                    "weighted" => (bool) $item->getIsQtyDecimal(),
                                    "canceled_qty"=>"0.0000",
                                    "weight" =>(float)$value['quantity'],



                                );

                  }elseif ($product_status=='replace') {

                        $item=$this->getProductBySku($value['old_product_sku']);

                         $product[] = array(
                                     "order_item_id"=>'',
                                    "name" => $item->getName(),
                                    "sku" => $value['old_product_sku'],
                                    "id" => $item->getId(),
                                    "todo"=>0,
                                     "replaced_with_sku"=>$value['product_sku'],
                                     "replaced_with_order_item"=>$value['new_order_item_id'],

                                    "product_status"=>$product_status,
                                    "quantity" =>$item->getIsQtyDecimal()?'1': (string)$value['order_quantity'],
                                    "weighted" => (bool) $item->getIsQtyDecimal(),
                                    "canceled_qty"=>"0.0000",
                                    "weight" =>(float)$value['order_quantity'],




                                );
                  }

            }

        }

        return $product;
    }

	public function getInvoiceItems($internalid,$status){

	 //   return 'invoice items';

	    return $this->getOrderHistory($internalid,$status);
	}


    public function isAuth($header=null,$refreshauth=null){
        if(isset($header) && !empty(trim($header))):
            $this->token = explode(" ", trim($header));
            if(isset($this->token[1]) && !empty(trim($this->token[1]))):

                $data = $this->auth->_jwt_decode_data($this->token[1]);

                if(isset($data['auth']) && $data['auth'] && isset($data['data']->user_id) && isset($data['data']->user_type)):
                    $user=null;
                      $user = $this->getUser($data['data']->user_id);

                    if($refreshauth && $user){

                        $resp=[
                            'is_logged_in'=>1,
                            'user_id'=>$user['user_id'],
                            'user_type'=>$user['role'],
                            'user_work_type'=>$user['type'],
                            'name'=>$user['name'],
                            'email'=>$user['email'],
                        ];

                        $token = $this->auth->_jwt_encode_data($this->apisource,$resp);

                        $resp['token']=$token['token'];
                        $resp['exp']=$token['exp'];

                        return $resp;

                    }

                    return $user;

                else:
                    echo $this->formatOutput($_GET["callback"], null, Null, false,$data['message']);
                    exit;

                endif; // End of isset($this->token[1]) && !empty(trim($this->token[1]))

            else:
                return null;

            endif;// End of isset($this->token[1]) && !empty(trim($this->token[1]))

        else:
            return null;

        endif;
    }

     public function getUser($id){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select * FROM user_logins WHERE status='1' AND deleted_at IS NULL AND  id=$id";
        $resultparent = $connection->fetchRow($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=[

                'user_id'=>$resultparent['id'],
                'name'=>$resultparent['name'],
                'role'=>$resultparent['role'],
                'type'=>$resultparent['type'],
                'email'=>$resultparent['email'],
                'badge_count'=>$resultparent['badge_count'],
            ];
        }

        return $resp;

    }
    public function getUserByEmail($email){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select * FROM user_logins WHERE status='1' AND deleted_at IS NULL AND  email='".$email."'";
        $resultparent = $connection->fetchRow($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=[

                'user_id'=>$resultparent['id'],
                'name'=>$resultparent['name'],
                'role'=>$resultparent['role'],
                'email'=>$resultparent['email'],
            ];
        }

        return $resp;

    }
    public function createInserQuery($table,$data){
        $keys=implode(",",array_keys($data));
        $values="'" . implode ( "', '", array_values($data) ) . "'";
       return $sql= "Insert into $table ($keys) VALUES($values)";
    }
    public function createUpdateQuery($table,$data,$whitelist=null){
        $query = "UPDATE $table SET";
        $comma = " ";
        $whitelist = array(
            "name",
            "email"
            );
        foreach($data as $key => $val) {
           if( ! empty($val)) {
            //if( ! empty($val) && in_array($key, $whitelist)) {
                $query .= $comma . $key . " = '" .trim($val). "'";
                $comma = ", ";
            }
        }

        return $query;
    }
    public function register($usertype,$data){

        if(isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $data['password']= password_hash($data['password'], PASSWORD_DEFAULT);

            $sql=$this->createInserQuery($usertype,$data);
            $resultparent = $connection->query($sql);
            $res='';
            if($resultparent){
                echo $this->formatOutput($data["callback"], $res, Null, true, 'You have successfully registered.');
            }
        }

        echo $this->formatOutput($data["callback"], [], Null, false, 'Invalid request');


    }

    public function login($email,$password){
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select * FROM user_logins WHERE email='".$email."' AND status='1' AND deleted_at IS NULL"; //add picker and delivery date condition here
        $result = $connection->fetchRow($sqlparent);
        $resp=[
            'is_logged_in'=>0,
            //"sql"=>$sqlparent
        ];
        $msg='Invalid Login';

        $password = md5($password);
        if(isset($result['password']) && $password!=$result['password']){
            echo $this->formatOutput($_GET["callback"], $resp, Null, true, $msg);
            exit;
        }
        if($result){
           
            $resp['token']=$result;
            if($password === $result['password']){
                $resp=[
                    'is_logged_in'=>1,
                    'user_id'=>$result['id'],
                    'user_type'=>$result['role'],
                    'user_work_type'=>$result['type'],
                    'name'=>$result['name'],
                    'email'=>$result['email'],
                    'profile_image'=>$result['profile_image'],
                ];

                $token = $this->auth->_jwt_encode_data($this->apisource,$resp);

                $resp['token']=$token['token'];
                $resp['exp']=$token['exp'];
                $msg='Success';
                $this->updateActive($result['id'],1);
                $this->updateCheckIn($result['id']);
            }

        }

        echo $this->formatOutput($_GET["callback"], $resp, Null, true, $msg);
        exit;

    }

    public function accountupdate($usertype,$data){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql=$this->createUpdateQuery($usertype,$data);
        print_r($data);die;
        $sql=$sql." where id=";
        $result = $connection->query($sql);

        return $result;

    }

    private function formatOutput($callBack, $data, $errorCode = Null, $success = true, $mesg = null) {
        $array = array('metadata' =>
            array('success' => $success, 'errorCode' => $errorCode, 'message' => $mesg)
            , 'payload' =>
            array('data' => $data)
        );
        return $callBack . json_encode($array);
    }

    public function getPickerByOrder($order_id){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "SELECT picker_order.picker_id,picker.name,picker_order.order_id,picker_order.id as picker_order_increment FROM picker_order join user_logins as picker on picker_order.picker_id=picker.id where picker_order.status=1 AND picker_order.order_id=$order_id AND picker.deleted_at IS NULL order by picker_order_increment desc limit 1
";
        $resultparent = $connection->fetchRow($sqlparent);
        return $resultparent;

    }
    public function getDriverByOrder($order_id){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "SELECT driver_order.driver_id,driver.name,driver_order.order_id,driver_order.id as driver_order_increment FROM driver_order join user_logins as driver on driver_order.driver_id=driver.id where driver_order.status=1 AND driver_order.order_id=$order_id AND driver.deleted_at IS NULL order by driver_order_increment desc limit 1
";
        $resultparent = $connection->fetchRow($sqlparent);
        return $resultparent;

    }

    public  function generateNumericOTP($n) {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }

        // Return result
        return $result;
    }

    public  function saveOtp($user_id){

        $otp=$this->generateNumericOTP(6);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "Insert into user_otp ( `user_id`, `otp`) VALUES ($user_id,$otp)";
        $resultparent = $connection->query($sqlparent);
        if($resultparent){
            return $otp;
        }
        return '';

    }

    public  function getStore(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $store=$resource->getStore();

        return [
            'name'=>$store->getName(),
            'email'=>$store->getEmail()
        ];

    }

     public  function sendMail($to,$nameTo,$subject,$body){
	    $transport='';

	    if($configs=$this->getSmtpFromDb()){
            $config = array('auth' => $configs['auth'],
                'username' =>  $configs['username'],
                'password' =>  $configs['password'],
                'port' =>  $configs['port'],
                'ssl' =>  $configs['ssl']
            );


            $transport = new \Zend_Mail_Transport_Smtp($configs['host'], $config);

        }

        $store=$this->getStore();
        // $to = ['email1@test.com', 'email2@test.com'];
        $email = new \Zend_Mail();
        $email->setSubject($subject);
        $email->setBodyText($body);
        //  $email->setBodyHtml($body);     // use it to send html data
        //$email->setFrom($store['email'], $store['name']);
        $email->setFrom($this->store_mail_from,$this->store_mail_from);
        $email->addTo($to, $nameTo);
         $email->send($transport);
         // return $config;

    }
    public  function  sendResetOtp($email){
       $user=$this->getUserByEmail($email);

       $resp="";
       $msg="Email not found";
       $success=false;
       if($user){
           $otp=$this->saveOtp($user['user_id']);
           if($otp){
               $body="Your reset OTP is ".$otp;
               $resp=$this->sendMail($user['email'],$user['name'],"Reset Password",$body);
               $success=true;
               $msg="OTP Sent";
           }
       }
        echo $this->formatOutput($_GET["callback"], $resp, Null, $success, $msg);
        exit;
    }

    public  function  readNotification($user_id,$notification_ids){
        //$notification_ids=explode(',',$notification_ids);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql="update  `app_sessions` set readed=1 where user_id=$user_id AND id in(".$notification_ids.");";
        $result = $connection->query($sql);
    }
    public  function  updateActive($user_id,$status){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql="UPDATE `user_logins` set active=$status where id=$user_id";
        $result = $connection->query($sql);
        $sql = "DELETE FROM `user_checkin` WHERE user_id=$user_id";
        $result = $connection->query($sql);
    }

    public function updateCheckIn($user_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $currentDate = date('Y-m-d H:i:s'); 
        $getCheckin = "Select * FROM user_checkin WHERE user_id=".$user_id;
        $isExistCheckin = $connection->fetchAll($getCheckin);  
        if(isset($isExistCheckin[0])){
            $sql="UPDATE user_checkin set created_at='".$currentDate."',updated_at='".$currentDate."' where user_id=".$user_id;
            $result = $connection->query($sql);
        }else{
            $sql = "Insert into user_checkin ( `user_id`,`created_at`,`updated_at`) VALUES ($user_id,'".$currentDate."','".$currentDate."')";
            $result = $connection->query($sql);
        }
    }

    public function verifyOtpfromdb($user_id,$otp){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "SELECT otp from user_otp where user_id=$user_id AND otp=$otp AND is_expired=0";
        $resultparent = $connection->fetchRow($sqlparent);
        $resp=0;
        if($resultparent){

            $resp=1;
        }
        return $resp;
    }
    public  function  verifyOtp($email,$otp){
        $user=$this->getUserByEmail($email);
        $resp="";
        $msg="Invalid OTP";
        $success=false;
        if($user){
            $otp=$this->verifyOtpfromdb($user['user_id'],$otp);
            if($otp){
                $success=true;
                $msg="OTP verified";
            }
        }
        echo $this->formatOutput($_GET["callback"], $resp, Null, $success, $msg);
        exit;
    }

    public function updatePassword($userid,$password,$otp){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $password=password_hash($password, PASSWORD_DEFAULT);

        $sql="UPDATE `user_logins` set password='".$password."' where id=$userid";
        $result = $connection->query($sql);

        $sql="UPDATE `user_otp` set is_expired=1 where  user_id=$userid  AND is_expired=0 and otp=$otp" ;
        $result = $connection->query($sql);

    }

    public  function  changePassword($email,$otp,$newpassword,$confirmpassword){
        $resp="";
        $msg="Invalid Request";
        $success=false;


	    if($newpassword==$confirmpassword){

            $user=$this->getUserByEmail($email);
            if($user){
                $otp=$this->verifyOtpfromdb($user['user_id'],$otp);
                if($otp){
                    $this->updatePassword($user['user_id'],$newpassword,$otp);
                    $success=true;
                    $msg="Password Changed";
                }
            }
        }


        echo $this->formatOutput($_GET["callback"], $resp, Null, $success, $msg);
        exit;
    }
    public function getUsersList($role,$status,$active){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        if(isset($active)){
            $sqlparent = "Select id,name,email,role,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND deleted_at IS NULL AND status=$status  AND active=$active AND  role='".$role."'";
        }else{

            $sqlparent = "Select id,name,email,role,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND deleted_at IS NULL AND status=$status   AND  role='".$role."'";

        }

        $resultparent = $connection->fetchAll($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=$resultparent;

        }

        return $resp;

    }
    public function getUsersListUpdateByShopperApp(){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "Select * FROM user_logins WHERE is_updated_byshopper=1 and role='picker'";


        $resultparent = $connection->fetchAll($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=$resultparent;

        }

        return $resp;

    }
    public  function  deletePicker($user_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql="UPDATE `user_logins` set deleted_at=now() where id=$user_id;";
        $result = $connection->query($sql);
    }

    public function checkUserExist($email){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select * FROM user_logins WHERE email='".$email."'";
        $resultparent = $connection->fetchRow($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=[

                'user_id'=>$resultparent['id'],
                'name'=>$resultparent['name'],
                'role'=>$resultparent['role'],
                'email'=>$resultparent['email'],
            ];
        }

        return $resp;

    }
    public function checkUserExistNotMe($id,$email){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select * FROM user_logins WHERE id!=$id AND email='".$email."'";
        //$sqlparent = "Select * FROM user_logins WHERE email='".$email."'";
        $resultparent = $connection->fetchRow($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=[

                'user_id'=>$resultparent['id'],
                'name'=>$resultparent['name'],
                'role'=>$resultparent['role'],
                'email'=>$resultparent['email'],
            ];
        }

        return $resp;

    }

    public function addPicker($data){

        if(isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            if(!$this->checkUserExist($data['email'])){
                //$data['password']= password_hash($data['password'], PASSWORD_DEFAULT);
                $data['role']='picker';
                $insertdata=$data;

                unset($insertdata['service']);
                unset($insertdata['callback']);
                unset($insertdata['time_slot']);

                $sql=$this->createInserQuery('user_logins',$insertdata);
                $resultparent = $connection->query($sql);
                $res='';
                if($resultparent){
                    //$picker_id = $connection->lastInsertId();
                    if(isset($data['time_slot'])){
                       $slots = json_decode($data['time_slot'],true);
                        foreach($slots as $slt){
                            $this->addPickerSlots($data['crm_id'],$slt);
                        }
                    }


                    echo $this->formatOutput($data["callback"], $res, Null, true, 'You have successfully registered.'); die;
                }
            }else{
                echo $this->formatOutput($data["callback"], [], Null, false, 'User already exist');die;

            }


        }

        echo $this->formatOutput($data["callback"], [], Null, false, 'Invalid request');die;


    }
    public function updatePicker($data){

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            //$sql="select * from  `user_logins` where email='".$data['email']."'";
            //$result = $connection->query($sql);
             //if(!isset($data['id'])){
                //return $this->addPicker($data);
             //}
            if($this->checkUserExist($data['email'])){//
                if(!empty($data['password'])){
                    //$data['password']= password_hash($data['password'], PASSWORD_DEFAULT);

                }

                $insertdata=$data;

                unset($insertdata['id']);
                unset($insertdata['role']);
                unset($insertdata['service']);
                unset($insertdata['callback']);
                unset($insertdata['time_slot']);

                $sql=$this->createUpdateQuery('user_logins',$insertdata);
                $sql=$sql." where id=".$data['id'];
                $resultparent = $connection->query($sql);
                $res='';
                if($resultparent){
                    $user_id=$data['id'];
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                    $connection = $resource->getConnection();
                    $sql="delete from  `picker_slots` where picker_id=$user_id";
                    $result = $connection->query($sql);
                    if(isset($data['time_slot'])){
                        $slots = json_decode($data['time_slot'],true);
                        foreach($slots as $slt){
                            $this->addPickerSlots($user_id,$slt);
                        }

                    }

                    echo $this->formatOutput($data["callback"], $res, Null, true, 'You have successfully updated picker.'); die;
                }
            }else{
                return $this->addPicker($data);
                //echo $this->formatOutput($data["callback"], [], Null, false, 'User already exist');die;

            }




        echo $this->formatOutput($data["callback"], [], Null, false, 'Invalid request');die;


    }

    public function updatePickerDetail($pickerId,$data){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        if(isset($data['name']) || $data['name']!=''){
            echo $this->formatOutput($callback, [], Null, false, 'Shopper Name or Last name should not be updated');die;
        }

        if(isset($data['lastname']) || $data['lastname']!=''){
            echo $this->formatOutput($callback, [], Null, false, 'Shopper Name or Last name should not be updated');die;
        }

        $picker_id = $data['id'];
        $callback = $data['callback'];
        unset($data['picker_id'],$data['service'],$data['service'],$data['callback'],$data['id'],$data['name']);
        $sql=$this->createUpdateQuery('user_logins',$data);
        $sql=$sql." where id=".$picker_id;
        $resultparent = $connection->query($sql);

        $res='';
        if($resultparent){
            echo $this->formatOutput($callback, $data, Null, true, 'You have successfully updated picker.'); die;
        }else{
            echo $this->formatOutput($callback, [], Null, false, 'Details not updated');die;
        }
    }


    public function getUsersById($id,$role,$status,$active){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        if(isset($active)){
            $sqlparent = "Select id,available,name,email,role,phone,address,gender,dob,profile_desc,profile_image,youtube_url,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND id='".$id ."' AND deleted_at IS NULL AND status=$status  AND active=$active AND  role='".$role."'";
        }else{

            $sqlparent = "Select id,available,name,email,phone,address,gender,dob,profile_desc,profile_image,youtube_url,role,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND id='".$id ."'   AND deleted_at IS NULL AND status=$status   AND  role='".$role."'";

        }

        $resultparent = $connection->fetchRow($sqlparent);
        $resp=null;
        if($resultparent) {
            $resp = $resultparent;

            if($role=='picker'){

            $ordersCompPend = $this->getCompletedPending($resp['id']);
            if (count($ordersCompPend)) {
                $resp['completed_orders'] = $ordersCompPend[0];
                $resp['pending_orders'] = $ordersCompPend[1];
            } else {
                $resp['completed_orders'] = 0;
                $resp['pending_orders'] = 0;
            }

        }


        }

        return $resp;

    }
    public function updateDriver($data){

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
             
            if($this->checkUserExist($data['email'])){ 
                 

                $insertdata=$data;

                unset($insertdata['id']);
                unset($insertdata['role']);
                unset($insertdata['service']);
                unset($insertdata['callback']);
                unset($insertdata['time_slot']);

                $sql=$this->createUpdateQuery('user_logins',$insertdata);
                $sql=$sql." where id=".$data['id'];
                $resultparent = $connection->query($sql);
                $res='';
                if($resultparent){
                    $user_id=$data['id'];
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                    $connection = $resource->getConnection();
                    $sql="delete from  `picker_slots` where picker_id=$user_id";
                    $result = $connection->query($sql);
                    if(isset($data['time_slot'])){
                        $slots = json_decode($data['time_slot'],true);
                        foreach($slots as $slt){
                            $this->addPickerSlots($user_id,$slt);
                        }

                    }

                    echo $this->formatOutput($data["callback"], $res, Null, true, 'You have successfully updated picker.'); die;
                }
            }else{
                return $this->addDriver($data);
                //echo $this->formatOutput($data["callback"], [], Null, false, 'User already exist');die;

            }




        echo $this->formatOutput($data["callback"], [], Null, false, 'Invalid request');die;


    }

    public function addDriver($data){

        if(isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            if(!$this->checkUserExist($data['email'])){
                //$data['password']= password_hash($data['password'], PASSWORD_DEFAULT);
                $data['role']='driver';
                $insertdata=$data;
                //print_r($insertdata);die;
                unset($insertdata['service']);
                unset($insertdata['callback']);
                unset($insertdata['time_slot']);

                $sql=$this->createInserQuery('user_logins',$insertdata);
                $resultparent = $connection->query($sql); 
                $res='';
                if($resultparent){
                    //$picker_id = $connection->lastInsertId();
                    if(isset($data['time_slot'])){
                       $slots = json_decode($data['time_slot'],true);
                        foreach($slots as $slt){
                            $this->addPickerSlots($data['crm_id'],$slt);
                        }
                    }
                     

                    echo $this->formatOutput($data["callback"], $res, Null, true, 'You have successfully registered.'); die;
                }
            }else{
                echo $this->formatOutput($data["callback"], [], Null, false, 'User already exist');die;

            }


        }

        echo $this->formatOutput($data["callback"], [], Null, false, 'Invalid request');die;


    }

    public function getPickersList($status,$active){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        if(isset($active)){
            $sqlparent = "Select id,name,email,role,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND deleted_at IS NULL AND status=$status  AND active=$active  AND  role='picker'";
        }else{

            $sqlparent = "Select id,name,email,role,type,status,active,created_at,updated_at FROM user_logins WHERE status='1' AND deleted_at IS NULL AND status=$status AND  role='picker'";

        }

        $resultparent = $connection->fetchAll($sqlparent);
        $resp=null;
        if($resultparent){
            $resp=$resultparent;
            foreach ($resp as &$res){

                $ordersCompPend=$this->getCompletedPending($res['id']);
                if(count($ordersCompPend)){
                    $res['completed_orders']=$ordersCompPend[0];
                    $res['pending_orders']=$ordersCompPend[1];
                }else{
                    $res['completed_orders']=0;
                    $res['pending_orders']=0;
                }

            }

        }

        return $resp;

    }

    public function getPickerDetail($pickerId){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sqlparent = "Select id,name,email,role,type,status,active,created_at,updated_at,phone,address,gender,profile_image,profile_desc,youtube_url FROM user_logins WHERE id=$pickerId  AND  role='picker'";
        $resultparent = $connection->fetchAll($sqlparent);
        $picker = ['picker_detail'=>$resultparent,'picker_id'=>$pickerId];
        return $picker;
    }

    public  function getCompletedPending($picker_id){ //LOGIC CHANGE NOW GET VALUE FROM PICKER_ORDER TABLE

        $pending=$this->getOrdersOfPickerCount($picker_id,'pending');
        $completed=$this->getOrdersOfPickerCount($picker_id,'completed');

        return [
            $completed,
            $pending
        ];

    }
    public function timeslotsPicker(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $timeslotsql = "SELECT * FROM amasty_amdeliverydate_tinterval order by sorting_order asc";
        return $timeslotArray = $connection->fetchAll($timeslotsql);
    }

    public  function addPickerSlots($picker_id,$slots){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
	    if($slots){
	        //foreach ($slots as $key=> $slot){
                $sql="INSERT INTO `picker_slots` (`slot_id`, `picker_id`,`day`,`slot`) VALUES ('".$slots['slot_id']."','" .$slots['picker_id']."','".$slots['day']."','".$slots['slot']."');";

                    $resultparent = $connection->query($sql);
	            /*foreach ($slot as $slotid){
	                $slottoinsert=explode('|',$slotid);
	                $slotname=$slottoinsert[0];
                    $slot_id=$slottoinsert[1];
                    $sql="INSERT INTO `picker_slots` (`slot_id`, `picker_id`,`day`,`slot`) VALUES ($slot_id, $picker_id,'".$key."','".$slotname."');";

                    $resultparent = $connection->query($sql);
                }*/



	        //}

        }

    }

    public function getPickerSlots($picker_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $timeslotsql = "SELECT  * FROM picker_slots where picker_id=$picker_id";
        return $timeslotArray = $connection->fetchAll($timeslotsql);
    }

    public function notReviewedOrderItem($picker_id,$orderid,$type=null){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        if(empty($type)){
            if($picker_id){
                $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND is_reviewed=0 AND picker_id=$picker_id AND order_id=$orderid order by id desc";
            }else{
                $sqlparent = "Select * FROM picker_order_packing WHERE status=1 AND is_reviewed=0 AND  order_id=$orderid order by id desc";

            }
            return $resultparent = $connection->fetchAll($sqlparent);

        }else{
            if($picker_id){
                $sqlparent = "Select * FROM picker_order_packing WHERE  status=1 AND is_reviewed=0 AND picker_id=$picker_id AND order_id=$orderid AND type in (".$type.") order by id desc
                ";
            }else{
                $sqlparent = "Select * FROM picker_order_packing WHERE  status=1  AND is_reviewed=0 AND order_id=$orderid AND type in (".$type.") order by id desc
                ";
            }

            return $resultparent = $connection->fetchAll($sqlparent);
        }



    }

    public  function  reviewUpdateOrderItem($ids){
      /*  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql="UPDATE `picker_order_packing` set is_reviewed=1,review_time=NOW(),review_action='shopper_refund'  where  id in ($ids);";
        $result = $connection->query($sql);*/
    }
    public  function  inactiveOldPickerHistory($ids){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sql="UPDATE `picker_order_packing` set status=0 where  id in ($ids);";
        $result = $connection->query($sql);
    }

    public function  getOrderItembyIds($item_ids){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $query = "SELECT  * FROM sales_order_item where item_id in ($item_ids);";
            return $connection->fetchAll($query);

    }
    public function removeProductfromOrderByItemids($orderId,$item_ids,$orderitemidarray){
	   
	    $response=0;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager ->create( 'Magento\Sales\Model\Order' )->load($orderId);
        $quote = $objectManager ->create( '\Magento\Quote\Model\Quote' )->load($order->getQuoteId());
        
        //$coupon_code = $quote->getCouponCode();
        
        // $items = $quote->getAllItems();
        $items = $this->getOrderItembyIds($item_ids);
        foreach ($items as $item) {
                $deleted_qoute_item=$item['quote_item_id'];
                $quote->removeItem($deleted_qoute_item);
        }
        $quote->collectTotals();
        $quote->save();
        $items = $order->getAllItems();
        $taxAmount=$taxBaseAmount=0;
        foreach ($items as $item){
            if(in_array($item->getItemId(), $orderitemidarray)){
                $response=1;
                $item->delete();
            }else{
                $taxAmount=$taxAmount+$item->getTaxAmount();
                $taxBaseAmount=$taxBaseAmount+$item->getBaseTaxAmount();
            }
        }
		//~ if($coupon_code==null){
			//~ $order->setCouponRuleName(null);
			//~ $order->setCouponCode(null);
			//~ $order->setBaseDiscountAmount(0.0000);
			//~ $order->setDiscountAmount(0.0000);
		//~ }	
        $order->setSubtotal($quote->getSubtotal())
            ->setBaseSubtotal($quote->getBaseSubtotal())
            ->setGrandTotal($quote->getGrandTotal())
            ->setBaseGrandTotal($quote->getBaseGrandTotal())->setTaxAmount($taxAmount)->setBaseTaxAmount($taxBaseAmount);
        $quote->save();
        $order->save();
        
        return $response;
    }

    public function allRefundPackingHistory($history){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        foreach ($history as $key => $value) {

            unset($value['id']);
            if($value['type']=='found_update'){
                $value['quantity']=$value['order_quantity'];
            }
            if($value['type']=='replace'){
                $value['product_sku']=$value['old_product_sku'];
                unset($value['old_product_sku']);
            }
            $value['is_reviewed']=1;
            $value['type']='refund';
            $value['review_time']=date('Y-m-d H:i:s');
            $value['review_action']='shopper_refund';
            $value['comment']='This item was refunded by your shopper.';



            $sql=$this->createInserQuery('picker_order_packing',$value);
            $connection->query($sql);
        }

    }

    public function refundTheReviewItems($picker_id,$orderid){

        $notreviewed=$this->notReviewedOrderItem($picker_id,$orderid,"'found_update','refund','replace'");

        if($notreviewed){
            $ids='';
            $order_items_torefund=[];
            $item_ids='';
            foreach ($notreviewed as $key => $value) {
                $ids.="'".$value['id']."',";
                $item_ids.="'".$value['old_order_item_id']."',";
                $order_items_torefund[]=$value['old_order_item_id'];
            }
            if(count($order_items_torefund)){
                $ids=rtrim($ids,",");
                $item_ids=rtrim($item_ids,",");

               $resp= $this->removeProductfromOrderByItemids($orderid,$item_ids,$order_items_torefund);
               if($resp){
                   $this->inactiveOldPickerHistory($ids);
                   $this->allRefundPackingHistory($notreviewed);
               }

            }

        }
			return true;
    }

    public function updateReviewOrderItem($orderid,$order_item_id,$review_action,$itemstatus,$new_order_item_id)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $resp=0;
        $review_time = date('Y-m-d H:i:s');
        if($review_action=='customer_reject'){
            //It will push the item back to todolist
            $sql="UPDATE `picker_order_packing` set is_reviewed=1,review_time='".$review_time."',review_action='customer_reject',status=0  where  status=1 AND old_order_item_id=$order_item_id AND  order_id=$orderid  ;";
            $result = $connection->query($sql);
            $resp=1;
        }elseif ($review_action=='customer_accept'){
            if($itemstatus=='replace' && $new_order_item_id > 0){
                $sql="UPDATE `picker_order_packing` set is_reviewed=1,review_time='".$review_time."',review_action='customer_accept',new_order_item_id=$new_order_item_id where  status=1 AND old_order_item_id=$order_item_id AND  order_id=$orderid  ;";
            }else{
                $sql="UPDATE `picker_order_packing` set is_reviewed=1,review_time='".$review_time."',review_action='customer_accept' where  status=1 AND old_order_item_id=$order_item_id AND  order_id=$orderid  ;";
            }
            $result = $connection->query($sql);
            $resp=1;
        }

        return $resp;
    }

    public function getLastReviewTime($order_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $timeslotsql = "SELECT updated_at as review_time FROM `picker_order_packing` where order_id=$order_id order by updated_at desc limit 1";
        return $timeslotArray = $connection->fetchRow($timeslotsql);
    }

    public function  getOrderTips($orderid){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        //$query = "SELECT  tip_amount FROM sales_order where entity_id=$orderid;";
        $query = "SELECT  total_amount as tip_amount FROM amasty_extrafee_order where fee_id=1 AND order_id=$orderid;";
        return $connection->fetchRow($query);

    }
    
    public function  getOrderShopperFee($orderid){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();        
        $query = "SELECT  total_amount as shopper_fee FROM amasty_extrafee_order where fee_id=2 AND order_id=$orderid;";
        return $connection->fetchRow($query);

    }
    
    public function  isShopperDriverTipProvided($orderid){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();        
        $query = "SELECT tip_amount FROM user_extra_tips where order_id=$orderid;";
        $isSDTP = $connection->fetchRow($query);
        $isTip = false;
        if($isSDTP){
            $isTip = $isSDTP['tip_amount']?true:false;
        }
        return $isTip;
    }
    
    public function isShopperDriverTipTimeExpired($deliveryTime,$currentTime,$orderStatus){
        $days_between = floor(abs($currentTime - $deliveryTime) / 86400);
        
        if($days_between > 3 && ($orderStatus=="delivered" || $orderStatus=="pickedup")){
            return true;
        }
        return false;
    }

    public  function myEarningsPicker($user_id,$earning_type){
        $pending_earnings=$this->getEarnings($user_id,'pending');
        $total_earnings=$this->getEarnings($user_id,'total');

        $final_resp=[
            'pending_earnings'=>$pending_earnings,
            'total_earnings'=>$total_earnings,
        ];

        if($earning_type=='days'){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $query="SELECT  *, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$user_id  AND completed_time is not null order by completed_time desc";
            $resp=$connection->fetchAll($query);

            if($resp){

                $completed_tasks=[];

                foreach ($resp as $re){

                    $working_time=isset($completed_tasks[$re['dateoftask']])?$re['diffseconds']+$completed_tasks[$re['dateoftask']]['working_time']:$re['diffseconds'];

                    $total_earnings=isset($completed_tasks[$re['dateoftask']])?$re['total_earnings']+$completed_tasks[$re['dateoftask']]['total_earnings']:$re['total_earnings'];
                    $tip_amount=isset($completed_tasks[$re['dateoftask']])?$re['tip_amount']+$completed_tasks[$re['dateoftask']]['tip_amount']:$re['tip_amount'];
                    $total_earnings=number_format((float)$total_earnings, 2, '.', '');
                    $tip_amount=number_format((float)$tip_amount, 2, '.', '');


                    $completed_tasks[$re['dateoftask']]=['working_time'=>(string)$working_time,'date'=>$re['dateoftask'],'total_earnings'=>(string)$total_earnings,'tip_amount'=>(string)$tip_amount];
                    if(isset($completed_tasks[$re['dateoftask']]) && $re['is_paid']==1){
                        $completed_tasks[$re['dateoftask']]['is_paid']=$re['is_paid'];
                    }else{
                        $completed_tasks[$re['dateoftask']]['is_paid']=$re['is_paid'];
                    }

                }


                $final_resp['tasks_list']=array_values($completed_tasks);
            }

        }else if($earning_type=='weeks') {

        }else if($earning_type=='months') {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $query="SELECT  *,year(completed_time) as year, month(completed_time) as month, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$user_id  AND completed_time is not null order by completed_time desc";
            $resp=$connection->fetchAll($query);

            if($resp){

                $completed_tasks=[];

                foreach ($resp as $re){
                    $yearmonth=$re['year'].'-'.$re['month'];

                    $working_time=isset($completed_tasks[$yearmonth])?$re['diffseconds']+$completed_tasks[$yearmonth]['working_time']:$re['diffseconds'];

                    $total_earnings=isset($completed_tasks[$yearmonth])?$re['total_earnings']+$completed_tasks[$yearmonth]['total_earnings']:$re['total_earnings'];
                    $tip_amount=isset($completed_tasks[$yearmonth])?$re['tip_amount']+$completed_tasks[$yearmonth]['tip_amount']:$re['tip_amount'];
                    $total_earnings=number_format((float)$total_earnings, 2, '.', '');
                    $tip_amount=number_format((float)$tip_amount, 2, '.', '');

                    $completed_tasks[$yearmonth]=['working_time'=>(string)$working_time,'date'=>$yearmonth,'total_earnings'=>(string)$total_earnings,'tip_amount'=>(string)$tip_amount];

                    if(isset($completed_tasks[$yearmonth]) && $re['is_paid']==1){
                        $completed_tasks[$yearmonth]['is_paid']=$re['is_paid'];
                    }else{
                        $completed_tasks[$yearmonth]['is_paid']=$re['is_paid'];
                    }


                }

                $final_resp['tasks_list']=array_values($completed_tasks);

            }

        }

        return $final_resp;
   }

    public function getSmtpFromDb(){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT  path,value FROM core_config_data where path in ('system/gmailsmtpapp/smtphost','system/gmailsmtpapp/smtpport','system/gmailsmtpapp/username','system/gmailsmtpapp/password','system/gmailsmtpapp/auth','system/gmailsmtpapp/ssl');";
        $resp= $connection->fetchAll($query);
        $data=[];
        if($resp){

            foreach($resp as $val){
                if($val['path']=='system/gmailsmtpapp/smtphost'){
                   // $data['host']=$val['value'];
                    $data['host']='email-smtp.us-east-1.amazonaws.com';
                }else if($val['path']=='system/gmailsmtpapp/smtpport'){
                    $data['port']=587;
                }
                else if($val['path']=='system/gmailsmtpapp/username'){
                    $data['username']='AKIA2K7IAJEH6NRN6IN4';
                }
                else if($val['path']=='system/gmailsmtpapp/password'){
                    $data['password']='BIhU07gsZl8yyslEAOIkr+8N1FwBHmT+x6mUSWIRLEL2';
                }
                else if($val['path']=='system/gmailsmtpapp/auth'){
                    //$data['auth']=$val['value'];
                    $data['auth']='plain';
                }
                else if($val['path']=='system/gmailsmtpapp/ssl'){
                   $data['ssl']=$val['value'];

                }




            }
        }

        return $data;
    }
    public function getDayByDate($date){
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('l'); # l for full week day name
    }

    public function getSoltByDay($date,$slot){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
	    if(!empty($date) && !empty($slot)){
            $day=$this->getDayByDate($date);
            $logger->info("slot by testing ".$day);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $sqlparent = "SELECT * FROM `picker_slots` WHERE `slot` LIKE '".$slot."' AND day='".$day."';"; //add picker and delivery date condition here
            $logger->info("slot by testing ".$sqlparent);

            $resultparent = $connection->fetchAll($sqlparent);
            if($resultparent){
                 $pickers=[];
                foreach($resultparent as $data){
                    $pickers[]=$data['picker_id'];
                }

                return $pickers;

            }else{
                return '';
            }
        }else{
	        return '';
        }

    }
    public function getAllSoltByDay($date){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
	    if(!empty($date) && !empty($slot)){
            $day=$this->getDayByDate($date);
            $logger->info("slot by testing ".$day);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $sqlparent = "SELECT * FROM `picker_slots` WHERE  day='".$day."';"; //add picker and delivery date condition here
            $logger->info("slot by testing ".$sqlparent);

            $resultparent = $connection->fetchAll($sqlparent);
            if($resultparent){
                 $pickers=[];
                foreach($resultparent as $data){
                    $pickers[]=$data['picker_id'];
                }

                return $pickers;

            }else{
                return '';
            }
        }else{
	        return '';
        }

    }

    public function udpatePacking($orderid,$picker_id,$type='started',$qr_codes=null,$locker_no=null)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        if($type=='packed'){
            if(!empty($qr_codes)){
                $sql="UPDATE `picker_order` set qr_codes='".$qr_codes."', locker_no='".$locker_no."', is_completed=1,completed_time=NOW() where  status=1 AND picker_id=$picker_id AND  order_id=$orderid  ;";

            }else{
                $sql="UPDATE `picker_order` set is_completed=1,locker_no='".$locker_no."',completed_time=NOW() where  status=1 AND picker_id=$picker_id AND  order_id=$orderid  ;";

            }
            $result = $connection->query($sql);
        }else if($type=='started'){
            $sql="UPDATE `picker_order` set is_started=1,start_time=NOW() where  status=1 AND picker_id=$picker_id AND  order_id=$orderid  ;";
            $result = $connection->query($sql);
        }


    }  


    public function  getEarnings($picker_id,$type='pending'){ //total or pending
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        if($type=='pending'){
            $query = "SELECT sum(total_earnings) as total_earnings,sum(tip_amount) as tip_amount FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id AND is_paid=0 ;";

        }else  if($type=='paid'){
            $query = "SELECT sum(total_earnings) as total_earnings,sum(tip_amount) as tip_amount FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id AND is_paid=1 ;";

        }else{
            $query = "SELECT sum(total_earnings) as total_earnings,sum(tip_amount) as tip_amount FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id ;";

        }
        return $connection->fetchRow($query);

    }
    public function  getEarningsbyOrderId($order_id,$picker_id,$type='pending'){ //total or pending
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        if($type=='pending'){
            $query = "SELECT total_earnings,tip_amount,start_time,completed_time FROM `picker_order` where order_id=$order_id AND is_completed=1 AND  status=1 AND picker_id=$picker_id AND is_paid=0 order by id desc;";

        }else  if($type=='paid'){
            $query = "SELECT total_earnings,tip_amount,start_time,completed_time FROM `picker_order` where order_id=$order_id AND is_completed=1 AND  status=1 AND picker_id=$picker_id AND is_paid=1 order by id desc;";

        }else{
            $query = "SELECT total_earnings,tip_amount,start_time,completed_time FROM `picker_order` where order_id=$order_id AND is_completed=1 AND  status=1 AND picker_id=$picker_id order by id desc;";

        }
        return $connection->fetchRow($query);

    }


    public function  getOrdersOfPickerCount($picker_id,$type='pending'){ //total or pending
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        if($type=='pending'){
            $query = "SELECT  count(*) as totalorders FROM `picker_order` where is_completed=0 AND  status=1 AND picker_id=$picker_id ;";

        }else  if($type=='completed'){
            $query = "SELECT  count(*) as totalorders FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id;";

        }
        else{
            $query = "SELECT count(*) as totalorders FROM `picker_order` where status=1 AND picker_id=$picker_id ;";

        }
         $resp=$connection->fetchRow($query);
        if($resp){
            return $resp['totalorders'];
        }else{
            return 0;
        }

    }



    public function getTaskByDay($picker_id,$date){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        //$query="SELECT  *, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where is_completed=1 AND status=1 AND picker_id=$picker_id  AND completed_time is not null and DATE(completed_time)='".$date."'";
        $query="SELECT  *, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where status=1 AND picker_id=$picker_id  AND completed_time is not null and DATE(completed_time)='".$date."'";
        $resp=$connection->fetchAll($query);

       if($resp){
           $total_earnings=$tip_amount=0;
           $working_time=0;
           $total_completed_tasks=count($resp);
           $completed_tasks=[];

           foreach ($resp as $re){

               $total_earnings=$total_earnings+$re['total_earnings'];
               $tip_amount=$tip_amount+$re['tip_amount'];
               $working_time=$working_time+$re['diffseconds'];
               $total_earnings=number_format((float)$total_earnings, 2, '.', '');
               $tip_amount=number_format((float)$tip_amount, 2, '.', '');


               $completed_tasks[]=['order_id'=>$re['order_id'],'working_time'=>$re['diffseconds'],'completed_time'=>$re['completed_time'],'total_earnings'=>$re['total_earnings'],'tip_amount'=>$re['tip_amount']];

           }

           return [
               'total_earnings'=>(string)$total_earnings,
               'tip_amount'=>(string)$tip_amount,
               'working_time'=>(string)$working_time,
               'schedule_time'=>(string)$this->getScheduleHourOfDay($picker_id,$date),
               'total_completed_tasks'=>$total_completed_tasks,
               'completed_tasks'=>$completed_tasks,
           ];

       }

    }
    public function getTaskByMonth($picker_id,$month,$year){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query="SELECT  *, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id  AND completed_time is not null and month(completed_time)=$month AND year(completed_time)=$year";
        $resp=$connection->fetchAll($query);

        if($resp){
            $ftotal_earnings=$ftip_amount=0;
            $fworking_time=0;
            $total_completed_tasks=count($resp);
//            $completed_tasks=[];
//
//            foreach ($resp as $re){
//
//                $total_earnings=$total_earnings+$re['total_earnings'];
//                $tip_amount=$tip_amount+$re['tip_amount'];
//                $working_time=$working_time+$re['diffseconds'];
//
//                $completed_tasks[]=['working_time'=>$re['diffseconds'],'completed_time'=>$re['completed_time'],'total_earnings'=>$re['total_earnings'],'tip_amount'=>$re['tip_amount']];
//
//            }

            $completed_tasks=[];

            foreach ($resp as $re){
				
				$order_collection = $objectManager->create('Magento\Sales\Model\Order\Status\History')->getCollection()->addAttributeToFilter('parent_id', $re['order_id'])->addAttributeToFilter('status', 'canceled');
				$cnt = count($order_collection);
				if($cnt>0){
					foreach($order_collection as $oc){
						$ostatus = $oc->getComment();
					}
				}
				else{
					$ostatus='';
				} 

                $working_time=isset($completed_tasks[$re['dateoftask']])?$re['diffseconds']+$completed_tasks[$re['dateoftask']]['working_time']:$re['diffseconds'];

                $total_earnings=isset($completed_tasks[$re['dateoftask']])?$re['total_earnings']+$completed_tasks[$re['dateoftask']]['total_earnings']:$re['total_earnings'];
                $tip_amount=isset($completed_tasks[$re['dateoftask']])?$re['tip_amount']+$completed_tasks[$re['dateoftask']]['tip_amount']:$re['tip_amount'];
                $total_earnings=number_format((float)$total_earnings, 2, '.', '');
                $tip_amount=number_format((float)$tip_amount, 2, '.', '');


                $completed_tasks[$re['dateoftask']]=['working_time'=>(string)$working_time,'date'=>$re['dateoftask'],'total_earnings'=>(string)$total_earnings,'tip_amount'=>(string)$tip_amount,'cancel_reason'=>$ostatus];
                if(isset($completed_tasks[$re['dateoftask']]) && $re['is_paid']==1){
                    $completed_tasks[$re['dateoftask']]['is_paid']=$re['is_paid'];
                }else{
                    $completed_tasks[$re['dateoftask']]['is_paid']=$re['is_paid'];
                }
                $ftotal_earnings=$ftotal_earnings+$re['total_earnings'];
                $ftip_amount=$ftip_amount+$re['tip_amount'];
                $fworking_time=$fworking_time+$re['diffseconds'];
                $ftotal_earnings=number_format((float)$ftotal_earnings, 2, '.', '');
                $ftip_amount=number_format((float)$ftip_amount, 2, '.', '');


            }

            return [
                'total_earnings'=>(string)$ftotal_earnings,
                'tip_amount'=>(string)$ftip_amount,
                'working_time'=>(string)$fworking_time,
                'schedule_time'=>(string)$this->getScheduleHourOfMonth($picker_id,$month,$year),
                'total_completed_tasks'=>$total_completed_tasks,
                'tasks_list'=>array_values($completed_tasks),
            ];

        }

    }
    public function getTaskByWeek($picker_id,$datefrom,$dateto){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query="SELECT  *, DATE(completed_time) as dateoftask, (completed_time-start_time)as diffseconds FROM `picker_order` where is_completed=1 AND  status=1 AND picker_id=$picker_id  AND completed_time is not null and AND DATE(completed_time) BETWEEN '".$datefrom."' AND '".$dateto."'";
        $resp=$connection->fetchAll($query);

        if($resp){
            $total_earnings=$tip_amount=0;
            $working_time=0;
            $total_completed_tasks=count($resp);
            $completed_tasks=[];

            foreach ($resp as $re){

				$order_collection = $objectManager->create('Magento\Sales\Model\Order\Status\History')->getCollection()->addAttributeToFilter('parent_id', $re['order_id'])->addAttributeToFilter('status', 'canceled');
				$cnt = count($order_collection);
				if($cnt>0){
					foreach($order_collection as $oc){
						$ostatus = $oc->getComment();
					}
				}
				else{
					$ostatus='';
				} 

                $total_earnings=$total_earnings+$re['total_earnings'];
                $tip_amount=$tip_amount+$re['tip_amount'];
                $working_time=$working_time+$re['diffseconds'];

                $completed_tasks[]=['working_time'=>$re['diffseconds'],'completed_time'=>$re['completed_time'],'total_earnings'=>$re['total_earnings'],'tip_amount'=>$re['tip_amount'],'cancel_reason'=>$ostatus];

            }

            return [
                'total_earnings'=>(string)$total_earnings,
                'tip_amount'=>(string)$tip_amount,
                'working_time'=>(string)$working_time,
                'total_completed_tasks'=>$total_completed_tasks,
                'completed_tasks'=>$completed_tasks,
            ];

        }

    }
    public function getTaskDetailOfPicker($picker_id,$taskfilter,$filterval){
       
	    if($taskfilter=='days'){
            return $this->getTaskByDay($picker_id,$filterval);
        }
        else if($taskfilter=='weeks'){
            $filt=explode(',',$filterval);
            $datefrom=$filt[0];
            $dateto=$filt[1];

            return $this->getTaskByWeek($picker_id,$datefrom,$dateto);
        }
        else if($taskfilter=='months'){
            $filt=explode('-',$filterval);

            $month=$filt[1];
            $year=$filt[0];

            return $this->getTaskByMonth($picker_id,$month,$year);

        }

    }

    public function  getPackingbyOrderId($order_id,$picker_id){ //total or pending
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT total_earnings,tip_amount,start_time,completed_time,is_completed FROM `picker_order` where order_id=$order_id  AND  status=1 AND picker_id=$picker_id order by id desc;";
        return $connection->fetchRow($query);

    }

    public function sendSMS($data){
        //$to="[\"<mobile number>\"]";
      //  $message="Test Message";
        foreach($data['to'] as $i=>$no){
            $data['to'][$i] = "91".$no;
        }
        $authToken=$this->sms_secret_key;
        $data=json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.clickatell.com/rest/message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,           1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
            "X-Version: 1",
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer $authToken"
        ));

        return $result = curl_exec ($ch);

        $result=!empty($result)?json_decode($result):$result;

        if($result && isset($result->data->message) && count($result->data->message) ){
            return true;
        }else {
            return false;
        }


    }

    public function checkinUser($user_id){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "Insert into user_checkin ( `user_id`) VALUES ($user_id)";
       return $resultparent = $connection->query($sqlparent);

    }

    public function  isCheckin($user_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT * FROM `user_checkin` where  user_id=$user_id and DATE(created_at) = CURDATE() order by id desc;";
        $resp=$connection->fetchRow($query);
        if($resp){
            return 1;
        }else{
            return 0;
        }

    }


    public function getDeliverySlots($picker_id=null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('picker_slots');
        $shopperTable = $resource->getTableName('user_logins');

        $field[]='slot';
        $field[]='day';
        $day=date("l");
        if($picker_id){
            $sql = $connection->select()
                ->from($tableName,$field) // to select some particular fields
                // ->where('day = ?', $day)
                ->join(
                    ['sp'=>$shopperTable],
                    "picker_slots.picker_id = sp.id AND sp.status =1 AND sp.available =1 AND sp.active =1 AND picker_slots.picker_id=$picker_id"
                );
        }else{
            $sql = $connection->select()
                ->from($tableName,$field) // to select some particular fields
                // ->where('day = ?', $day)
                ->join(
                    ['sp'=>$shopperTable],
                    "picker_slots.picker_id = sp.id AND sp.status =1 AND sp.available =1 AND sp.active =1"
                );
        }


        $hours = $connection->fetchAll($sql);
        $options=[];
        if($hours){
            $hours=$this->datagroup_by('day',$hours);

            foreach ($hours as $key => $hour) {
                $day = $key;
                $slot_hours = array_unique(array_column($hour, 'slot'));
                usort($slot_hours,array($this,'my_sort'));
                $options [] =['key'=>$key,'values'=>$slot_hours];
            }

        }
        return $options;
    }


    function datagroup_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }

    public  function my_sort($a,$b)
    {
        $a=strtotime(trim(explode("-",$a)[0]));
        $b=strtotime(trim(explode("-",$b)[0]));
        if ($a==$b) return 0;
        return ($a<$b)?-1:1;
    }

    public  function  updateLocation($user_id,$lat,$lng){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql="UPDATE `user_logins` set lat='".$lat."', lng='".$lng."',created_at=now() where id=$user_id;";
        $result = $connection->query($sql);
    }

    public function insertTheFees($base_total_amount, $total_amount, $fee_label, $fee_option_label, $order_id, $fee_id, $option_id){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sqlparent = "INSERT INTO `amasty_extrafee_order` (`base_total_amount`, `total_amount`, `fee_label`, `fee_option_label`, `order_id`, `fee_id`, `option_id`) VALUES ($base_total_amount, $total_amount,'".$fee_label."', '".$fee_option_label."', $order_id, $fee_id, $option_id)";
        return $resultparent = $connection->query($sqlparent);

    }


    public function getScheduleHourOfDay($picker_id,$date){

        if(!empty($date)){
            $day=$this->getDayByDate($date);
            // print_r($day);
            // print_r($picker_id);
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $sqlparent = "SELECT * FROM `picker_slots` WHERE picker_id=$picker_id AND  day='".$day."';"; //add picker and delivery date condition here

            $resultparent = $connection->fetchAll($sqlparent);
            if($resultparent){
                $time=0;
                foreach($resultparent as $data){
                    $a=strtotime(trim(explode("-",$data['slot'])[0]));
                    $b=strtotime(trim(explode("-",$data['slot'])[1]));
                    // print_r($a);
                    // print_r($b);
                    $time=$time+ ($b-$a);
                }
 //print_R($time);
                return $time;

            }else{
                return 0;
            }
        }else{
            return 0;
        }

    }

    public function setBadgeCount($user_id,$count=''){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        if($count===''){
            $sql="UPDATE `user_logins` set badge_count = badge_count + 1 where id=$user_id;";

        }else{
            $sql="UPDATE `user_logins` set badge_count =$count where id=$user_id;";

        }
        return $resultparent = $connection->query($sql);

    }

    public function getDayCountInMonth($month,$year,$day){

        $date = "$year-$month-01";
        $end = "$year-$month-" . date('t', strtotime($date)); //get end date of month
        $days=[];
        while(strtotime($date) <= strtotime($end)) {
            $day_num = date('d', strtotime($date));
            $day_name = date('l', strtotime($date));
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
          //  echo "<td>$day_num <br/> $day_name</td>";
            $days[$day_name]=isset($days[$day_name])?$days[$day_name]+1:1;
        }
        if(isset($days[$day])){
            return $days[$day];
        }else{
           return 0;
        }
    }

    public function getScheduleHourOfMonth($picker_id,$month,$year){
	    $totalhrs=0;

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('picker_slots');
            $shopperTable = $resource->getTableName('user_logins');

            $field[]='slot';
            $field[]='day';
            if($picker_id){
                $sql = $connection->select()
                    ->from($tableName,$field) // to select some particular fields
                    // ->where('day = ?', $day)
                    ->join(
                        ['sp'=>$shopperTable],
                        "picker_slots.picker_id = sp.id AND sp.status =1 AND sp.available =1 AND sp.active =1 AND picker_slots.picker_id=$picker_id"
                    );
            }else{
                $sql = $connection->select()
                    ->from($tableName,$field) // to select some particular fields
                    // ->where('day = ?', $day)
                    ->join(
                        ['sp'=>$shopperTable],
                        "picker_slots.picker_id = sp.id AND sp.status =1 AND sp.available =1 AND sp.active =1"
                    );
            }


            $hours = $connection->fetchAll($sql);
            $options=[];
            if($hours){
                $hours=$this->datagroup_by('day',$hours);

                foreach ($hours as $key => $hour) {
                    $day = $key;
                    $slot_hours = array_unique(array_column($hour, 'slot'));

                    $time=0;
                    foreach($slot_hours as $slot){
                        $daycount=$this->getDayCountInMonth($month,$year,$day);
                        if($daycount){
                            $a=strtotime(trim(explode("-",$slot)[0]));
                            $b=strtotime(trim(explode("-",$slot)[1]));
                            $time=$time+ ($b-$a);
                        }
                    }

                    $totalhrs=$totalhrs+$time;
                }

            }

            return $totalhrs;


    }

    public function  bestSellingProducts($store=0){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT DISTINCT sales_order_item.product_id FROM  `sales_order_item`join catalog_category_product on sales_order_item.product_id=catalog_category_product.product_id   limit  100;";
        return $connection->fetchAll($query);

    }
    public function  bestSellingbrands($store=0){
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
//        $connection = $resource->getConnection();
//        $query = "SELECT  * FROM sales_order_item where item_id in ($item_ids);";
//        return $connection->fetchAll($query);

    }

    public function  previousOrderedCategories($customer_id,$store=0){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT DISTINCT catalog_category_product.category_id FROM sales_order join `sales_order_item` on sales_order.entity_id=sales_order_item.order_id join catalog_category_product on sales_order_item.product_id=catalog_category_product.product_id where sales_order.customer_id=$customer_id limit 100";
        return $connection->fetchAll($query);

    }
    public function createCardListObj($arraydata){
        $arr = $arrnam = array();
        $i=1;

        /* Title: Add total card fileld. */
        $total_card = count($arraydata->data);
        $cardsdata['tot_card'] = $total_card;
        $array_fprint = array();
        /* End  comments */

        foreach($arraydata->data as $val)
        {
            $exp_month = $exp_year = $brand = $last4 = $src = $fprint = "";
            $default = false;

            $src = $val->id;

            if(isset($val->card)){
                $exp_year = $val->card->exp_year;
                $exp_month = $val->card->exp_month;
                $brand = $val->card->brand;
                $last4 = $val->card->last4;
                $name = $val->billing_details->name;
                $fprint = $val->card->fingerprint;
            } else {
                $exp_year = $val->exp_year;
                $exp_month = $val->exp_month;
                $brand = $val->brand;
                $last4 = $val->last4;
                $name = $val->name;
                $fprint = $val->fingerprint;
            }
            $arr = array('src'=>$src, 'name'=>$name, 'exp_month'=> $exp_month, 'exp_year'=> $exp_year, 'brand'=> $brand, 'last4'=> $last4, 'default_source'=>$default);
            $arrnam = array($i=>$arr);
            $cardsdata['cards'][] = $arr;
            $array_fprint[$i] = $fprint;
            $i++;
        }
        $cardsdata['fingerprint'] = $array_fprint;
        return (object)$cardsdata;
    }

    public function getAllStores(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "select website_id,name from store_website where website_id > 0";
        
        $response = $connection->query($query);
        $stores = null;
        if($response){
            foreach($response as $key =>$store){
                $stores[$key]['id'] = $store['website_id'];
                $stores[$key]['name'] = $store['name'];
            }
        }
        return $stores;
    }

}
