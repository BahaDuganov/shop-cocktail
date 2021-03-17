<?php
namespace Amasty\Shopby\Helper\Category;

/**
 * Proxy class for @see \Amasty\Shopby\Helper\Category
 */
class Proxy extends \Amasty\Shopby\Helper\Category implements \Magento\Framework\ObjectManager\NoninterceptableInterface
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
     * @var \Amasty\Shopby\Helper\Category
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\Shopby\\Helper\\Category', $shared = true)
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
     * @return \Amasty\Shopby\Helper\Category
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
    public function getStartCategory()
    {
        return $this->_getSubject()->getStartCategory();
    }

    /**
     * {@inheritdoc}
     */
    public function isCategoryFilterExtended()
    {
        return $this->_getSubject()->isCategoryFilterExtended();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryImageUrl($categoryId, $imageType = 'thumbnail')
    {
        return $this->_getSubject()->getCategoryImageUrl($categoryId, $imageType);
    }

    /**
     * {@inheritdoc}
     */
    public function isCategoryImageExist($categoryId)
    {
        return $this->_getSubject()->isCategoryImageExist($categoryId);
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrl($imageName, $withPlaceholder = false, $width = null, $height = null)
    {
        return $this->_getSubject()->getImageUrl($imageName, $withPlaceholder, $width, $height);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryFilterImageSize()
    {
        return $this->_getSubject()->getCategoryFilterImageSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getChildrenCategoriesBlockDisplayMode()
    {
        return $this->_getSubject()->getChildrenCategoriesBlockDisplayMode();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowCategories()
    {
        return $this->_getSubject()->getAllowCategories();
    }

    /**
     * {@inheritdoc}
     */
    public function isChildrenCategoriesSliderEnabled()
    {
        return $this->_getSubject()->isChildrenCategoriesSliderEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function getChildrenCategoriesBlockImageSize()
    {
        return $this->_getSubject()->getChildrenCategoriesBlockImageSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getChildrenCategoriesItemsCountPerSlide()
    {
        return $this->_getSubject()->getChildrenCategoriesItemsCountPerSlide();
    }

    /**
     * {@inheritdoc}
     */
    public function showChildrenCategoriesImageLabels()
    {
        return $this->_getSubject()->showChildrenCategoriesImageLabels();
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting()
    {
        return $this->_getSubject()->getSetting();
    }

    /**
     * {@inheritdoc}
     */
    public function getLayer()
    {
        return $this->_getSubject()->getLayer();
    }

    /**
     * {@inheritdoc}
     */
    public function isMultiselect()
    {
        return $this->_getSubject()->isMultiselect();
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        return $this->_getSubject()->isModuleOutputEnabled($moduleName);
    }
}
