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

namespace Webkul\TimeSlotDelivery\Observer\Sales;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;

class ModelServiceQuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
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
     * @param SessionManager                            $coreSession
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Quote\Model\QuoteRepository      $quoteRepository
     * @param \Webkul\MpTimeDelivery\Helper\Data        $helper
     */
    public function __construct(
        SessionManager $coreSession,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Webkul\TimeSlotDelivery\Helper\Data $helper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->_coreSession = $coreSession;
        $this->_objectManager = $objectManager;
        $this->_helper = $helper;
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
        if ($this->_helper->getConfigData('enable')) {
            $order = $observer->getOrder();
            $slotData = $this->_coreSession->getSlotInfo();
            
            if (is_object($slotData)) {
                if ($slotData->slot_id != null) {
                    $order->setOrderDeliveryDate($slotData->date);
                    $order->setOrderDeliveryTime($slotData->slot_time);
                }
            }
        }
        return $this;
    }
}
