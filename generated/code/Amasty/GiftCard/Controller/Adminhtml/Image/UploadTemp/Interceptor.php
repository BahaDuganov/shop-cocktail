<?php
namespace Amasty\GiftCard\Controller\Adminhtml\Image\UploadTemp;

/**
 * Interceptor class for @see \Amasty\GiftCard\Controller\Adminhtml\Image\UploadTemp
 */
class Interceptor extends \Amasty\GiftCard\Controller\Adminhtml\Image\UploadTemp implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GiftCard\Utils\FileUpload $fileUpload)
    {
        $this->___init();
        parent::__construct($context, $fileUpload);
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
