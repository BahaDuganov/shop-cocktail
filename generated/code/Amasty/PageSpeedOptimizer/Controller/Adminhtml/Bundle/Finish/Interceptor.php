<?php
namespace Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Finish;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Finish
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Controller\Adminhtml\Bundle\Finish implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Cache\TypeListInterface $cache, \Magento\Framework\App\Config\Storage\WriterInterface $configWriter, \Amasty\PageSpeedOptimizer\Model\ConfigProvider $configProvider, \Amasty\PageSpeedOptimizer\Model\Bundle\ResourceModel\CollectionFactory $collectionFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($cache, $configWriter, $configProvider, $collectionFactory, $context);
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
