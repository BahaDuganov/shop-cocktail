<?php
namespace Mirasvit\Misspell\Model\Indexer;

/**
 * Interceptor class for @see \Mirasvit\Misspell\Model\Indexer
 */
class Interceptor extends \Mirasvit\Misspell\Model\Indexer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Misspell\Model\ConfigProvider $configProvider, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($configProvider, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function executeFull() : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeFull');
        if (!$pluginInfo) {
            parent::executeFull();
        } else {
            $this->___callPlugins('executeFull', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeList(array $ids) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeList');
        if (!$pluginInfo) {
            parent::executeList($ids);
        } else {
            $this->___callPlugins('executeList', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeRow($id) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'executeRow');
        if (!$pluginInfo) {
            parent::executeRow($id);
        } else {
            $this->___callPlugins('executeRow', func_get_args(), $pluginInfo);
        }
    }
}
