<?php
namespace Mageplaza\FrequentlyBought\Controller\Cart\Add;

/**
 * Interceptor class for @see \Mageplaza\FrequentlyBought\Controller\Cart\Add
 */
class Interceptor extends \Mageplaza\FrequentlyBought\Controller\Cart\Add implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Checkout\Model\Cart $cart, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Mageplaza\FrequentlyBought\Helper\Data $fbtDataHelper, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Escaper $escaper, \Magento\Checkout\Helper\Cart $cartHelper)
    {
        $this->___init();
        parent::__construct($context, $scopeConfig, $checkoutSession, $storeManager, $formKeyValidator, $cart, $productRepository, $fbtDataHelper, $logger, $escaper, $cartHelper);
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
