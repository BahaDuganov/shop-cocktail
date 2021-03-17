<?php
namespace Magento\Theme\Block\Html\Header\Logo;

/**
 * Interceptor class for @see \Magento\Theme\Block\Html\Header\Logo
 */
class Interceptor extends \Magento\Theme\Block\Html\Header\Logo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $fileStorageHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function isHomePage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isHomePage');
        if (!$pluginInfo) {
            return parent::isHomePage();
        } else {
            return $this->___callPlugins('isHomePage', func_get_args(), $pluginInfo);
        }
    }
}
