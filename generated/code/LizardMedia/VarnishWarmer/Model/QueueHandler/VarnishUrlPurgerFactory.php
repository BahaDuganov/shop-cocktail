<?php
namespace LizardMedia\VarnishWarmer\Model\QueueHandler;

/**
 * Factory class for @see \LizardMedia\VarnishWarmer\Model\QueueHandler\VarnishUrlPurger
 */
class VarnishUrlPurgerFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\LizardMedia\\VarnishWarmer\\Model\\QueueHandler\\VarnishUrlPurger')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \LizardMedia\VarnishWarmer\Model\QueueHandler\VarnishUrlPurger
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
