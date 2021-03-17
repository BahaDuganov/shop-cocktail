<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_DistanceRateShipping
 * @author Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Model;

use Magento\Shipping\Model\Carrier\AbstractCarrier as CoreAbstractCarrier;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Item\OptionFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;
use Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory;

class Carrier extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{

    /**
     * Code of the carrier.
     *
     * @var string
     */
    const CODE = 'distancerateshipping';
    /**
     * Code of the carrier.
     *
     * @var string
     */
    protected $_code = self::CODE;
    /**
     * Rate request data.
     *
     * @var \Magento\Quote\Model\Quote\Address\RateRequest|null
     */
    protected $_request = null;

    /**
     * Rate result data.
     *
     * @var Result|null
     */
    protected $_result = null;
    /**
     * @var SessionManager
     */
    protected $_coreSession;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * Raw rate request data
     *
     * @var \Magento\Framework\DataObject|null
     */
    protected $_rawRequest = null;
     /**
      * @var \Magento\Shipping\Model\Rate\ResultFactory
      */
    protected $_rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;
    /**
     * @var DistanceRateShippingFactory
     */
    protected $drshipping;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface          $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory  $rateErrorFactory
     * @param \Psr\Log\LoggerInterface                                    $logger
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param \Magento\Framework\ObjectManagerInterface                   $objectManager
     * @param SessionManager                                              $coreSession
     * @param \Magento\Checkout\Model\Session                             $checkoutSession
     * @param \Magento\Customer\Model\Session                             $customerSession
     * @param \Webkul\Mpfreeshipping\Helper\Data                          $currentHelper
     * @param array                                                       $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        SessionManager $coreSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\RequestInterface $requestInterface,
        PriceCurrencyInterface $priceCurrency,
        OptionFactory $quoteOptionFactory,
        CustomerFactory $customerFactory,
        \Magento\Quote\Model\Quote\Item $quoteItemModel,
        AddressFactory $addressFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Serialize\SerializerInterface $serializerInterface,
        \Webkul\DistanceRateShipping\Helper\Data $helper,
        \Magento\Directory\Model\Country $country,
        \Magento\Framework\HTTP\Client\Curl $curl,
        DistanceRateShippingFactory $drshipping,
        $data = []
    ) {
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_rateResultFactory = $rateResultFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->_rateErrorFactory = $rateErrorFactory;
        $this->curl = $curl;
        $this->country = $country;
        $this->helper = $helper;
        $this->logger = $logger;
        $this->_quoteItemModel = $quoteItemModel;
        $this->_regionFactory = $regionFactory;
        $this->drshipping = $drshipping;
    }

    /**
     * Collect and get rates.
     *
     * @param RateRequest $request
     *
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Error|bool|Result
     */
    public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        $this->setRequest($request);
        $shippingpricedetail = $this->getShippingPricedetail($request);
        $result = $this->_rateResultFactory->create();
        if (isset($shippingpricedetail['error']) && $shippingpricedetail['error'] == true) {
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier('distancerateshipping');
            $error->setCarrierTitle($this->getConfigData('title'));
            if (!empty($this->getConfigData('specificerrmsg'))) {
                $errorMsg = $this->getConfigData('specificerrmsg');
            } else {
                $errorMsg = __('Something went wrong.');
            }
            $error->setErrorMessage($errorMsg);
            $result->append($error);
            return $result;
        }
        $rate = $this->_rateMethodFactory->create();
        $rate->setCarrier('distancerateshipping');
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('distancerateshipping');
        $rate->setMethodTitle($this->getConfigData('methodName'));
        $rate->setCost($shippingpricedetail['handlingfee']);
        $rate->setPrice($shippingpricedetail['handlingfee']);
        $result->append($rate);
        return $result;
    }

    /**
     * Calculate the rate according to free shipping.
     * @param \Magento\Framework\DataObject    $request
     * @return Result
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getShippingPricedetail($request)
    {
        $submethod = [];
        try {
            $r = $request;
            $submethod = [];
            $shippinginfo = [];
            $minimumOrderAmount = 0;
            $shipCustomer = [];
            $configData = $this->helper->getConfig();
            $shipCustomer['country'] = $this->country->load($r->getDestCountryId())->getName();
            if ($r->getDestRegionId()) {
                $shipCustomer['region'] = $this->_regionFactory->create()->load($r->getDestRegionId())->getName();
            } elseif ($r->getDestRegionCode()) {
                $shipCustomer['region'] = $r->getDestRegionCode();
            }
            if (empty($shipCustomer['dest_city'])) {
                $shipCustomer['city'] = $r->getDestCity();
            }
            $shipCustomer['postcode'] = $r->getDestPostcode();
            $address = implode(" ", $shipCustomer);
            $address = str_replace(' ', '+', $address);
            $key = $configData['googleApi'];
            $urlData  = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$key.'&address='.
            $address.'&sensor=false';
            if (empty($shipCustomer['dest_street'])) {
                $shipCustomer['street'] = $r->getDestStreet();
            }
            $address = implode(" ", $shipCustomer);
            $address = str_replace(' ', '+', $address);
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$key.'&address='.$address.'&sensor=false';
           
            //Get latitude and longitute from json data
            $totalCartQty = 0;
            foreach ($r->getAllItems() as $shipdetail) {
                $totalCartQty = $totalCartQty + $shipdetail['qty'];
            }
                $configurationData = $this->helper->getConfig();
                $to['latitude'] = $configurationData['latitude'];
                $to['longitude'] = $configurationData['longitude'];
                $radiousUnit = $configurationData['unit'];
            if ($configurationData['distanceCalculateBase'] == 'latLong') {
                $this->curl->get($url);
                $output = json_decode($this->curl->getBody(), true);
                if ($output['results']) {
                    $from['latitude'] = $output['results'][0]['geometry']['location']['lat'];
                    $from['longitude'] = $output['results'][0]['geometry']['location']['lng'];
                } else {
                    $this->curl->get($urlData);
                    $output = json_decode($this->curl->getBody(), true);
                    $from['latitude'] = $output['results'][0]['geometry']['location']['lat'];
                    $from['longitude'] = $output['results'][0]['geometry']['location']['lng'];
                }
            }
            if ($configurationData['distanceCalculateBase'] == 'latLong') {
                $distance = $this->helper->getDistanceFromTwoPoints($from, $to, $radiousUnit);
            } else {
                $adminAddress = str_replace(' ', '+', $configurationData['location']);
                $distance = $this->helper->getDrivingDistanceCal($key, $address, $adminAddress, $radiousUnit);
            }
            if (!is_numeric($configurationData['maximumArea']) || $distance <= $configurationData['maximumArea']) {
                $shipAmt = 0;
                $collection = $this->drshipping->create()
                                                ->getCollection()
                                                ->addFieldToFilter('distance_from', ['lteq' => $distance])
                                                ->addFieldToFilter('distance_to', ['gteq' => $distance])
                                                ->getColumnValues('rate');
                $rate = 0;
                if (count($collection) > 0) {
                    $rate = $collection[0];
                }
                // if ($rate > 0) {
                //     $shipAmt = $distance * $rate;
                // } else {
                //     $shipAmt = $distance * $configurationData['ratePer'];
                // }

                 if ($rate > 0) {
                    $shipAmt = $rate;
                } else {
                    $shipAmt = $configurationData['ratePer'];
                }


                if ($configurationData['productQty']) {
                    $shipAmt = $shipAmt * $totalCartQty;
                }
                $shipAmount =  $configurationData['handlingCharge'] + $shipAmt;
                if ($shipAmount < $configurationData['minimumAmount']) {
                    $shippingAmount =  $configurationData['minimumAmount'];
                } else {
                    $shippingAmount = $shipAmount;
                }
            } else {
                $result = ['handlingfee' => 0,  'error' => true];
                return $result;
            }
            $result = ['handlingfee' => $shippingAmount,  'error' => false];
            return $result;
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
            $result = ['handlingfee' => 0,  'error' => true];
            return $result;
        }
    }
    
    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['distancerateshipping' => $this->getConfigData('method_title')];
    }

    /**
     * @param int quot item id $itemId
     * @return quote item object $item
     */
    public function getProductIdByQuoteId($itemId)
    {
        $item = $this->_quoteItemModel->load($itemId);
        return $item;
    }

    /**
     * Check if carrier has shipping label option available
     *
     * @return bool
     */
    public function isShippingLabelsAvailable()
    {
        return false;
    }
}
