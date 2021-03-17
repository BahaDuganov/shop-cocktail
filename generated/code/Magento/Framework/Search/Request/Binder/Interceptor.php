<?php
namespace Magento\Framework\Search\Request\Binder;

/**
 * Interceptor class for @see \Magento\Framework\Search\Request\Binder
 */
class Interceptor extends \Magento\Framework\Search\Request\Binder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function bind(array $requestData, array $bindData)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'bind');
        if (!$pluginInfo) {
            return parent::bind($requestData, $bindData);
        } else {
            return $this->___callPlugins('bind', func_get_args(), $pluginInfo);
        }
    }
}
