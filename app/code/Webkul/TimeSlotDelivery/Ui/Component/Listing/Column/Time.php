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
namespace Webkul\TimeSlotDelivery\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

/**
 * Class Price
 */
class Time extends \Magento\Ui\Component\Listing\Columns\Column
{

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param PriceCurrencyInterface $priceFormatter
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $components = [],
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
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
        $date = $this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['start_time']) || isset($item['end_time'])) {
                    $item[$this->getData('name')] = $date->gmtDate('h:i A', $item[$this->getData('name')]);
                }
            }
        }

        return $dataSource;
    }
}
