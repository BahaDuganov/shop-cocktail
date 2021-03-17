<?php
namespace Mirasvit\SearchSphinx\Controller\Adminhtml\Command\Status;

/**
 * Interceptor class for @see \Mirasvit\SearchSphinx\Controller\Adminhtml\Command\Status
 */
class Interceptor extends \Mirasvit\SearchSphinx\Controller\Adminhtml\Command\Status implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mirasvit\SearchSphinx\Model\Engine $engine)
    {
        $this->___init();
        parent::__construct($context, $engine);
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
