<?php
namespace Amasty\ElasticSearch\Controller\Adminhtml\Config\Checker\Connection;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Controller\Adminhtml\Config\Checker\Connection
 */
class Interceptor extends \Amasty\ElasticSearch\Controller\Adminhtml\Config\Checker\Connection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\ElasticSearch\Model\Config $config, \Amasty\ElasticSearch\Model\Client\ElasticsearchFactory $elasticsearchFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\Filter\StripTags $tagFilter)
    {
        $this->___init();
        parent::__construct($context, $config, $elasticsearchFactory, $resultJsonFactory, $tagFilter);
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
