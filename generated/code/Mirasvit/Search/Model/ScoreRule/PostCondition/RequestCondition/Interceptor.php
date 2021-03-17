<?php
namespace Mirasvit\Search\Model\ScoreRule\PostCondition\RequestCondition;

/**
 * Interceptor class for @see \Mirasvit\Search\Model\ScoreRule\PostCondition\RequestCondition
 */
class Interceptor extends \Mirasvit\Search\Model\ScoreRule\PostCondition\RequestCondition implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Rule\Model\Condition\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getValueParsed()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getValueParsed');
        if (!$pluginInfo) {
            return parent::getValueParsed();
        } else {
            return $this->___callPlugins('getValueParsed', func_get_args(), $pluginInfo);
        }
    }
}
