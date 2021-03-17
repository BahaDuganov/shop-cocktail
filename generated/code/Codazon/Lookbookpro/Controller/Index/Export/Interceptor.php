<?php
namespace Codazon\Lookbookpro\Controller\Index\Export;

/**
 * Interceptor class for @see \Codazon\Lookbookpro\Controller\Index\Export
 */
class Interceptor extends \Codazon\Lookbookpro\Controller\Index\Export implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Codazon\Lookbookpro\Model\LookbookData $lookbookData, \Codazon\Lookbookpro\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $lookbookData, $helper);
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
