<?php
namespace Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Save;

/**
 * Interceptor class for @see \Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Save
 */
class Interceptor extends \Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Codazon\ThemeLayoutPro\Model\Config\Structure $configStructure, \Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker $sectionChecker, \Codazon\ThemeLayoutPro\Model\Config\Factory $configFactory, \Magento\Framework\Cache\FrontendInterface $cache, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Theme\Model\ThemeFactory $themeFactory, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $configStructure, $sectionChecker, $configFactory, $cache, $string, $themeFactory, $registry);
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
