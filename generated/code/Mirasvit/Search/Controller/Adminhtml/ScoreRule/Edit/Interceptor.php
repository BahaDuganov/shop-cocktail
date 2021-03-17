<?php
namespace Mirasvit\Search\Controller\Adminhtml\ScoreRule\Edit;

/**
 * Interceptor class for @see \Mirasvit\Search\Controller\Adminhtml\ScoreRule\Edit
 */
class Interceptor extends \Mirasvit\Search\Controller\Adminhtml\ScoreRule\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Search\Repository\ScoreRuleRepository $scoreRuleRepository, \Magento\Framework\Registry $registry, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($scoreRuleRepository, $registry, $resultForwardFactory, $context);
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
