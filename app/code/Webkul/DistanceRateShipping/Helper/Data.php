<?php
/**
 * Webkul_DistanceRateShipping data helper
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context  $context
     * @param \Webkul\DistanceRateShipping\Model\ShippingConfigFactory $sellerConfig
     * @param \Webkul\DistanceRateShipping\Model\SellerLocationFactory $sellerLocation
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Webkul\DistanceRateShipping\Logger\Logger $logger,
        \Magento\Framework\HTTP\Client\Curl $curl,
        StoreManagerInterface $storeManager
    ) {
        $this->logger = $logger;
        $this->curl = $curl;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get Configuration Detail of Affiliate
     * @return array of DistanceRateShipping Configuration Detail
     */
    public function getConfig()
    {
        $shipConfig = [
            'enable' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/shipping_manage',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'googleApi' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/api_key',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'location' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/location',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'latitude' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/latitude',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'longitude' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/longitude',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'productShipping' => $this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/productShipping',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'distanceCalculateBase'=>$this->scopeConfig->getValue(
                'wk_distancerateshipping/general_settings/distanceCalculateBase',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'title' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/title',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'methodName' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/methodName',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'specificerrmsg' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/specificerrmsg',
                ScopeInterface::SCOPE_STORE
            ),
            'maximumArea' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/maximum_area',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'unit' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/unit',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'productQty' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/productQty',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'ratePer' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/rate_per',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'handlingCharge' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/handling_charge',
                ScopeInterface::SCOPE_WEBSITE
            ),
            'minimumAmount' => $this->scopeConfig->getValue(
                'carriers/distancerateshipping/minimum_amount',
                ScopeInterface::SCOPE_WEBSITE
            ),
        ];
        return $shipConfig;
    }
    
    public function getDistanceFromTwoPoints($from, $to, $radiousUnit)
    {
        $R = 6371; // km
        $dLat = ($from['latitude'] - $to['latitude']) * M_PI / 180;
        $dLon = ($from['longitude'] - $to['longitude']) * M_PI / 180;
        $lat1 = $to['latitude'] * M_PI / 180;
        $lat2 = $from['latitude'] * M_PI / 180;
        $a = sin($dLat/2) * sin($dLat/2) + sin($dLon/2) * sin($dLon/2) * cos($lat1) * cos($lat2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $R * $c;
        if ($radiousUnit == 'miles') {
            $m = $d * 0.621371; //for milles
            return $m;
        }
        return $d;
    }

    public function getDrivingDistanceCal($key, $shippingAddress, $origin, $radiousUnit)
    {
        try {
            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.
            $shippingAddress.'&destinations='.$origin.'&key='.$key;
            $this->curl->get($url);
            $output = json_decode($this->curl->getBody(), true);
            if ($output &&
                (isset($output['rows'][0]['elements'][0]['distance']['value']))) {
                $meters = $output['rows'][0]['elements'][0]['distance']['value'];
                $metersText = $output['rows'][0]['elements'][0]['distance']['text'];
                if (($meters == 0) && (strpos($metersText, "m") === true)) {
                    $data = explode('m', $metersText);
                    $meters = (float)$data[0];
                }
                if ($radiousUnit == 'miles') {
                    $miles = $meters * 0.00062137;
                    return $miles;
                } else {
                    $kilo = $meters * 0.001;
                    return $kilo;
                }
            } else {
                $to = [];
                $adminConfigData = $this->getConfig();
                $to['latitude'] = $adminConfigData['latitude'];
                $to['longitude'] = $adminConfigData['longitude'];
                $radiousUnit = $adminConfigData['unit'];
                $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$key.'&address='.
                $shippingAddress.'&sensor=false';
                $this->curl->get($url);
                $output = json_decode($this->curl->getBody(), true);
                if ($output['results']) {
                    $from['latitude'] = $output['results'][0]['geometry']['location']['lat'];
                    $from['longitude'] = $output['results'][0]['geometry']['location']['lng'];
                }
                $distance = $this->getDistanceFromTwoPoints($from, $to, $radiousUnit);
                return $distance;
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
            throw new \LocalizedException(__('Something went wrong.'));
        }
    }
}
