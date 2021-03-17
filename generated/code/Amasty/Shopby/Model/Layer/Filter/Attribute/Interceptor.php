<?php
namespace Amasty\Shopby\Model\Layer\Filter\Attribute;

/**
 * Interceptor class for @see \Amasty\Shopby\Model\Layer\Filter\Attribute
 */
class Interceptor extends \Amasty\Shopby\Model\Layer\Filter\Attribute implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Model\Layer $layer, \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder, \Magento\Framework\Filter\StripTags $tagFilter, \Magento\Search\Model\SearchEngine $searchEngine, \Amasty\Shopby\Helper\FilterSetting $settingHelper, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Amasty\Shopby\Model\Request $shopbyRequest, \Amasty\Shopby\Helper\Group $groupHelper, \Amasty\ShopbyBase\Helper\OptionSetting $optionSettingHelper, \Magento\Framework\Message\ManagerInterface $messageManager, array $data = [])
    {
        $this->___init();
        parent::__construct($filterItemFactory, $storeManager, $layer, $itemDataBuilder, $tagFilter, $searchEngine, $settingHelper, $scopeConfig, $shopbyRequest, $groupHelper, $optionSettingHelper, $messageManager, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function shouldAddState()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'shouldAddState');
        if (!$pluginInfo) {
            return parent::shouldAddState();
        } else {
            return $this->___callPlugins('shouldAddState', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isVisibleWhenSelected()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isVisibleWhenSelected');
        if (!$pluginInfo) {
            return parent::isVisibleWhenSelected();
        } else {
            return $this->___callPlugins('isVisibleWhenSelected', func_get_args(), $pluginInfo);
        }
    }
}
