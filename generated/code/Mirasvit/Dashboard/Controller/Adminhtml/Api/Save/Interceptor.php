<?php
namespace Mirasvit\Dashboard\Controller\Adminhtml\Api\Save;

/**
 * Interceptor class for @see \Mirasvit\Dashboard\Controller\Adminhtml\Api\Save
 */
class Interceptor extends \Mirasvit\Dashboard\Controller\Adminhtml\Api\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Dashboard\Repository\BoardRepository $boardRepository, \Mirasvit\Report\Api\Service\CastingServiceInterface $castingService, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($boardRepository, $castingService, $context);
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
