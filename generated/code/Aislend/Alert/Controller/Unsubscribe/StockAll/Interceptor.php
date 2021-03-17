<?php
namespace Aislend\Alert\Controller\Unsubscribe\StockAll;

/**
 * Interceptor class for @see \Aislend\Alert\Controller\Unsubscribe\StockAll
 */
class Interceptor extends \Aislend\Alert\Controller\Unsubscribe\StockAll implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Aislend\Alert\Model\ResourceModel\GuestAlert\CollectionFactory $guestAlert, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->___init();
        parent::__construct($context, $guestAlert, $productRepository);
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
