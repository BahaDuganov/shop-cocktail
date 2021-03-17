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
 
/* error_reporting(E_ALL);
ini_set("display_errors", 1); */


echo "\n\n\n\n".date('Y-m-d')."\n";

$from_date = date('Y-m-d 00:00:00',strtotime(date('Y-m-d')));
//$from_date = date('Y-m-d 00:00:00',strtotime('-24 hour',strtotime($from_date)));
//echo $from_date;

//$from_date = '2018-08-11 00:00:00';

$to_date = date('Y-m-d 23:59:59',strtotime(date('Y-m-d')));
//$to_date = date('Y-m-d 23:59:59',strtotime('-24 hour',strtotime($to_date)));

//$to_date = '2018-08-11 23:59:59';


/* echo $to_date;
die; */
echo $sql = "SELECT 
		orders.increment_id AS OrderIncrementId, 
		orders.customer_firstname, 
		orders.customer_lastname, 
		orders.customer_email, 
		orders.subtotal_incl_tax AS OrderSubTotal, 
		orders.base_shipping_incl_tax AS ShippingCharge, 
		orders.base_tax_amount AS Tax, 
		orders.base_discount_amount AS Discount, 
		orders.grand_total AS OrderGrandTotal, 
		orders.base_total_refunded AS Refund, 
		(SELECT order_item.qty_ordered FROM sales_order_item AS order_item WHERE order_item.order_id=orders.entity_id AND order_item.sku='bottle_deposit_tax') AS BottleQty, 
		(SELECT order_item.qty_ordered * 0.05 FROM sales_order_item AS order_item WHERE order_item.order_id=orders.entity_id AND order_item.sku='bottle_deposit_tax') AS BottleCharge, 
		orders.created_at AS OrderDate 
		FROM sales_order AS orders 
		WHERE (orders.created_at BETWEEN '" . $from_date . "' AND '" . $to_date . "') AND orders.customer_email NOT IN('jawed@bravvura.in', 'pdutta@bravvura.com', 'gksharma@bravvura.in', 'testingnorwalk@gmail.com', 'rraman@bravvura.in') ORDER BY OrderIncrementId DESC";
		
$resource = $obj->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();
$sqlArray = $connection->fetchAll($sql);
/* print_r($sqlArray);
die; */
echo  "\nDataset count : ".count($sqlArray)."\n";
if(count($sqlArray) > 0){
	
	$fp = fopen("/chroot/home/citymark/citymarketnorwalk.com/html/var/daily_sales_report_".date('Y-m-d-H:i:s').".csv","w");

	$row = array("Order No","Customer Name","Customer Email","Order Sub Total","Shipping Charge","Tax","Discount","Order Grand Total","Refund","Bottle Qty","Bottle Charge","Order Date","Order Time");
	fputcsv($fp, $row);

	foreach($sqlArray as $sqlData){
		$OrderIncrementId = "#".$sqlData['OrderIncrementId'];
		$CustomerName = $sqlData['customer_firstname']." ".$sqlData['customer_lastname'];
		$CustomerEmail = $sqlData['customer_email'];
		$OrderSubTotal = $sqlData['OrderSubTotal'];
		$ShippingCharge = $sqlData['ShippingCharge'];
		$Tax = $sqlData['Tax'];
		$Discount = ltrim($sqlData['Discount'],"-");
		$OrderGrandTotal = $sqlData['OrderGrandTotal'];
		$Refund = $sqlData['Refund'];
		$BottleQty = $sqlData['BottleQty'];
		$BottleCharge = $sqlData['BottleCharge'];
		$OrderDatewithTime = $sqlData['OrderDate'];
		$OrderDateBreaked = (explode(" ",$OrderDatewithTime));
		$OrderDate = $OrderDateBreaked[0];
		$OrderTime = $OrderDateBreaked[1];
		
		
		$row = array("$OrderIncrementId","$CustomerName","$CustomerEmail","$OrderSubTotal","$ShippingCharge","$Tax","$Discount","$OrderGrandTotal","$Refund","$BottleQty","$BottleCharge","$OrderDate","$OrderTime");
		fputcsv($fp, $row);
	}
	fclose($fp);
	$my_message = "Dear Stake Holders,\n\nPlease find attached herewith daily sales report of City Market.\n\n\nThanks\nCity Market Support Team";
}else{
	$my_message = "Dear Stake Holders,\n\nNo order was placed today.\n\n\nThanks\nCity Market Support Team";
}

$my_file = "daily_sales_report_".date('Y-m-d-H:i:s').".csv";
$my_path = "/chroot/home/citymark/citymarketnorwalk.com/html/var/";
$my_name = "Citymarket Norwalk";
$my_mail = "info@citymarketnorwalk.com";
$my_replyto = "info@citymarketnorwalk.com";
$my_subject = "Daily Sales Report";

//mail_attachment($my_file, $my_path, "puneet@bravvura.com,tariq@aislend.com,ari@aislend.com,karim@bravvura.com,pdutta@bravvura.com,adit@bravvura.com,irovira@bravvura.com,jawed@bravvura.in", $my_mail, $my_name, $my_replyto, $my_subject, $my_message, count($sqlArray));
mail_attachment($my_file, $my_path, "pdutta@bravvura.com,adit@bravvura.com,jawed@bravvura.in,gksharma@bravvura.in", $my_mail, $my_name, $my_replyto, $my_subject, $my_message, count($sqlArray));
//mail_attachment($my_file, $my_path, "jawed@bravvura.in", $my_mail, $my_name, $my_replyto, $my_subject, $my_message, count($sqlArray));

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message, $emailCount) {
	if($emailCount > 0){
		

		$file = $path.$filename;
		$content = file_get_contents( $file);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);

	// header
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

	// message & attachment
		$nmessage = "--".$uid."\r\n";
		$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$nmessage .= $message."\r\n\r\n";
		$nmessage .= "--".$uid."\r\n";
		$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
		$nmessage .= "Content-Transfer-Encoding: base64\r\n";
		$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$nmessage .= $content."\r\n\r\n";
		$nmessage .= "--".$uid."--";

		

	} else {
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		
		$nmessage = $message."\r\n\r\n";
		
	}
	if (mail($mailto, $subject, $nmessage, $header)) {
		echo "mail_success";
	} else {
		echo "mail_error";
	}
	
    
}
?> 