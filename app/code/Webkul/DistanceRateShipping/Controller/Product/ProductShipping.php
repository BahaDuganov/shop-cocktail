<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory;

class ProductShipping extends Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var CustomerUrl
     */
    protected $customerUrl;
    /**
     * @var DistanceRateShippingFactory
     */
    protected $drshipping;
    
    /**
     * @param Context                         $context
     * @param \Webkul\DistanceRateShipping\Helper\Data $helper
     * @param PageFactory                     $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param  \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        \Webkul\DistanceRateShipping\Helper\Data $helper,
        PageFactory $resultPageFactory,
        \Magento\Framework\Pricing\Helper\Data $formatePrice,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Webkul\DistanceRateShipping\Logger\Logger $logger,
        DistanceRateShippingFactory $drshipping
    ) {
        $this->formatePrice = $formatePrice;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        $this->_customerSession = $customerSession;
        $this->drshipping = $drshipping;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $configurationData = $this->helper->getConfig();
        $wholeData = $this->getRequest()->getPostValue();
        $customerAddress = str_replace(' ', '+', $wholeData['address']);
        $to['latitude'] = $wholeData['lat'];
        $to['longitude'] = $wholeData['long'];
        $from['latitude'] = $configurationData['latitude'];
        $from['longitude'] = $configurationData['longitude'];
        $radiousUnit = $configurationData['unit'];
        if ($configurationData['distanceCalculateBase'] == 'latLong') {
            $distance = $this->helper->getDistanceFromTwoPoints($from, $to, $radiousUnit);
        } else {
            $to = str_replace(' ', '+', $configurationData['location']);
            $distance = $this->helper->getDrivingDistanceCal(
                $configurationData['googleApi'],
                $customerAddress,
                $to,
                $radiousUnit
            );
            $this->logger->info($distance);
        }
        if (!is_numeric($configurationData['maximumArea']) || $distance <= $configurationData['maximumArea']) {
            $collection = $this->drshipping->create()
            ->getCollection()
            ->addFieldToFilter('distance_from', ['lteq' => $distance])
            ->addFieldToFilter('distance_to', ['gteq' => $distance])
            ->getColumnValues('rate');
            $rate = '';
            if (count($collection) > 0) {
                $rate = $collection[0];
            }
            if ($rate != null) {
                $shippingAmount = $distance *  $rate + $configurationData['handlingCharge'];
            } else {
                $shippingAmount = $distance *  $configurationData['ratePer'] + $configurationData['handlingCharge'];
            }
            if ($shippingAmount < $configurationData['minimumAmount']) {
                $shippingAmount = $configurationData['minimumAmount'];
            }
            $result['code'] = '200';
            $result['productQty'] =  $configurationData['productQty']??0;
            $result['amount'] = $this->formatePrice->currency($shippingAmount, true, false);
        } else {
            $result['code'] = '201';
            $result['message'] = (string)__('Not Shipping on that location.');
            
        }
        if (isset($result['productQty']) && $result['productQty']==1) {
            $result['showmsg'] = __('Estimated Shippping cost is %1 per product.', $result['amount']);
        } elseif (isset($result['productQty'])) {
            $result['showmsg'] = __('Estimated Shippping cost is %1', $result['amount']);
        } else {
            $result['showmsg'] = __('Shippping is not avaliable on this location.');
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}
