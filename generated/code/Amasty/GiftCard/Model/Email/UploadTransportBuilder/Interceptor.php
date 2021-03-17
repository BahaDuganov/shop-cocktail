<?php
namespace Amasty\GiftCard\Model\Email\UploadTransportBuilder;

/**
 * Interceptor class for @see \Amasty\GiftCard\Model\Email\UploadTransportBuilder
 */
class Interceptor extends \Amasty\GiftCard\Model\Email\UploadTransportBuilder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Mail\Template\FactoryInterface $templateFactory, \Magento\Framework\Mail\MessageInterface $message, \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Mail\TransportInterfaceFactory $mailTransportFactory, \Magento\Framework\Mail\MessageInterfaceFactory $messageFactory, \Magento\Framework\Filesystem\Driver\File $fileDriver)
    {
        $this->___init();
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory, $messageFactory, $fileDriver);
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($fromAddress, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFrom');
        if (!$pluginInfo) {
            return parent::setFrom($fromAddress, $scopeId);
        } else {
            return $this->___callPlugins('setFrom', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateOptions($templateOptions)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTemplateOptions');
        if (!$pluginInfo) {
            return parent::setTemplateOptions($templateOptions);
        } else {
            return $this->___callPlugins('setTemplateOptions', func_get_args(), $pluginInfo);
        }
    }
}
