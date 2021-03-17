<?php
namespace LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface;

/**
 * Proxy class for @see \LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface
 */
class Proxy implements \LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface, \Magento\Framework\ObjectManager\NoninterceptableInterface
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
     * @var \LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\LizardMedia\\VarnishWarmer\\Api\\VarnishActionManagerInterface', $shared = true)
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
     * @return \LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface
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
    public function purgeWildcard() : void
    {
        $this->_getSubject()->purgeWildcard();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeWildcardWithoutRegen() : void
    {
        $this->_getSubject()->purgeWildcardWithoutRegen();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeAll() : void
    {
        $this->_getSubject()->purgeAll();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeGeneral() : void
    {
        $this->_getSubject()->purgeGeneral();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeHomepage() : void
    {
        $this->_getSubject()->purgeHomepage();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeAndRegenerateProducts() : void
    {
        $this->_getSubject()->purgeAndRegenerateProducts();
    }

    /**
     * {@inheritdoc}
     */
    public function purgeAndRegenerateUrl(string $url) : void
    {
        $this->_getSubject()->purgeAndRegenerateUrl($url);
    }

    /**
     * {@inheritdoc}
     */
    public function purgeProduct(\Magento\Catalog\Api\Data\ProductInterface $product) : void
    {
        $this->_getSubject()->purgeProduct($product);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreViewId(int $storeViewId)
    {
        return $this->_getSubject()->setStoreViewId($storeViewId);
    }

    /**
     * {@inheritdoc}
     */
    public function isLocked() : bool
    {
        return $this->_getSubject()->isLocked();
    }

    /**
     * {@inheritdoc}
     */
    public function getLockMessage() : string
    {
        return $this->_getSubject()->getLockMessage();
    }
}
