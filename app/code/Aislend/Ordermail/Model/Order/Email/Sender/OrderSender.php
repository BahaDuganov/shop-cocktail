<?php
namespace Aislend\Ordermail\Model\Order\Email\Sender;
use Magento\Sales\Model\Order;

class OrderSender extends \Magento\Sales\Model\Order\Email\Sender\OrderSender {

    public function send(Order $order, $forceSyncMode = false)
    {
        /* $orderId = $order->getId();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
		$slotordersql = "SELECT COUNT(entity_id) AS slotorder FROM webkul_timeslotdelivery_order WHERE order_id=$orderId";
		$slotorder = $connection->fetchRow($slotordersql);

        if($slotorder['slotorder'] == 0){
            return false;
        } */
		
		/* $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$appState = $objectManager->get('Magento\Framework\App\State');
		$areacode = $appState->getAreaCode();
		
		if($areacode != 'frontend'){
            return false;
        } */
		
		/* if(isset($_SESSION["mob"]) && $_SESSION["mob"] == 'yes'){
			return false;
		} */
		
		$orderQuoteId = $order->getQuoteId();
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
		
		/* $appState = $objectManager->get('Magento\Framework\App\State');
		$areacode = $appState->getAreaCode(); */
		
		$orderquotesql = "SELECT order_delivery_date FROM quote WHERE entity_id=$orderQuoteId";
		$orderquote = $connection->fetchRow($orderquotesql);
		$order_delivery_date = $orderquote['order_delivery_date'];
		
		
		/* $sql = "INSERT INTO webkul_timeslotdelivery_timeslots (delivery_day, start_time, end_time, order_count, status) VALUES (".$areacode.", ".$areacode.",'".$orderQuoteId.",'".$order_delivery_date.",'".$areacode."')";
		$d = $connection->query($sql); */
		
		if(empty($order_delivery_date)){
            return false;
        }

        $order->setSendEmail(true);

        if (!$this->globalConfig->getValue('sales_email/general/async_sending') || $forceSyncMode) {
            if ($this->checkAndSend($order)) {
                $order->setEmailSent(true);
                $this->orderResource->saveAttribute($order, ['send_email', 'email_sent']);
                return true;
            }
        }

        $this->orderResource->saveAttribute($order, 'send_email');

        return false;
    }
}