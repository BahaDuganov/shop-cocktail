<?php
namespace Klarna\Kp\Model\Api\Request\Builder;

/**
 * Interceptor class for @see \Klarna\Kp\Model\Api\Request\Builder
 */
class Interceptor extends \Klarna\Kp\Model\Api\Request\Builder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Klarna\Kp\Model\Api\RequestFactory $requestFactory, \Klarna\Kp\Model\Api\Request\AddressFactory $addressFactory, \Klarna\Kp\Model\Api\Request\AttachmentFactory $attachmentFactory, \Klarna\Kp\Model\Api\Request\CustomerFactory $customerFactory, \Klarna\Kp\Model\Api\Request\MerchantUrlsFactory $urlFactory, \Klarna\Kp\Model\Api\Request\OptionsFactory $optionsFactory, \Klarna\Kp\Model\Api\Request\OrderlineFactory $orderlineFactory)
    {
        $this->___init();
        parent::__construct($requestFactory, $addressFactory, $attachmentFactory, $customerFactory, $urlFactory, $optionsFactory, $orderlineFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function addOrderlines($data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addOrderlines');
        if (!$pluginInfo) {
            return parent::addOrderlines($data);
        } else {
            return $this->___callPlugins('addOrderlines', func_get_args(), $pluginInfo);
        }
    }
}
