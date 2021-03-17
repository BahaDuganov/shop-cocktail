<?php
namespace Amasty\Xsearch\Helper\Data;

/**
 * Interceptor class for @see \Amasty\Xsearch\Helper\Data
 */
class Interceptor extends \Amasty\Xsearch\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Config $configAttribute, \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $collection, \Magento\Search\Helper\Data $searchHelper, \Magento\Framework\Filter\StripTags $stripTags, \Magento\Framework\App\Helper\Context $context, \Magento\Customer\Model\SessionFactory $sessionFactory, \Amasty\Xsearch\Model\Config $moduleConfigProvider)
    {
        $this->___init();
        parent::__construct($configAttribute, $collection, $searchHelper, $stripTags, $context, $sessionFactory, $moduleConfigProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function highlight($text, $query)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'highlight');
        if (!$pluginInfo) {
            return parent::highlight($text, $query);
        } else {
            return $this->___callPlugins('highlight', func_get_args(), $pluginInfo);
        }
    }
}
