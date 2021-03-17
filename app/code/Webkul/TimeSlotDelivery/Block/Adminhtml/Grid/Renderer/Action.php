<?php
 
namespace Webkul\TimeSlotDelivery\Block\Adminhtml\Grid\Renderer;
 
use Magento\Framework\DataObject;
 
class Action extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

    /**
     * get category name
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $url = $this->getUrl('sales/order/view', ['order_id' => $row['order_id']]);
        return '<a href="'.$url.'" target="_blank">'.__('View order').'</a>';
        //return $storeCat->getName();
    }
}