<?php
namespace Mirasvit\SearchMysql\SearchAdapter\Mapper\Product\SelectContainer;

/**
 * Factory class for @see \Mirasvit\SearchMysql\SearchAdapter\Mapper\Product\SelectContainer\SelectContainer
 */
class SelectContainerFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Mirasvit\\SearchMysql\\SearchAdapter\\Mapper\\Product\\SelectContainer\\SelectContainer')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Mirasvit\SearchMysql\SearchAdapter\Mapper\Product\SelectContainer\SelectContainer
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
