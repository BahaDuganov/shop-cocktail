<?php
namespace Magento\Framework\View\Page\Title;

/**
 * Interceptor class for @see \Magento\Framework\View\Page\Title
 */
class Interceptor extends \Magento\Framework\View\Page\Title implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function set($title)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'set');
        if (!$pluginInfo) {
            return parent::set($title);
        } else {
            return $this->___callPlugins('set', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function unsetValue()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'unsetValue');
        if (!$pluginInfo) {
            return parent::unsetValue();
        } else {
            return $this->___callPlugins('unsetValue', func_get_args(), $pluginInfo);
        }
    }
}
