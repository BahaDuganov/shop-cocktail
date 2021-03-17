<?php
namespace Amasty\Conditions\Model\Rule\Condition\Address;

/**
 * Interceptor class for @see \Amasty\Conditions\Model\Rule\Condition\Address
 */
class Interceptor extends \Amasty\Conditions\Model\Rule\Condition\Address implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, \Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Directory\Model\Config\Source\Country $country, \Magento\Config\Model\Config\Source\Locale\Currency $currency, \Magento\Payment\Model\Config\Source\Allmethods $allMethods, \Amasty\Conditions\Model\Address $address, \Amasty\Conditions\Model\AddressFactory $addressFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $productMetadata, $country, $currency, $allMethods, $address, $addressFactory, $storeManager, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getValueParsed()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getValueParsed');
        if (!$pluginInfo) {
            return parent::getValueParsed();
        } else {
            return $this->___callPlugins('getValueParsed', func_get_args(), $pluginInfo);
        }
    }
}
