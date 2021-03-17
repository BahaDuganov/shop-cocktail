<?php
namespace Amasty\ShopbyBase\Model\XmlSitemap;

/**
 * Interceptor class for @see \Amasty\ShopbyBase\Model\XmlSitemap
 */
class Interceptor extends \Amasty\ShopbyBase\Model\XmlSitemap implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Eav\Model\Config $eavConfig, \Amasty\ShopbyBase\Helper\Data $baseHelper, \Amasty\ShopbyBase\Model\Integration\IntegrationFactory $integrationFactory, \Magento\Framework\DataObjectFactory $dataObjectFactory)
    {
        $this->___init();
        parent::__construct($eavConfig, $baseHelper, $integrationFactory, $dataObjectFactory);
    }
}
