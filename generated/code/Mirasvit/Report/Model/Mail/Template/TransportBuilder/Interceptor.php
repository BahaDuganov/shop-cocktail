<?php
namespace Mirasvit\Report\Model\Mail\Template\TransportBuilder;

/**
 * Interceptor class for @see \Mirasvit\Report\Model\Mail\Template\TransportBuilder
 */
class Interceptor extends \Mirasvit\Report\Model\Mail\Template\TransportBuilder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Mail\Template\FactoryInterface $templateFactory, \Magento\Framework\Mail\MessageInterface $message, \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Mail\TransportInterfaceFactory $mailTransportFactory, \Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Framework\Module\Manager $moduleManager, ?\Magento\Framework\Mail\MessageInterfaceFactory $messageFactory = null, $emailMessageInterfaceFactory = null, $mimeMessageInterfaceFactory = null, $mimePartInterfaceFactory = null, $addressConverter = null)
    {
        $this->___init();
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory, $productMetadata, $moduleManager, $messageFactory, $emailMessageInterfaceFactory, $mimeMessageInterfaceFactory, $mimePartInterfaceFactory, $addressConverter);
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($from)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFrom');
        if (!$pluginInfo) {
            return parent::setFrom($from);
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
