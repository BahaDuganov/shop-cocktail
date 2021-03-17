<?php

namespace Aislend\Alert\Block;

use Magento\Customer\Model\Session;
use Aislend\Alert\Helper\AlertUrl;

class Alert extends \Magento\Framework\View\Element\Template
{

	protected $_productId;
    protected $_customerSession;
    protected $_alerturl;
    protected $_coreHelper;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, Session $customerSession, AlertUrl $alerturl, \Magento\Framework\Data\Helper\PostHelper $coreHelper, array $data = [])
    {
        $this->_customerSession = $customerSession;
        $this->_alerturl = $alerturl;
        $this->_coreHelper = $coreHelper;

        parent::__construct($context, $data);
    }

    public function isCustomerLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }

    public function setProdId($prodId)
    {
    	$this->_productId = $prodId;
    	return $this;
    }

    public function getProdId()
    {
    	return $this->_productId;
    }

    public function getAlertUrl()
    {
        if($this->isCustomerLoggedIn()){
            $alerturl = $this->_alerturl->getStockUrl($this->getProdId());
        }else{
            $alerturl = $this->_alerturl->getGuestUrl($this->getProdId());
        }

        $data = array(
            'id' => $this->getProdId()
        );
        
        return $this->_coreHelper->getPostData($alerturl, $data);
    }
}