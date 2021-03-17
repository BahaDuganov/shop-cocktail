<?php
namespace Magento\Csp\Observer\Render;

/**
 * Interceptor class for @see \Magento\Csp\Observer\Render
 */
class Interceptor extends \Magento\Csp\Observer\Render implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Csp\Api\CspRendererInterface $cspRenderer)
    {
        $this->___init();
        parent::__construct($cspRenderer);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute($observer);
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
