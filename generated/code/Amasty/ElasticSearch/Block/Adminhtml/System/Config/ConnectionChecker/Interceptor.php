<?php
namespace Amasty\ElasticSearch\Block\Adminhtml\System\Config\ConnectionChecker;

/**
 * Interceptor class for @see \Amasty\ElasticSearch\Block\Adminhtml\System\Config\ConnectionChecker
 */
class Interceptor extends \Amasty\ElasticSearch\Block\Adminhtml\System\Config\ConnectionChecker implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Json\EncoderInterface $jsonEncoder, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $jsonEncoder, $data);
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
