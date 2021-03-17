<?php
namespace Custom\Swatches\Block\Product\Renderer\Listing;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Product as CatalogProduct;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Swatches\Helper\Data as SwatchData;
use Magento\Swatches\Helper\Media;
use Magento\Swatches\Model\SwatchAttributesProvider;

class Configurable extends \Magento\Swatches\Block\Product\Renderer\Listing\Configurable
{
    /**
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $localeFormat;

    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        EncoderInterface $jsonEncoder,
        Data $helper,
        CatalogProduct $catalogProduct,
        CurrentCustomer $currentCustomer,
        PriceCurrencyInterface $priceCurrency,
        ConfigurableAttributeData $configurableAttributeData,
        SwatchData $swatchHelper,
        Media $swatchMediaHelper,
        array $data = [],
        SwatchAttributesProvider $swatchAttributesProvider = null,
        \Magento\Framework\Locale\FormatInterface $localeFormat
    ) {
        parent::__construct($context, $arrayUtils, $jsonEncoder, $helper,
            $catalogProduct, $currentCustomer, $priceCurrency,
            $configurableAttributeData, $swatchHelper, $swatchMediaHelper,
            $data, $swatchAttributesProvider);
        $this->localeFormat = $localeFormat;
    }


    /**
     * @return string
     */
    protected function getRendererTemplate()
    {
        return 'Custom_Swatches::product/listing/renderer.phtml';
    }

    public function getPriceBoxJsonConfig()
    {
        /* @var $product \Magento\Catalog\Model\Product */
        $product = $this->getProduct();

        if (!$this->hasOptions()) {
            $config = [
                'productId' => $product->getId(),
                'priceFormat' => $this->localeFormat->getPriceFormat()
            ];
            return $this->jsonEncoder->encode($config);
        }

        $tierPrices = [];
        $tierPricesList = $product->getPriceInfo()->getPrice('tier_price')->getTierPriceList();
        foreach ($tierPricesList as $tierPrice) {
            $tierPrices[] = $this->priceCurrency->convert($tierPrice['price']->getValue());
        }
        $config = [
            'productId' => $product->getId(),
            'priceFormat' => $this->localeFormat->getPriceFormat(),
            'prices' => [
                'oldPrice' => [
                    'amount' => $this->priceCurrency->convert(
                        $product->getPriceInfo()->getPrice('regular_price')->getAmount()->getValue()
                    ),
                    'adjustments' => []
                ],
                'basePrice' => [
                    'amount' => $this->priceCurrency->convert(
                        $product->getPriceInfo()->getPrice('final_price')->getAmount()->getBaseAmount()
                    ),
                    'adjustments' => []
                ],
                'finalPrice' => [
                    'amount' => $this->priceCurrency->convert(
                        $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue()
                    ),
                    'adjustments' => []
                ]
            ],
            'idSuffix' => '_clone',
            'tierPrices' => $tierPrices
        ];

        $responseObject = new \Magento\Framework\DataObject();
        $this->_eventManager->dispatch('catalog_product_view_config', ['response_object' => $responseObject]);
        if (is_array($responseObject->getAdditionalOptions())) {
            foreach ($responseObject->getAdditionalOptions() as $option => $value) {
                $config[$option] = $value;
            }
        }

        return $this->jsonEncoder->encode($config);
    }

}
?>