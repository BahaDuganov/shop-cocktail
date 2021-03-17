<?php
namespace Codazon\GoogleAmpManager\Setup;

/**
 * Factory class for @see \Codazon\GoogleAmpManager\Setup\GoogleAmpManagerSetup
 */
class GoogleAmpManagerSetupFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Codazon\\GoogleAmpManager\\Setup\\GoogleAmpManagerSetup')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Codazon\GoogleAmpManager\Setup\GoogleAmpManagerSetup
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
