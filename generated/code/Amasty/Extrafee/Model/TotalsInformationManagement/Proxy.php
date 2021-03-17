<?php
namespace Amasty\Extrafee\Model\TotalsInformationManagement;

/**
 * Proxy class for @see \Amasty\Extrafee\Model\TotalsInformationManagement
 */
class Proxy extends \Amasty\Extrafee\Model\TotalsInformationManagement implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Amasty\Extrafee\Model\TotalsInformationManagement
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\Extrafee\\Model\\TotalsInformationManagement', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        $this->_subject = clone $this->_getSubject();
    }

    /**
     * Get proxied instance
     *
     * @return \Amasty\Extrafee\Model\TotalsInformationManagement
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate($cartId, \Amasty\Extrafee\Api\Data\TotalsInformationInterface $information, \Magento\Checkout\Api\Data\TotalsInformationInterface $addressInformation)
    {
        return $this->_getSubject()->calculate($cartId, $information, $addressInformation);
    }

    /**
     * {@inheritdoc}
     */
    public function proceedQuoteOptions(\Magento\Quote\Model\Quote $quote, $feeId, $optionsIds)
    {
        return $this->_getSubject()->proceedQuoteOptions($quote, $feeId, $optionsIds);
    }

    /**
     * {@inheritdoc}
     */
    public function updateQuoteFees(\Magento\Quote\Model\Quote $quote)
    {
        return $this->_getSubject()->updateQuoteFees($quote);
    }
}
