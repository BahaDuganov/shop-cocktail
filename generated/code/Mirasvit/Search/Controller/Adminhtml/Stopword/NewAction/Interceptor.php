<?php
namespace Mirasvit\Search\Controller\Adminhtml\Stopword\NewAction;

/**
 * Interceptor class for @see \Mirasvit\Search\Controller\Adminhtml\Stopword\NewAction
 */
class Interceptor extends \Mirasvit\Search\Controller\Adminhtml\Stopword\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Search\Repository\StopwordRepository $stopwordRepository, \Mirasvit\Search\Service\StopwordService $stopwordService, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($stopwordRepository, $stopwordService, $context);
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
