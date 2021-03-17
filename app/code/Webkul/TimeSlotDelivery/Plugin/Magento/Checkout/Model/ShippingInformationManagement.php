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

namespace Webkul\TimeSlotDelivery\Plugin\Magento\Checkout\Model;

use Magento\Framework\Session\SessionManager;

class ShippingInformationManagement
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

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        if ($this->_helper->getConfigData('enable')) {
            $extAttributes = $addressInformation->getExtensionAttributes();
            $slotData = json_decode($extAttributes->getSlotData());
            
            $quote = $this->quoteRepository->getActive($cartId);
            $sellerId = 0;
            if (is_object($slotData)) {
                $quote->setOrderDeliveryDate($slotData->date);
                $quote->setOrderDeliveryTime($slotData->slot_time);
                $quote->save();
                if ($this->_coreSession->getSlotInfo()) {
                    $this->_coreSession->unsSlotInfo();
                    $this->_coreSession->setSlotInfo($slotData);
                } else {
                    $this->_coreSession->setSlotInfo($slotData);
                }
            }
        }
    }
}
