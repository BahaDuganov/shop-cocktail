<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aislend\Sales\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class Price
 */
class PurchasedPrice extends Column
{
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceFormatter;
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        PriceCurrencyInterface $priceFormatter,
        array $components = [],
        array $data = []
    ) {
        $this->priceFormatter = $priceFormatter;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {				
				$round = ($this->getData('name') == 'grand_total') ? round($item[$this->getData('name')], 2) : 	$item[$this->getData('name')];
				$currencyCode = isset($item['order_currency_code']) ? $item['order_currency_code'] : null;
                $item[$this->getData('name')] =
                    $this->priceFormatter->format(
                        $round,
                        false,
                        null,
                        null,
                        $currencyCode
                    );
            }
        }

        return $dataSource;
    }
}
