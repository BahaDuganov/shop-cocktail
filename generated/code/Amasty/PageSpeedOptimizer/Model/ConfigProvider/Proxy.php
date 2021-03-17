<?php
namespace Amasty\PageSpeedOptimizer\Model\ConfigProvider;

/**
 * Proxy class for @see \Amasty\PageSpeedOptimizer\Model\ConfigProvider
 */
class Proxy extends \Amasty\PageSpeedOptimizer\Model\ConfigProvider implements \Magento\Framework\ObjectManager\NoninterceptableInterface
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
     * @var \Amasty\PageSpeedOptimizer\Model\ConfigProvider
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\PageSpeedOptimizer\\Model\\ConfigProvider', $shared = true)
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
     * @return \Amasty\PageSpeedOptimizer\Model\ConfigProvider
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
    public function isEnabled()
    {
        return $this->_getSubject()->isEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function isCloud()
    {
        return $this->_getSubject()->isCloud();
    }

    /**
     * {@inheritdoc}
     */
    public function getBundlingFiles()
    {
        return $this->_getSubject()->getBundlingFiles();
    }

    /**
     * {@inheritdoc}
     */
    public function isMoveJS()
    {
        return $this->_getSubject()->isMoveJS();
    }

    /**
     * {@inheritdoc}
     */
    public function adminhtmlJsMergeBundle()
    {
        return $this->_getSubject()->adminhtmlJsMergeBundle();
    }

    /**
     * {@inheritdoc}
     */
    public function getExcludeUrlsFromMergeBundleJs()
    {
        return $this->_getSubject()->getExcludeUrlsFromMergeBundleJs();
    }

    /**
     * {@inheritdoc}
     */
    public function adminhtmlMergeCss()
    {
        return $this->_getSubject()->adminhtmlMergeCss();
    }

    /**
     * {@inheritdoc}
     */
    public function isMultiprocessEnabled()
    {
        return $this->_getSubject()->isMultiprocessEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxJobsCount()
    {
        return $this->_getSubject()->getMaxJobsCount();
    }

    /**
     * {@inheritdoc}
     */
    public function getExcludeUrlsFromMergeCss()
    {
        return $this->_getSubject()->getExcludeUrlsFromMergeCss();
    }

    /**
     * {@inheritdoc}
     */
    public function getMoveJsExcludeUrl()
    {
        return $this->_getSubject()->getMoveJsExcludeUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getMoveJsExcludePart()
    {
        return $this->_getSubject()->getMoveJsExcludePart();
    }

    /**
     * {@inheritdoc}
     */
    public function isMovePrintCss()
    {
        return $this->_getSubject()->isMovePrintCss();
    }

    /**
     * {@inheritdoc}
     */
    public function isLazyLoad()
    {
        return $this->_getSubject()->isLazyLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function lazyLoadScript()
    {
        return $this->_getSubject()->lazyLoadScript();
    }

    /**
     * {@inheritdoc}
     */
    public function isOptimizeImages()
    {
        return $this->_getSubject()->isOptimizeImages();
    }

    /**
     * {@inheritdoc}
     */
    public function isAutomaticallyOptimizeImages()
    {
        return $this->_getSubject()->isAutomaticallyOptimizeImages();
    }

    /**
     * {@inheritdoc}
     */
    public function getJpegCommand()
    {
        return $this->_getSubject()->getJpegCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function getPngCommand()
    {
        return $this->_getSubject()->getPngCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function getGifCommand()
    {
        return $this->_getSubject()->getGifCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function getImagesPerRequest()
    {
        return $this->_getSubject()->getImagesPerRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function isMoveFont()
    {
        return $this->_getSubject()->isMoveFont();
    }

    /**
     * {@inheritdoc}
     */
    public function getFontIgnoreList()
    {
        return $this->_getSubject()->getFontIgnoreList();
    }

    /**
     * {@inheritdoc}
     */
    public function isCreateWebp()
    {
        return $this->_getSubject()->isCreateWebp();
    }

    /**
     * {@inheritdoc}
     */
    public function isDumpOriginal()
    {
        return $this->_getSubject()->isDumpOriginal();
    }

    /**
     * {@inheritdoc}
     */
    public function isPreloadImages()
    {
        return $this->_getSubject()->isPreloadImages();
    }

    /**
     * {@inheritdoc}
     */
    public function skipImagesCount($type = '')
    {
        return $this->_getSubject()->skipImagesCount($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getIgnoreImages()
    {
        return $this->_getSubject()->getIgnoreImages();
    }

    /**
     * {@inheritdoc}
     */
    public function getResolutions()
    {
        return $this->_getSubject()->getResolutions();
    }

    /**
     * {@inheritdoc}
     */
    public function isReplaceImagesUsingUserAgent()
    {
        return $this->_getSubject()->isReplaceImagesUsingUserAgent();
    }

    /**
     * {@inheritdoc}
     */
    public function getReplaceImagesUsingUserAgentIgnoreList()
    {
        return $this->_getSubject()->getReplaceImagesUsingUserAgentIgnoreList();
    }

    /**
     * {@inheritdoc}
     */
    public function isReplaceWithWebP()
    {
        return $this->_getSubject()->isReplaceWithWebP();
    }

    /**
     * {@inheritdoc}
     */
    public function getReplaceIgnoreList()
    {
        return $this->_getSubject()->getReplaceIgnoreList();
    }

    /**
     * {@inheritdoc}
     */
    public function isSimpleOptimization()
    {
        return $this->_getSubject()->isSimpleOptimization();
    }

    /**
     * {@inheritdoc}
     */
    public function getSkipStrategy()
    {
        return $this->_getSubject()->getSkipStrategy();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($path)
    {
        return $this->_getSubject()->getConfig($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomValue($path)
    {
        return $this->_getSubject()->getCustomValue($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getResizeAlgorithm()
    {
        return $this->_getSubject()->getResizeAlgorithm();
    }

    /**
     * {@inheritdoc}
     */
    public function getBundlingType()
    {
        return $this->_getSubject()->getBundlingType();
    }

    /**
     * {@inheritdoc}
     */
    public function getBundleStep()
    {
        return $this->_getSubject()->getBundleStep();
    }

    /**
     * {@inheritdoc}
     */
    public function getBundleHash()
    {
        return $this->_getSubject()->getBundleHash();
    }

    /**
     * {@inheritdoc}
     */
    public function isMifiniedJs()
    {
        return $this->_getSubject()->isMifiniedJs();
    }

    /**
     * {@inheritdoc}
     */
    public function convertStringToArray($data, $separator = '
')
    {
        return $this->_getSubject()->convertStringToArray($data, $separator);
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        return $this->_getSubject()->clean();
    }
}
