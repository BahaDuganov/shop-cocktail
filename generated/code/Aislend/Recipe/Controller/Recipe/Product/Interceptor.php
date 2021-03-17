<?php
namespace Aislend\Recipe\Controller\Recipe\Product;

/**
 * Interceptor class for @see \Aislend\Recipe\Controller\Recipe\Product
 */
class Interceptor extends \Aislend\Recipe\Controller\Recipe\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Catalog\Helper\Image $imageHelper, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productloader, \Magento\Eav\Model\Config $eavAttribute, \Magento\CatalogInventory\Model\Stock\Item $stockItem)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $resultRawFactory, $imageHelper, $_productloader, $eavAttribute, $stockItem);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
