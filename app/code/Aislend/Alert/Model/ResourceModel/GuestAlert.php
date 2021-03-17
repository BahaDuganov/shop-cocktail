<?php

namespace Aislend\Alert\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GuestAlert extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('aislend_alert_stock', 'id');
	}
}