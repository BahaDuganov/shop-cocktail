<?php
namespace Magestore\Sociallogin\Block\Adminhtml\System\Config\Clavidredirecturl;

/**
 * Interceptor class for @see \Magestore\Sociallogin\Block\Adminhtml\System\Config\Clavidredirecturl
 */
class Interceptor extends \Magestore\Sociallogin\Block\Adminhtml\System\Config\Clavidredirecturl implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magestore\Sociallogin\Helper\Data $Datahelper, \Magento\Framework\Session\SessionManagerInterface $session, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $Datahelper, $session, $data);
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
