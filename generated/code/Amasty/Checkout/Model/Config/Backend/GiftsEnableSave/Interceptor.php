<?php
namespace Amasty\Checkout\Model\Config\Backend\GiftsEnableSave;

/**
 * Interceptor class for @see \Amasty\Checkout\Model\Config\Backend\GiftsEnableSave
 */
class Interceptor extends \Amasty\Checkout\Model\Config\Backend\GiftsEnableSave implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\App\Config\ScopeConfigInterface $config, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection, \Magento\Config\Model\ResourceModel\Config $configData, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $configData, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'afterSave');
        if (!$pluginInfo) {
            return parent::afterSave();
        } else {
            return $this->___callPlugins('afterSave', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        if (!$pluginInfo) {
            return parent::save();
        } else {
            return $this->___callPlugins('save', func_get_args(), $pluginInfo);
        }
    }
}
