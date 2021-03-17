<?php
namespace Mofluid\Mofluidapi2\Controller\Index\Index;

/**
 * Interceptor class for @see \Mofluid\Mofluidapi2\Controller\Index\Index
 */
class Interceptor extends \Mofluid\Mofluidapi2\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Mofluid\Mofluidapi2\Model\Catalog\Product $Mproduct, \Mofluid\Mofluidapi2\Model\Index $Mauthentication, \Mofluid\Mofluidapi2\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $Mproduct, $Mauthentication, $helper);
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
