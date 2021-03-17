<?php
namespace Amasty\ElasticSearch\Controller\Adminhtml\RelevanceRule\Delete;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Controller\Adminhtml\RelevanceRule\Delete
 */
class Interceptor extends \Amasty\ElasticSearch\Controller\Adminhtml\RelevanceRule\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\ElasticSearch\Model\RelevanceRuleRepository $relevanceRuleRepository, \Amasty\ElasticSearch\Model\ResourceModel\RelevanceRule\CollectionFactory $collectionFactory, \Magento\Ui\Component\MassAction\Filter $filter)
    {
        $this->___init();
        parent::__construct($context, $relevanceRuleRepository, $collectionFactory, $filter);
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
