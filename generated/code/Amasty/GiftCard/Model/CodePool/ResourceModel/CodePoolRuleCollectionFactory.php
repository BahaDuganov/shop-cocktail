<?php
namespace Amasty\GiftCard\Model\CodePool\ResourceModel;

/**
 * Factory class for @see \Amasty\GiftCard\Model\CodePool\ResourceModel\CodePoolRuleCollection
 */
class CodePoolRuleCollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\GiftCard\\Model\\CodePool\\ResourceModel\\CodePoolRuleCollection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Amasty\GiftCard\Model\CodePool\ResourceModel\CodePoolRuleCollection
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
