<?php
namespace Mageplaza\SocialLogin\Block\System\RedirectUrl;

/**
 * Interceptor class for @see \Mageplaza\SocialLogin\Block\System\RedirectUrl
 */
class Interceptor extends \Mageplaza\SocialLogin\Block\System\RedirectUrl implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Mageplaza\SocialLogin\Helper\Social $socialHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $socialHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
