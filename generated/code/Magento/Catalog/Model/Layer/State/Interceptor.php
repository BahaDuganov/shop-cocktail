<?php
namespace Magento\Catalog\Model\Layer\State;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Layer\State
 */
class Interceptor extends \Magento\Catalog\Model\Layer\State implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(array $data = [])
    {
        $this->___init();
        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter($filter)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFilter');
        if (!$pluginInfo) {
            return parent::addFilter($filter);
        } else {
            return $this->___callPlugins('addFilter', func_get_args(), $pluginInfo);
        }
    }
}
