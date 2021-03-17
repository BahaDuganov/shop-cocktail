<?php
/**
 * DistanceRateShipping
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Model;

use Webkul\DistanceRateShipping\Api\Data\DistanceRateShippingInterface;
use Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class DistanceRateShipping extends AbstractModel implements DistanceRateShippingInterface, IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'webkulshipping';

    /**
     * @var string
     */
    protected $_cacheTag = 'webkulshipping';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'webkulshipping';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Webkul\DistanceRateShipping\Model\ResourceModel\DistanceRateShipping::class);
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getDrshippingId()];
    }
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getDrshippingId()
    {
        return $this->getData(self::DRSHIPPING_ID);
    }
    public function setDrshippingId($id)
    {
        return $this->setData(self::DRSHIPPING_ID, $id);
    }
}
