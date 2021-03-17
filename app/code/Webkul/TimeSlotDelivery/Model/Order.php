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
namespace Webkul\TimeSlotDelivery\Model;

use Webkul\TimeSlotDelivery\Api\Data\OrderInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Proerder Complete Item Model
 *
 */
class Order extends AbstractModel implements OrderInterface, IdentityInterface
{
    /**
     * slots order cache tag
     */
    const CACHE_TAG = 'slots_order';

    /**#@-*/
    /**
     * @var string
     */
    protected $_cacheTag = 'slots_order';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'slots_order';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webkul\TimeSlotDelivery\Model\ResourceModel\Order');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve item id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    
    /**
     * Set ID
     *
     * @return int|null
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
