<?php
namespace Amasty\Shopby\Controller\Router;

/**
 * Interceptor class for @see \Amasty\Shopby\Controller\Router
 */
class Interceptor extends \Amasty\Shopby\Controller\Router implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ActionFactory $actionFactory, \Amasty\Shopby\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($actionFactory, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function checkMatchExpressions(\Magento\Framework\App\RequestInterface $request, $identifier)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkMatchExpressions');
        if (!$pluginInfo) {
            return parent::checkMatchExpressions($request, $identifier);
        } else {
            return $this->___callPlugins('checkMatchExpressions', func_get_args(), $pluginInfo);
        }
    }
}
