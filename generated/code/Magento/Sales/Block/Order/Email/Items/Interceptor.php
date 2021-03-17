<?php
namespace Magento\Sales\Block\Order\Email\Items;

/**
 * Interceptor class for @see \Magento\Sales\Block\Order\Email\Items
 */
class Interceptor extends \Magento\Sales\Block\Order\Email\Items implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [], ?\Magento\Sales\Api\OrderRepositoryInterface $orderRepository = null)
    {
        $this->___init();
        parent::__construct($context, $data, $orderRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
