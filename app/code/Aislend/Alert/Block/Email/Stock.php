<?php

namespace Aislend\Alert\Block\Email;

class Stock extends \Magento\ProductAlert\Block\Email\AbstractEmail
{

    protected $_template = 'email/stock.phtml';
    protected $_guestMail = null;

    public function getProductUnsubscribeUrl($productId)
    {
        $params = $this->_getUrlParams();
        $params['product'] = $productId;
        $params['email'] = $this->getGuestEmail();
        return $this->getUrl('aislend-alert/unsubscribe/stock', $params);
    }

    /**
     * Retrieve unsubscribe url for all products
     *
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        $params = $this->_getUrlParams();
        $params['email'] = $this->getGuestEmail();
        return $this->getUrl('aislend-alert/unsubscribe/stockAll', $params);
    }

    public function getGuestEmail()
    {
        return $this->_guestMail;
    }

    public function setGuestEmail($email)
    {
        $this->_guestMail = $email;
        return $this;
    }
}