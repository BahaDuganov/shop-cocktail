<?php
namespace Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Activate;

/**
 * Interceptor class for @see \Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Activate
 */
class Interceptor extends \Codazon\ThemeLayoutPro\Controller\Adminhtml\Config\Activate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Config\Model\Config\Structure $configStructure, \Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker $sectionChecker, \Magento\Config\Model\Config\Factory $configFactory, \Codazon\ThemeLayoutPro\Model\CodazonTheme $themeModel, \Magento\Framework\Registry $registry, \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry, \Magento\Framework\App\ReinitableConfig $reinitableConfig)
    {
        $this->___init();
        parent::__construct($context, $configStructure, $sectionChecker, $configFactory, $themeModel, $registry, $indexerRegistry, $reinitableConfig);
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
