<?php
namespace LizardMedia\VarnishWarmer\Model\ProgressHandler;

/**
 * Factory class for @see \LizardMedia\VarnishWarmer\Model\ProgressHandler\ProgressData
 */
class ProgressDataFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\LizardMedia\\VarnishWarmer\\Model\\ProgressHandler\\ProgressData')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \LizardMedia\VarnishWarmer\Model\ProgressHandler\ProgressData
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
