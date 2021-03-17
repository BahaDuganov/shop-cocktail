<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_TimeSlotDelivery
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */

namespace Webkul\TimeSlotDelivery\Observer\Checkout;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;

class OnepageControllerSuccessAction implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var SessionManager
     */
    protected $_coreSession;
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager = null;

     /**
      * @var \Webkul\MpTimeDelivery\Helper\Data
      */
    protected $_helper;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Webkul\TimeSlotDelivery\Model\OrderFactory
     */
    protected $timeSlotOrderFactory;

    /**
     * @param SessionManager                            $coreSession
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Quote\Model\QuoteRepository      $quoteRepository
     * @param \Webkul\MpTimeDelivery\Helper\Data        $helper
     */
    public function __construct(
        SessionManager $coreSession,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Webkul\TimeSlotDelivery\Model\OrderFactory $timeSlotOrderFactory,
        \Webkul\TimeSlotDelivery\Helper\Data $helper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->_coreSession = $coreSession;
        $this->_objectManager = $objectManager;
        $this->helper = $helper;
        $this->date = $date;
        $this->timeSlotOrderFactory = $timeSlotOrderFactory;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        if ($this->helper->getConfigData('enable')) {
            $order = $observer->getOrder();
            $lastOrderId = $observer->getOrder()->getId();
            $slotData = $this->_coreSession->getSlotInfo();
            if (is_object($slotData)) {
                $this->updateSellerSlot($slotData, $lastOrderId);
            }
        }
        return $this;
    }

    /**
     * Save order details with selected slot
     * @param  $value
     * @param  $lastOrderId
     */
    public function updateSellerSlot($slotData, $lastOrderId)
    {
        $slotId = $slotData->slot_id;
        $date = $slotData->date;
        $model = $this->timeSlotOrderFactory->create();
        $model->setSlotId($slotId);
        $model->setOrderId($lastOrderId);
        $model->setSelectedDate($this->date->gmtDate('Y-m-d', $date));
        $model->save();
    }
}
