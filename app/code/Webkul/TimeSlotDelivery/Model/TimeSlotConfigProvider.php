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
namespace Webkul\TimeSlotDelivery\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Webkul\TimeSlotDelivery\Model\ResourceModel\TimeSlots\CollectionFactory;

class TimeSlotConfigProvider implements ConfigProviderInterface
{
    const XPATH_ALLOWED_DAY     = 'time_slots_delivery/general/allowed_days';
    const XPATH_PROCESS_TIME    = 'time_slots_delivery/general/process_time';
    const XPATH_MAX_DAYS        = 'time_slots_delivery/general/maximum_days';
    const ENABLE                = 'time_slots_delivery/general/active';
    const XPATH_MESSAGE         = 'time_slots_delivery/general/message';
    const ENABLED               = 'time_slots_delivery/general/enable';

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var CollectionFactory
     */
    protected $_timeSlotCollection;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @param CheckoutSession                                    $checkoutSession
     * @param \Magento\Quote\Api\CartRepositoryInterface         $quoteRepository
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Magento\Customer\Model\CustomerFactory            $customerFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param \Magento\Framework\Stdlib\DateTime\DateTime        $date
     * @param CollectionFactory                                  $timeSlotCollection
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        CollectionFactory $timeSlotCollection
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->customerFactory = $customerFactory;
        $this->_objectManager = $objectManager;
        $this->_timeSlotCollection = $timeSlotCollection;
        $this->_date = $date;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getConfig()
    {
        $store = $this->getStoreId();
        $allowedDays = $this->scopeConfig->getValue(self::XPATH_ALLOWED_DAY, ScopeInterface::SCOPE_STORE, $store);
        $processTime = $this->scopeConfig->getValue(self::XPATH_PROCESS_TIME, ScopeInterface::SCOPE_STORE, $store);
        $maxDays = $this->scopeConfig->getValue(self::XPATH_MAX_DAYS, ScopeInterface::SCOPE_STORE, $store);
        $message = $this->scopeConfig->getValue(self::XPATH_MESSAGE, ScopeInterface::SCOPE_STORE, $store);
        $isEnabled = (bool)$this->scopeConfig->getValue(self::ENABLED, ScopeInterface::SCOPE_STORE, $store);

        $date = strtotime("+".$processTime." day", strtotime(date('Y-m-d')));

        $config = [
            'slotData' => [],
            'allowed_days' => explode(',', $allowedDays),
            'process_time' => $processTime,
            'start_date'   => date("Y-m-d", $date),
            'max_days'     => $maxDays,
            'slotEnabled'    => $isEnabled
        ];
        
        if (!$isEnabled) {
            return $config;
        }
        $allowedDays = explode(',', $allowedDays);

        $date = $this->_date;

        $collection = $this->_timeSlotCollection->create()
            ->addFieldToFilter('status', ['eq' => 1]);

        $createSlotData = [];
        $dateWiseSlots = [];
        if ($collection->getSize()) {
            foreach ($collection as $slot) {
                if (!in_array($slot->getDeliveryDay(), $allowedDays)) {
                    continue;
                }
                $startTime = $date->gmtDate('h:i A', $slot->getStartTime());
                $endTime = $date->gmtDate('h:i A', $slot->getEndTime());
                $unique = 1;
                for ($i=0; $i <= $maxDays; $i++) {
                    $d = strtotime("+".$i." day", strtotime(date('Y-m-d')));
                    if (ucfirst($slot->getDeliveryDay()) == date('l', $d)) {
                        $isAvailable = $this->checkAvailabilty($slot, $d);
                        $dateWiseSlots[date('Y-m-d', $d)][] = [
                            'slot'=>$startTime.'-'.$endTime,
                            'is_available'=>$isAvailable,
                            'slot_id'   => $slot->getEntityId(),
                            'slot_group' => 'slot_'.$unique
                        ];
                        $unique++;
                    }
                }
            }
        }
        $startDate = '';
        $startDate = date("Y-m-d", strtotime("+".$processTime." day", strtotime(date('Y-m-d'))));
        $config['slotData']['slots'] = $dateWiseSlots;
        $config['slotData']['start_date'] = $startDate;
        $config['slotData']['message'] = $message;
        
        return $config;
    }

    public function getStoreId()
    {
        return $this->storeManager->getStore()->getStoreId();
    }

    private function checkAvailabilty($slot, $date)
    {
        $date = $this->_date->gmtDate(date('Y-m-d', $date));
        $collection = $this->_objectManager->create(
            'Webkul\TimeSlotDelivery\Model\Order'
        )->getCollection()
        ->addFieldToFilter('slot_id', ['eq' => $slot->getEntityId()])
        ->addFieldToFilter('selected_date', ['eq' => $date]);
        if ($collection->getSize() >= $slot->getOrderCount()) {
            return 0;
        }
        return 1;
    }
}
