<?php

namespace Mofluid\Mofluidapi2\Controller\Index;

use \Mofluid\Mofluidapi2\Helper\Data;

class Index extends \Magento\Framework\App\Action\Action {

    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;

    /** @var  \Mofluid\Mofluidapi2\Model\Catalog\Product */
    protected $Mproduct;

    /**
     * @param \Magento\Framework\App\Action\Context $context 
     * @param \Mofluid\Mofluidapi2\Model\Catalog\Product $Mproduct     
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Mofluid\Mofluidapi2\Model\Catalog\Product $Mproduct, \Mofluid\Mofluidapi2\Model\Index $Mauthentication, Data $helper
    ) {
        date_default_timezone_set('UTC');
        $this->resultPageFactory = $resultPageFactory;
        $this->mproduct = $Mproduct;
        $this->helper = $helper;
        $this->_mauthentication = $Mauthentication;
        parent::__construct($context);
    }

    public function ws_validateAuthenticate() {
        $request = $this->_objectManager->get('Magento\Framework\App\RequestInterface');
        $authappid = $request->getHeader('authappid');
        $token = $request->getHeader('token');
        $secretkey = $request->getHeader('secretkey');
        if (empty($authappid) || $authappid == null)
            return false;
        if (empty($token) || $token == null)
            return false;

        if (empty($secretkey) || $secretkey == null)
            return false;

        $mofluid_authentication = $this->_mauthentication->getCollection()->addFieldToFilter('appid', $authappid)->addFieldToFilter('token', $token)->addFieldToFilter('secretkey', $secretkey)->getData();
        if (count($mofluid_authentication) > 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }

    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute() {
        header('Content-Type: application/json');
        $request = $this->_objectManager->get('Magento\Framework\App\RequestInterface');
        $service = $request->getParam("service");

        // get authenticate token and secret key
        if ($service == 'gettoken') {
            $mofluidAuthResponse = array();
            $authappid = $request->getParam("authappid");
            if (empty($authappid) || $authappid == null) {
                $mesg = "Invalid App id";
                echo $this->formatOutput(null, null, null, false, $mesg);
                return;
                //echo json_encode(array("Invalid App id"));
                //return;
            }
            $mofluid_authentication = $this->_mauthentication->getCollection()->addFieldToFilter('appid', $authappid)->getData();
            if (count($mofluid_authentication) > 0) {
                $data = ['appid' => $mofluid_authentication[0]['appid'], 'token' => $mofluid_authentication[0]['token'], 'secretkey' => $mofluid_authentication[0]['secretkey']];
                //echo json_encode($data);
                //return;
                $mesg = "success";
                echo $this->formatOutput(null, $data, null, true, $mesg);
                return;
            } else {
                $token = openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                $secretKey = md5(uniqid($authappid, TRUE));
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $model = $objectManager->create('Mofluid\Mofluidapi2\Model\Index');
                $data = ['appid' => $authappid, 'token' => $token, 'secretkey' => $secretKey];
                $model->setData($data);
                $model->save();
                //echo json_encode($data);
                //return;
                $mesg = "success";
                echo $this->formatOutput(null, $data, null, true, $mesg);
                return;
            }
        }

        // get authenticate token and secret key end here

        if (!$this->ws_validateAuthenticate()) {
            //echo json_encode(array('unauthorized'));
            $mesg = "unauthorized";
            echo $this->formatOutput(null, null, null, false, $mesg);
            return;
        }

        $store = $request->getParam("store");
        if ($store == null || $store == '') {
            $store = 1;
        }

        $categoryid = $request->getParam("categoryid");
        $filterdataencode = $request->getParam("filterdata");
        $filterdata = base64_decode($filterdataencode);
        $pageId = $request->getParam("pageId");
        $service = $request->getParam("service");
        //$categoryid = $request->getParam("categoryid");
        $firstname = $request->getParam("firstname");
        $lastname = $request->getParam("lastname");
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        $oldpassword = $request->getParam("oldpassword");
        $newpassword = $request->getParam("newpassword");
        $productid = $request->getParam("productid");
        $custid = $request->getParam("customerid");
        $billAdd = $request->getParam("billaddress");
        $shippAdd = $request->getParam("shippaddress");
        $pmethod = $request->getParam("paymentmethod");
        $smethod = $request->getParam("shipmethod");
        $transid = $request->getParam("transactionid");
        $product = $request->getParam("product");
        $shippCharge = $request->getParam("shippcharge");
        $search_data = $request->getParam("search_data");
        $username = $request->getParam("username");
        // Get Requested Data for Push Notification Request
        $deviceid = $request->getParam("deviceid");
        $pushtoken = $request->getParam("pushtoken");
        $platform = $request->getParam("platform");
        $appname = $request->getParam("appname");
        $description = $request->getParam("description");
        $profile = $request->getParam("profile");
        $paymentgateway = $request->getParam("paymentgateway");
        $couponCode = $request->getParam("couponCode");
        $orderid = $request->getParam("orderid");
        $pid = $request->getParam("pid");
        $products = $request->getParam("products");
        $address = $request->getParam("address");
        $country = $request->getParam("country");
        $grand_amount = $request->getParam("grandamount");
        $order_sub_amount = $request->getParam("subtotal_amount");
        $discount_amount = $request->getParam("discountamount");
        $mofluidpayaction = $request->getParam("mofluidpayaction");
        $postdata = $_POST;
        $mofluid_payment_mode = $request->getParam("mofluid_payment_mode");
        $product_id = $request->getParam("product_id");
        $gift_message = $request->getParam("message");
        $mofluid_paymentdata = $request->getParam("mofluid_paymentdata");
        $mofluid_ebs_pgdata = $request->getParam("DR");
        $curr_page = $request->getParam("currentpage");
        $page_size = $request->getParam("pagesize");
        $sortType = $request->getParam("sorttype");
        $sortOrder = $request->getParam("sortorder");
        $saveaction = $request->getParam("saveaction");
        $mofluid_orderid_unsecure = $request->getParam("mofluid_order_id");
        $currency = $request->getParam("currency");
        $price = $request->getParam("price");
        $from = $request->getParam("from");
        $to = $request->getParam("to");
        $is_create_quote = $request->getParam("is_create_quote");
        $find_shipping = $request->getParam("find_shipping");
        $messages = $request->getParam("messages");
        $theme = $request->getParam("theme");
        $timeslot = $request->getParam("timeslot");
        $billshipflag = $request->getParam("shipbillchoice");
        $customer_id = $request->getParam("customer_id");
        $apiKey = $request->getParam("apiKey");
        $token_id = $request->getParam("token_id");
        $card_id = $request->getParam("card_id");
        $mofluid_Custid = $request->getParam("mofluid_Custid");
        $discription = $request->getParam("discription");
        $name1 = $request->getParam("name");
        $shipping_id = $request->getParam("shipping_id");
        $qty = $request->getParam("qty");
        $cityid = $request->getParam("cityid");
        $inv_store = $request->getParam("inv_store");
        $instock = $request->getParam("instock");
        $currency = $request->getParam("currency");
        $payment_data = $request->getParam("payment_data");
        $q = $request->getParam("q");
        $search_type = $request->getParam("search_type");
        $cartproducts = $request->getParam("cartproducts");
        $cartaddress = $request->getParam("cartaddress");
        $city_id = $request->getParam("city_id");
        $payment_method = $request->getParam("payment_method");
        $shipping_date = $request->getParam("shipping_date");
        $shipping_carrier_code = $request->getParam("shipping_carrier_code");
        $shipping_method_code = $request->getParam("shipping_method_code");
        $cartsession_id = $request->getParam("cartsession_id");
        $cartregion_id = $request->getParam("cartregion_id");
        $order_payload = $request->getParam("orderpayload");
        $store_credit = $request->getParam("store_credit");
        $couponCode = $request->getParam("coupon_code");
        $cartId = $request->getParam("quote_id");
        $isSubscribe = $request->getParam("issubscribe");
        $shippingDate = $request->getParam("shipping_date");
        $comment = $request->getParam("comment");
		$delivery_type = $request->getParam("delivery_type");
        $name = base64_decode($name1);
        $zipcode = $request->getParam("zipcode");
        $stripe_token = $request->getParam("stripe_token");
		$slot_total = $request->getParam("slot_total");
		$isloggedIn = $request->getParam("is_logged_in");
		
        //$currency='USD';
        $res = null;
        $mesg = "success";
        try {
            if ($service == "sidecategory") {
                $res = $this->helper->ws_sidecategory($store, $service);
                //echo $_GET["callback"].json_encode($res);
            }elseif ($service == "getuseraddress") {
		$customerID = $request->getParam("customerID");
		$res = $this->helper->getCustomerAddressByID($customerID);
            } elseif ($service == "setnewaddress") {
		$customerID = $request->getParam("customerID");
		$new_address = $request->getParam("newaddress"); 
                $res = $this->helper->setNewAddressByCustomerID($customerID,$new_address);
            } elseif ($service == "shippingslot") {
                $res = $this->helper->getShippingSlot($zipcode,$slot_total);
            }elseif ($service == "preparecart") {
                $res = $this->helper->ws_PrepareCart($cartproducts, $cartaddress, $city_id, $inv_store, $payment_method, $shipping_date, $shipping_carrier_code, $shipping_method_code, $cartregion_id, $customer_id, $email, $cartsession_id, $store_credit);
            } elseif ($service == "createorderfromcart") {
                $res = $this->helper->ws_createOrderFromCart($order_payload, $cartregion_id, $store, $currency, $customer_id, $cartsession_id, $comment, $shippingDate, $isSubscribe, $delivery_type, $stripe_token);
                //$region_id, $sessionId,$couponCode
            } elseif ($service == "region") {
                $res = $this->helper->getallRegion($store, $service, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "applycoupon") {
                $res = $this->helper->applyCouponOnCart($cartregion_id, $cartsession_id, $couponCode, $customer_id, $cartId);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "removecoupon") {
                $res = $this->helper->removeCouponFromCart($cartregion_id, $cartsession_id, $customer_id, $cartId);
            } elseif ($service == "cmspage") {
                $res = $this->helper->getallcmspage($store, $service, $currency, $q);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "initial") {
                $res = $this->helper->fetchInitialData($store, $service, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "initialnew") {
                $res = $this->helper->fetchNewInitialData($store, $service, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "getallCMSPages") {
                $res = $this->helper->getallCMSPages($store, $pageId);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "category") {
                $res = $this->helper->ws_category($store, $service);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "subcategory") {
                $res = $this->helper->ws_subcategory($store, $service, $categoryid);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "products") {
                $res = $this->helper->ws_products($store, $service, $categoryid, $curr_page, $page_size, $sortType, $sortOrder, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "newsearch") {
                if ($search_type == 'category') {
                    $res = $this->helper->ws_newcategroysearch($store, $service, $q, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata, $instock);
                }
                if ($search_type == 'freetxt') {
                    $res = $this->helper->ws_newsearchQuick($store, $service, $q, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata, $search_type, $instock);
                }
            } elseif ($service == "sudsearch") {
                
                if ($search_type == 'category') {                   
                    $res = $this->helper->ws_sud_newcategroysearch($store, $service, $q, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata, $instock);
                }
                if ($search_type == 'freetxt') {
                    $res = $this->helper->ws_newsearchQuick($store, $service, $q, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata, $search_type, $instock);
                }
            }elseif ($service == 'autosuggest') {
                $res = $this->helper->getAutoSuggest($q);
            } elseif ($service == "productdetaildescription") {
                $res = $this->helper->ws_productdetailDescription($store, $service, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "crossupsellrelated") {
                $res = $this->helper->getCrossUpSellRelatedProductsByProductId($store, $service, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "productdetaildescriptionrecipe") {
                $res = $this->helper->ws_productdetailDescriptionRecipe($store, $service, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "get_configurable_product_details_description") {
                $res = $this->helper->get_configurable_products_description($productid, $currency, $store);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "getFeaturedProducts") {
                $res = $this->helper->ws_getFeaturedProducts($currency, $service, $store);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "get_configurable_product_details_image") {
                $res = $this->helper->get_configurable_products_image($productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "getNewProducts") {
                $res = $this->helper->ws_getNewProducts($currency, $service, $store, $curr_page, $page_size, $sortType, $sortOrder);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "convert_currency") {
                $res = $this->helper->convert_currency($price, $from, $to);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "rootcategory") {
                $res = $this->helper->rootCategoryData($store, $service);
                //echo $_GET["callback"].json_encode($res); 
            } elseif ($service == "createuser") {
                $res = $this->helper->ws_createuser($store, $service, $firstname, $lastname, $email, $password);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "customerinfo") {
                $res = $this->helper->ws_getCustomerInfo($custid, $store);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "myprofile") {
                $res = $this->helper->ws_myProfile($custid, $store);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "mofluidUpdateProfile") {
                $res = $this->helper->mofluidUpdateProfile($store, $service, $custid, $billAdd, $shippAdd, $profile, $billshipflag);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "changeprofilepassword") {
                $res = $this->helper->ws_changeProfilePassword($custid, $username, $oldpassword, $newpassword, $store);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "mofluidappcountry") {
                $res = $this->helper->ws_mofluidappcountry($store);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "mofluidappstates") {
                $res = $this->helper->ws_mofluidappstates($store, $country);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "productdetail") {
                $res = $this->helper->ws_productdetail($store, $service, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "register_push") {
                $res = $this->helper->mofluid_register_push($store, $deviceid, $pushtoken, $platform, $appname, $description);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "getallCMSPages") {
                $res = $this->helper->getallCMSPages($store, $pageId);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "productinfo") {
                //try {
                $res = $this->helper->ws_productinfo($store, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
                //}
                //catch (Exception $ex) {
                //echo 'Error' . $ex->getMessage();
                //}
            } elseif ($service == "productdetailimage") {
                $res = $this->helper->ws_productdetailImage($store, $service, $productid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "storedetails") {
                $res = $this->helper->ws_storedetails($store, $service, $theme, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "verifylogin") {
                $res = $this->helper->ws_verifyLogin($store, $service, $username, $password);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "loginwithsocial") {
                $res = $this->helper->ws_loginwithsocial($store, $username, $firstname, $lastname);
                //echo $_GET["callback"]   . json_encode($res) ;
            } elseif ($service == "forgotPassword") {
                $res = $this->helper->ws_forgotPassword($email);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "search") {
                $res = $this->helper->ws_search($store, $service, $search_data, $curr_page, $page_size, $sortType, $sortOrder, $currency);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "getpaymentmethod") {
                $res = $this->helper->ws_getpaymentmethod();
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "productQuantity") {
                $res = $this->helper->ws_productQuantity($product);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "checkout") {
                $res = $this->helper->ws_checkout($store, $service, $theme, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "myorders") {
                $res = null; //$res = $this->helper->ws_myOrder($custid, $curr_page, $page_size, $store, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "listorders") {
                $res = $this->helper->ws_myOrderListByCustomerId($custid, $curr_page, $page_size, $store, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "orderdetails") {
                $res = $this->helper->ws_getOrderAndGetDetailsByOrderId($orderid, $curr_page, $page_size, $store, $currency);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "validatecartitem") {
                $res = $this->helper->validateInventory($products, $store, $inv_store, $cityid);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "preparequote") {
                $res = $this->helper->prepareQuote($custid, $products, $store, $inv_store, $cityid, $address, $smethod, $couponCode, $currency, $is_create_quote, $find_shipping, $theme);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "placeorder") {
                $res = $this->helper->placeorder($custid, $products, $store, $inv_store, $cityid, $address, $couponCode, $is_create_quote, $transid, $pmethod, $smethod, $currency, $messages, $theme, $shipping_id);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "validate_currency") {
                $res = $this->helper->ws_validatecurrency($store, $service, $currency, $paymentgateway);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "setaddress") {
                $res = $this->helper->ws_setaddress($store, $service, $custid, $address, $email, $saveaction);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "mofluid_reorder") {
                $res = $this->helper->ws_mofluid_reorder($store, $service, $pid, $orderid, $currency);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "filter") {
                $res = $this->helper->ws_filter($store, $service, $categoryid, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata);
                //echo $_GET["callback"].json_encode($res);
            } elseif ($service == "getcategoryfilter") {
                $res = $this->helper->ws_getcategoryfilter($store, $categoryid);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "getProductStock1") {
                $res = $this->helper->getProductStock1($store, $service, $product_id);
                //echo $_GET["callback"].json_encode($res);
            } else if ($service == "retrieveCustomerStripe") {
                $res = $this->helper->ws_retrieveCustomerStripe($customer_id);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "createCardStripe") {
                $res = $this->helper->ws_createCardStripe($customer_id, $token_id, $card_id);
                // echo $_GET["callback"] . json_encode($res);
            } else if ($service == "customerUpdateStripe") {
                $res = $this->helper->ws_customerUpdateStripe($customer_id, $discription);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "stripecustomercreate") {  // die('hii');
                $res = $this->helper->stripecustomercreate($mofluid_Custid, $token_id, $email, $name);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "chargeStripe") {
                $res = $this->helper->chargeStripe($customer_id, $price, $currency, $card_id);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "stripeData") {
                $res = $this->helper->stripeData();
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "addCartItem") {
                $res = $this->helper->ws_addCartItem($store, $service, $custid, $product_id, $qty);
                //echo $_GET["callback"] . json_encode($res);
            } else if ($service == "authorizecheckout") {
                $res = $this->helper->authorizecheckout($payment_data);
                ///echo $_GET["callback"].json_encode($res);
            } else if ($service == "customeraddress") {
                $res = $this->helper->customerAddress($customer_id);
                ///echo $_GET["callback"].json_encode($res);
            } else if ($service == "recipeingredients") {
				$res = $this->helper->ws_recipeingredients($store, $service, $q, $curr_page, $page_size, $sortType, $sortOrder, $currency, $filterdata);
                ///echo $_GET["callback"].json_encode($res);
            } else if($service == 'notifyme'){
				$res = $this->helper->ws_notifyMe($isloggedIn, $custid, $product_id, $email);
            } else {
                $mesg = 'Error :- 404';
                $res = $this->ws_service404($service);
                echo $this->formatOutput($_GET["callback"], $res, Null, false, $mesg);
                return;
            }

            echo $this->formatOutput($_GET["callback"], $res, Null, true, $mesg);
            exit;
        } catch (Exception $ex) {
            //echo 'Error' . $ex->getMessage();
            $mesg = 'Error' . $ex->getMessage();
            echo $this->formatOutput($_GET["callback"], $data, Null, false, $mesg);
            return;
        }
    }

    private function formatOutput($callBack, $data, $errorCode = Null, $success = true, $mesg = null) {
        $array = array('metadata' =>
            array('success' => $success, 'errorCode' => $errorCode, 'message' => $mesg)
            , 'payload' =>
            array('data' => $data)
        );
        return $callBack . json_encode($array);
    }

    /* =====================      Handle When Store Not Found      ========================= */

    public function ws_store404($store) {
        return 'Store 404 Error :  Store ' . $store . ' is not found on your host ';
    }

    /* =====================      Handle When Service Not Found      ========================= */

    public function ws_service404($service) {
        if ($service == "" || $service == null)
            return 'Service 404 Error :  No Such Web Service found under Mofluid APIs at your domain';
        else
            return 'Service 404 Error : ' . $service . ' Web Service is not found under Mofluid APIs at your domain';
    }

}
