<?php
namespace Amasty\Shopby\Model\Media\ImageProcessor;

/**
 * Interceptor class for @see \Amasty\Shopby\Model\Media\ImageProcessor
 */
class Interceptor extends \Amasty\Shopby\Model\Media\ImageProcessor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Magento\Framework\Image\AdapterFactory $imageFactory, \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase, \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Psr\Log\LoggerInterface $logger, $baseTmpPath, $basePath, array $allowedExtensions = [])
    {
        $this->___init();
        parent::__construct($filesystem, $imageFactory, $coreFileStorageDatabase, $uploaderFactory, $storeManager, $logger, $baseTmpPath, $basePath, $allowedExtensions);
    }

    /**
     * {@inheritdoc}
     */
    public function moveFileFromTmp($imageName, $returnRelativePath = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'moveFileFromTmp');
        if (!$pluginInfo) {
            return parent::moveFileFromTmp($imageName, $returnRelativePath);
        } else {
            return $this->___callPlugins('moveFileFromTmp', func_get_args(), $pluginInfo);
        }
    }
}
