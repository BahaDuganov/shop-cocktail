<?php

namespace Aislend\Alert\Model;

use Magento\Framework\Model\AbstractModel;


class GuestAlert extends AbstractModel
{
	protected function _construct()
	{
		$this->_init(\Aislend\Alert\Model\ResourceModel\GuestAlert::class);
	}


	public function execute()
	{
		exit('edfdfdfd');

	}
}