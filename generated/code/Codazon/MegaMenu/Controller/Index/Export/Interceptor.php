<?php
namespace Codazon\MegaMenu\Controller\Index\Export;

/**
 * Interceptor class for @see \Codazon\MegaMenu\Controller\Index\Export
 */
class Interceptor extends \Codazon\MegaMenu\Controller\Index\Export implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Setup\SampleData\FixtureManager $fixtureManager, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\File\Csv $csv, \Codazon\MegaMenu\Model\MegamenuFactory $menuFactory)
    {
        $this->___init();
        parent::__construct($context, $fixtureManager, $resultForwardFactory, $csv, $menuFactory);
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
