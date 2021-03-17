<?php
namespace Amasty\ShopbySeo\Helper\Meta;

/**
 * Interceptor class for @see \Amasty\ShopbySeo\Helper\Meta
 */
class Interceptor extends \Amasty\ShopbySeo\Helper\Meta implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Amasty\Shopby\Helper\Data $dataHelper, \Amasty\ShopbySeo\Helper\Data $seoHelper, \Magento\Framework\Registry $registry, \Magento\Framework\App\Request\Http $request, \Amasty\ShopbyBase\Model\Integration\IntegrationFactory $integrationFactory)
    {
        $this->___init();
        parent::__construct($context, $dataHelper, $seoHelper, $registry, $request, $integrationFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexTagByData($indexTag, \Magento\Framework\DataObject $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIndexTagByData');
        if (!$pluginInfo) {
            return parent::getIndexTagByData($indexTag, $data);
        } else {
            return $this->___callPlugins('getIndexTagByData', func_get_args(), $pluginInfo);
        }
    }
}
