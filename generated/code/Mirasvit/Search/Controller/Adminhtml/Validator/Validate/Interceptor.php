<?php
namespace Mirasvit\Search\Controller\Adminhtml\Validator\Validate;

/**
 * Interceptor class for @see \Mirasvit\Search\Controller\Adminhtml\Validator\Validate
 */
class Interceptor extends \Mirasvit\Search\Controller\Adminhtml\Validator\Validate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Mirasvit\Search\Repository\IndexRepository $indexRepository, \Mirasvit\Search\Model\ConfigProvider $config, \Magento\Elasticsearch\SearchAdapter\ConnectionManager $connectionManager, \Magento\Elasticsearch\SearchAdapter\SearchIndexNameResolver $searchIndexNameResolver, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($resultJsonFactory, $storeManager, $indexRepository, $config, $connectionManager, $searchIndexNameResolver, $context);
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
