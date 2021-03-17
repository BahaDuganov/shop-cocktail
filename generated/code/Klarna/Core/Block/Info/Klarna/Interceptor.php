<?php
namespace Klarna\Core\Block\Info\Klarna;

/**
 * Interceptor class for @see \Klarna\Core\Block\Info\Klarna
 */
class Interceptor extends \Klarna\Core\Block\Info\Klarna implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Klarna\Core\Model\OrderRepository $orderRepository, \Klarna\Core\Model\MerchantPortal $merchantPortal, \Magento\Framework\Locale\Resolver $locale, \Magento\Framework\DataObjectFactory $dataObjectFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $merchantPortal, $locale, $dataObjectFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toPdf()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toPdf');
        if (!$pluginInfo) {
            return parent::toPdf();
        } else {
            return $this->___callPlugins('toPdf', func_get_args(), $pluginInfo);
        }
    }
}
