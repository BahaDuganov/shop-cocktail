<?php

namespace Webkul\TimeSlotDelivery\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeManager;
    /**
     * @param \Magento\Framework\App\Helper\Context   $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }
    /**
     * get products tab Url in admin
     * @return string
     */
    public function getTimeSlotFormUrl()
    {
        return $this->_backendUrl->getUrl('timeslots/timeslots/form', ['_current' => true]);
    }

    /**
     * Retrieve information from time slot configuration.
     *
     * @param string $field
     *
     * @return void|false|string
     */
    public function getConfigData($field)
    {
        $path = 'time_slots_delivery/general/'.$field;

        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()
        );
    }
}
