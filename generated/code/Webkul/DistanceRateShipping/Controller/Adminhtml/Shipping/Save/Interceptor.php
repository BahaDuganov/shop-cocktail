<?php
namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Save;

/**
 * Interceptor class for @see \Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Save
 */
class Interceptor extends \Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $distancerateshipping, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader, \Magento\Framework\File\Csv $csvReader)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $distancerateshipping, $fileUploader, $csvReader);
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
