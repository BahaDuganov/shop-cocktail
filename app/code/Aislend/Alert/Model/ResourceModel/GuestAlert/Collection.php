<?php

namespace Aislend\Alert\Model\ResourceModel\GuestAlert;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

	protected $_idFieldName = 'id';

    protected function _construct()
    {
    	$this->_init('Aislend\Alert\Model\GuestAlert', 'Aislend\Alert\Model\ResourceModel\GuestAlert');
    }

    public function setEmailOrder($sort = 'ASC')
    {
        $this->getSelect()->order('email ' . $sort);
        return $this;
    }
}