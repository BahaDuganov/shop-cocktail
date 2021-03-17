<?php
namespace Mirasvit\SearchAutocomplete\Block\Adminhtml\Config\Form\Field\Indexes;

/**
 * Interceptor class for @see \Mirasvit\SearchAutocomplete\Block\Adminhtml\Config\Form\Field\Indexes
 */
class Interceptor extends \Mirasvit\SearchAutocomplete\Block\Adminhtml\Config\Form\Field\Indexes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\SearchAutocomplete\Model\IndexProvider $indexProvider, \Magento\Backend\Block\Template\Context $context)
    {
        $this->___init();
        parent::__construct($indexProvider, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element) : string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
