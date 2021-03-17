<?php
namespace Amasty\GiftCard\Model\Config\Attribute\Backend\UseConfig\EmailTemplate;

/**
 * Interceptor class for @see \Amasty\GiftCard\Model\Config\Attribute\Backend\UseConfig\EmailTemplate
 */
class Interceptor extends \Amasty\GiftCard\Model\Config\Attribute\Backend\UseConfig\EmailTemplate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\GiftCard\Model\ConfigProvider $configProvider)
    {
        $this->___init();
        parent::__construct($configProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validate');
        if (!$pluginInfo) {
            return parent::validate($object);
        } else {
            return $this->___callPlugins('validate', func_get_args(), $pluginInfo);
        }
    }
}
