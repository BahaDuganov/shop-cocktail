<?php
namespace Magento\Catalog\Model\Indexer\Product\Eav\Action\Row;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Indexer\Product\Eav\Action\Row
 */
class Interceptor extends \Magento\Catalog\Model\Indexer\Product\Eav\Action\Row implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\DecimalFactory $eavDecimalFactory, \Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\SourceFactory $eavSourceFactory, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null)
    {
        $this->___init();
        parent::__construct($eavDecimalFactory, $eavSourceFactory, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($id = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute($id);
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
