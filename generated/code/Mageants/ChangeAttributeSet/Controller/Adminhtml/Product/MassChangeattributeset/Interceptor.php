<?php
namespace Mageants\ChangeAttributeSet\Controller\Adminhtml\Product\MassChangeattributeset;

/**
 * Interceptor class for @see \Mageants\ChangeAttributeSet\Controller\Adminhtml\Product\MassChangeattributeset
 */
class Interceptor extends \Mageants\ChangeAttributeSet\Controller\Adminhtml\Product\MassChangeattributeset implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableProduct, \Magento\Eav\Model\EntityFactory $entityFactory)
    {
        $this->___init();
        parent::__construct($context, $productBuilder, $filter, $collectionFactory, $attributeSetFactory, $scopeConfig, $configurableProduct, $entityFactory);
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
