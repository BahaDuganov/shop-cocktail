<?php
namespace Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\SuperBundlingClear;

/**
 * Interceptor class for @see \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\SuperBundlingClear
 */
class Interceptor extends \Amasty\PageSpeedOptimizer\Block\Adminhtml\Settings\SuperBundlingClear implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\PageSpeedOptimizer\Model\Bundle\ResourceModel\CollectionFactory $collectionFactory, \Amasty\PageSpeedOptimizer\Model\ConfigProvider $configProvider, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($collectionFactory, $configProvider, $context, $data);
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
