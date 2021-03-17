<?php

namespace Aislend\Alert\Controller\Test;

class Alert extends \Magento\Framework\App\Action\Action
{
	protected $_sendStockMails;

    public function __construct(\Magento\Framework\App\Action\Context $context,
    	\Aislend\Alert\Cron\SendStockMails $sendStockMails
	)
    {
    	$this->_sendStockMails = $sendStockMails;

        parent::__construct($context);
    }

	public function execute()
	{
		$this->_sendStockMails->guestprocess();
		exit("<br /><br />oloko");
	}
}