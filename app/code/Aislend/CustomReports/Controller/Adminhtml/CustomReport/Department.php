<?php
namespace Aislend\CustomReports\Controller\Adminhtml\CustomReport;
class Department extends \Magento\Backend\App\Action
{
    
    const ADMIN_RESOURCE='Aislend_CustomReports::customreports';       
        
    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;        
        return parent::__construct($context);
    }
    
    public function execute()
    {
        //Call page factory to render layout and page content
        $resultPage = $this->resultPageFactory->create();
        //Set the menu which will be active for this page
        $resultPage->setActiveMenu('Aislend_CustomReports::customreports');

        //Set the header title of grid
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Custom Reports'));
		$currentURL = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
		$mystring = $currentURL;
		$findme   = 'filter';
		$pos = strpos($mystring, $findme);

		if ($pos === false) {
			return $resultPage;
		} else {
			$formDatas = explode("filter/",$currentURL);
			$encodedformData = substr($formDatas[1],0,-1);
			$formData = base64_decode($encodedformData);
			$formDataArray = explode('&', $formData);
			$data = array();
			foreach($formDataArray as $dataArray){
				$value = explode('=', $dataArray);
				$data[$value[0]] = $value[1];
			}
			
			$from_date = date_format(date_create(str_replace("%2F","/",$data['from'])),"Y-m-d H:i:s");
			$from_date = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($from_date)));
			$to_date = date_format(date_create(str_replace("%2F","/",$data['to'])),"Y-m-d")." 23:59:59";
			$to_date = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($to_date)));
			
			$show_order_statuses = (int)$data['show_order_statuses'];
			if($show_order_statuses == 1) {
				$order_statuses = "('" . preg_replace("/[^a-zA-Z,']/", "", str_replace("%2C","','",substr($data['order_statuses'],0,-3))) . "')";
				$status_sql = " AND orders.status IN " . $order_statuses . " ORDER BY TimeSlot, OrderIncrementId, Department";
			} else {
				$status_sql = " ORDER BY TimeSlot, OrderIncrementId, Department";
			}
			
			$sql = "SELECT 
				orders.increment_id AS OrderIncrementId, 
				orders.subtotal_incl_tax AS OrderSubTotal, 
				orders.grand_total AS OrderGrandTotal, 
				orders.created_at AS OrderDate, 
				orders.bss_customfield AS DeliverDate, 
				REPLACE(orders.shipping_description, 'Shipping Slots - ', '') AS TimeSlot, 
				item.sku AS UPC, 
				(SELECT option_value.value 
				FROM catalog_product_entity_int AS product_entity_int 
				JOIN eav_attribute_option_value AS option_value ON product_entity_int.value = option_value.option_id 
				WHERE product_entity_int.attribute_id=203 
				AND item.product_id = product_entity_int.entity_id) AS Department, 
				item.name AS ProductName, 
				item.price AS ProductUnitPrice, 
				item.qty_ordered AS Qty, 
				orders.status AS OrderStatus, 
				(SELECT gift_message.recipient 
				FROM gift_message AS gift_message 
				WHERE item.gift_message_id = gift_message.gift_message_id) AS Replacement, 
				(SELECT gift_message.message 
				FROM gift_message AS gift_message 
				WHERE item.gift_message_id = gift_message.gift_message_id) AS Message, 
				(SELECT CONCAT(address.firstname, ' ', address.lastname) 
				FROM sales_order_address AS address 
				WHERE address.parent_id = item.order_id AND address.address_type = 'billing') AS CustomerName, 
				(SELECT address.street 
				FROM sales_order_address AS address 
				WHERE address.parent_id = item.order_id AND address.address_type = 'billing') AS CustomerStreet, 
				(SELECT address.city 
				FROM sales_order_address AS address 
				WHERE address.parent_id = item.order_id AND address.address_type = 'billing') AS CustomerCity, 
				(SELECT address.region 
				FROM sales_order_address AS address 
				WHERE address.parent_id = item.order_id AND address.address_type = 'billing') AS CustomerRegion, 
				(SELECT address.postcode 
				FROM sales_order_address AS address 
				WHERE address.parent_id = item.order_id AND address.address_type = 'billing') AS CustomerPostcode 

				FROM sales_order_item AS item 
				JOIN sales_order AS orders ON item.order_id = orders.entity_id 
				WHERE item.product_type='simple' AND (orders.created_at BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
				
				
				$sql = $sql.$status_sql;
				
				/* echo $sql;
				die; */

				$filename = "sales_department.csv";
				$fp = fopen('php://output', 'w');

				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename='.$filename);
				
				$row = array("OrderIncrementId","OrderSubTotal","OrderGrandTotal","OrderDate","DeliverDate","TimeSlot","UPC","Department","ProductName","ProductUnitPrice","Qty","OrderStatus","Replacement","Message","CustomerName","CustomerStreet","CustomerCity","CustomerRegion","CustomerPostcode");
				fputcsv($fp, $row);
				
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$sqlArray = $connection->fetchAll($sql);
				
				foreach($sqlArray as $sqlData){
					$OrderIncrementId = $sqlData['OrderIncrementId'];
					$OrderSubTotal = $sqlData['OrderSubTotal'];
					$OrderGrandTotal = $sqlData['OrderGrandTotal'];
					$OrderDate = $sqlData['OrderDate'];
					//$DeliverDate = json_decode($sqlData['DeliverDate'])->shipping_date->value;
					$DeliverDate = explode(' ', $sqlData['OrderDate']);
					$DeliverDate = $DeliverDate[0];
					$TimeSlot = $sqlData['TimeSlot'];
					$UPC = $sqlData['UPC'];
					$Department = $sqlData['Department'] ? $sqlData['Department'] : 'NA';
					$ProductName = $sqlData['ProductName'];
					$ProductUnitPrice = $sqlData['ProductUnitPrice'];
					$Qty = $sqlData['Qty'];
					$OrderStatus = $sqlData['OrderStatus'];
					$Replacement = $sqlData['Replacement'] ? $sqlData['Replacement'] : 'NA';
					$Message = $sqlData['Message'] ? $sqlData['Message'] : 'NA';
					$CustomerName = $sqlData['CustomerName'];
					$CustomerStreet = $sqlData['CustomerStreet'];
					$CustomerCity = $sqlData['CustomerCity'];
					$CustomerRegion = $sqlData['CustomerRegion'];
					$CustomerPostcode = $sqlData['CustomerPostcode'];
					
					$row = array("$OrderIncrementId","$OrderSubTotal","$OrderGrandTotal","$OrderDate","$DeliverDate","$TimeSlot","$UPC","$Department","$ProductName","$ProductUnitPrice","$Qty","$OrderStatus","$Replacement","$Message","$CustomerName","$CustomerStreet","$CustomerCity","$CustomerRegion","$CustomerPostcode");
					fputcsv($fp, $row);
				}

			exit;
			
			$this->_redirect($this->_redirect->getRefererUrl());
		}
    }
}
