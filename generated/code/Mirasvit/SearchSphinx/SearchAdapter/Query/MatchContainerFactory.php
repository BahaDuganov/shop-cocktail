<?php
namespace Mirasvit\SearchSphinx\SearchAdapter\Query;

/**
 * Factory class for @see \Mirasvit\SearchSphinx\SearchAdapter\Query\MatchContainer
 */
class MatchContainerFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Mirasvit\\SearchSphinx\\SearchAdapter\\Query\\MatchContainer')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Mirasvit\SearchSphinx\SearchAdapter\Query\MatchContainer
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
