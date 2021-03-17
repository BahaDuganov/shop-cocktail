<?php
namespace Amasty\Xsearch\Block\Search\Landing;

/**
 * Interceptor class for @see \Amasty\Xsearch\Block\Search\Landing
 */
class Interceptor extends \Amasty\Xsearch\Block\Search\Landing implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Amasty\Xsearch\Helper\Data $xSearchHelper, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Search\Model\QueryFactory $queryFactory, \Magento\Framework\Registry $coreRegistry, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $xSearchHelper, $string, $queryFactory, $coreRegistry, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getResults()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResults');
        if (!$pluginInfo) {
            return parent::getResults();
        } else {
            return $this->___callPlugins('getResults', func_get_args(), $pluginInfo);
        }
    }
}
