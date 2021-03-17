<?php
namespace Aislend\CustomReports\Controller\Adminhtml\CustomReport;
class Finance extends \Magento\Backend\App\Action
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
				$status_sql = " AND orders.status IN " . $order_statuses . " ORDER BY OrderIncrementId";
			} else {
				$status_sql = " ORDER BY OrderIncrementId DESC";
			}
			
			$sql = "SELECT 
				orders.increment_id AS OrderIncrementId, 
				orders.subtotal_incl_tax AS OrderSubTotal, 
				orders.base_shipping_incl_tax AS ShippingCharge, 
				orders.base_tax_amount AS Tax, 
				orders.base_discount_amount AS Discount, 
				orders.grand_total AS OrderGrandTotal, 
				orders.base_total_refunded AS Refund, 
				(SELECT txn.txn_id FROM sales_payment_transaction AS txn WHERE txn.order_id=orders.entity_id AND txn.txn_type='authorization') AS AuthorizationTransactionID, 
				(SELECT txn.txn_id FROM sales_payment_transaction AS txn WHERE txn.order_id=orders.entity_id AND txn.txn_type='capture') AS ChargeTransactionID, 
				(SELECT order_item.qty_ordered FROM sales_order_item AS order_item WHERE order_item.order_id=orders.entity_id AND order_item.sku='bottle_deposit_tax') AS BottleQty, 
				(SELECT order_item.qty_ordered * 0.05 FROM sales_order_item AS order_item WHERE order_item.order_id=orders.entity_id AND order_item.sku='bottle_deposit_tax') AS BottleCharge, 
				orders.created_at AS OrderDate 
				FROM sales_order AS orders 
				WHERE (orders.created_at BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
				
				
				$sql = $sql.$status_sql;
				
				/* echo $sql;
				die; */

				$filename = "sales_finance.csv";
				$fp = fopen('php://output', 'w');

				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename='.$filename);
				
				$row = array("OrderIncrementId","OrderSubTotal","ShippingCharge","Tax","Discount","OrderGrandTotal","Refund","AuthorizationTransactionID","ChargeTransactionID","BottleQty","BottleCharge","OrderDate","OrderTime");
				fputcsv($fp, $row);
				
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$sqlArray = $connection->fetchAll($sql);
				
				foreach($sqlArray as $sqlData){
					$OrderIncrementId = $sqlData['OrderIncrementId'];
					$OrderSubTotal = $sqlData['OrderSubTotal'];
					$ShippingCharge = $sqlData['ShippingCharge'];
					$Tax = $sqlData['Tax'];
					$Discount = ltrim($sqlData['Discount'],"-");
					$OrderGrandTotal = $sqlData['OrderGrandTotal'];
					$Refund = $sqlData['Refund'];
					$AuthorizationTransactionID = $sqlData['AuthorizationTransactionID'];
					$ChargeTransactionID = $sqlData['ChargeTransactionID'];
					$BottleQty = $sqlData['BottleQty'];
					$BottleCharge = $sqlData['BottleCharge'];
					$OrderDatewithTime = $sqlData['OrderDate'];
					$OrderDateBreaked = (explode(" ",$OrderDatewithTime));
					$OrderDate = $OrderDateBreaked[0];
					$OrderTime = $OrderDateBreaked[1];
					
					
					$row = array("$OrderIncrementId","$OrderSubTotal","$ShippingCharge","$Tax","$Discount","$OrderGrandTotal","$Refund","$AuthorizationTransactionID","$ChargeTransactionID","$BottleQty","$BottleCharge","$OrderDate","$OrderTime");
					fputcsv($fp, $row);
				}

			exit;
			
			$this->_redirect($this->_redirect->getRefererUrl());
		}
    }
}
