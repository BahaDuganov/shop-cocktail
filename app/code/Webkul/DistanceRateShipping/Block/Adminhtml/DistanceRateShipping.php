<?php

/**
 * DistanceRateShipping Block
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Block\Adminhtml;

class DistanceRateShipping extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     * @param \Magento\Catalog\Block\Product\Context    $context
     * @param array                                     $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_jsonHelper = $jsonHelper;
    }

    /**
     * [Get Json Helper]
     */
    public function getJsonHelper()
    {
        return $this->_jsonHelper;
    }
}
