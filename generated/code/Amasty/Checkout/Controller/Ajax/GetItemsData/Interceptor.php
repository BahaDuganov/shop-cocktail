<?php
namespace Amasty\Checkout\Controller\Ajax\GetItemsData;

/**
 * Interceptor class for @see \Amasty\Checkout\Controller\Ajax\GetItemsData
 */
class Interceptor extends \Amasty\Checkout\Controller\Ajax\GetItemsData implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Amasty\Checkout\Helper\Item $itemHelper, \Magento\Catalog\Helper\Image $imageHelper)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $itemHelper, $imageHelper);
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
