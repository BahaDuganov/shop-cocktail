<?php
namespace Magento\Catalog\Model\Category\Image;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Category\Image
 */
class Interceptor extends \Magento\Catalog\Model\Category\Image implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Category\FileInfo $fileInfo, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($fileInfo, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(\Magento\Catalog\Model\Category $category, string $attributeCode = 'image') : string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUrl');
        if (!$pluginInfo) {
            return parent::getUrl($category, $attributeCode);
        } else {
            return $this->___callPlugins('getUrl', func_get_args(), $pluginInfo);
        }
    }
}
