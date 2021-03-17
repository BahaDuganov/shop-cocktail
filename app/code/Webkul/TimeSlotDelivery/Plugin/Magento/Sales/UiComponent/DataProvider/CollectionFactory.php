<?php
namespace Webkul\TimeSlotDelivery\Plugin\Magento\Sales\UiComponent\DataProvider;

class CollectionFactory
{
    public function aroundGetReport(
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    )
    {
        $result = $proceed($requestName);
        
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof \Magento\Sales\Model\ResourceModel\Order\Grid\Collection) {
                
                $orderTable = $result->getTable('sales_order');
                $result->getSelect()->join(
                    ['sbao' => $orderTable],
                    'main_table.entity_id = sbao.entity_id',
                    [
                        'order_delivery_date' => 'sbao.order_delivery_date',
                        'order_delivery_time' => 'sbao.order_delivery_time'
                    ]
                );
                $result->addFilterToMap(
                    'order_delivery_date',
                    'sbao.order_delivery_date'
                );
                $result->addFilterToMap(
                    'order_delivery_time',
                    'sbao.order_delivery_time'
                );
                //add code to join table, and mapping field to select
            }
        }
        return $result;
    }
}
