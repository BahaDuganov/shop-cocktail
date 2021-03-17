<?php

namespace Aislend\Alert\Helper;

class AlertUrl extends \Magento\Framework\Url\Helper\Data
{

    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        parent::__construct($context);
    }

    public function getStockUrl($productId)
    {
        return $this->_getUrl(
            'aislend-alert/add/user',
            [
                'product_id' => $productId,
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => $this->getEncodedUrl()
            ]
        );
    }

    public function getGuestUrl($productId)
    {
        return $this->_getUrl(
            'aislend-alert/add/guest',
            [
                'product_id' => $productId,
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => $this->getEncodedUrl()
            ]
        );
    }
}
