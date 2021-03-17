<?php
namespace Mirasvit\Core\Controller\Lc\Index;

/**
 * Interceptor class for @see \Mirasvit\Core\Controller\Lc\Index
 */
class Interceptor extends \Mirasvit\Core\Controller\Lc\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Core\Service\PackageService $packageService, \Mirasvit\Core\Model\LicenseFactory $licenseFactory, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($packageService, $licenseFactory, $context);
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
