<?php
namespace Amasty\GiftCard\Block\Product\View\Type\GiftCard;

/**
 * Interceptor class for @see \Amasty\GiftCard\Block\Product\View\Type\GiftCard
 */
class Interceptor extends \Amasty\GiftCard\Block\Product\View\Type\GiftCard implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, \Amasty\GiftCard\Model\ConfigProvider $configProvider, \Amasty\GiftCard\Model\Image\Repository $imageRepository, \Amasty\GiftCard\Model\OptionSource\GiftCardOption $giftCardOption, \Magento\Framework\Locale\ListsInterface $localeLists, \Amasty\GiftCard\Model\Image\ResourceModel\CollectionFactory $imageCollectionFactory, \Amasty\GiftCard\Utils\FileUpload $fileUpload, \Magento\Framework\Serialize\Serializer\Json $jsonSerializer, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $arrayUtils, $configProvider, $imageRepository, $giftCardOption, $localeLists, $imageCollectionFactory, $fileUpload, $jsonSerializer, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
