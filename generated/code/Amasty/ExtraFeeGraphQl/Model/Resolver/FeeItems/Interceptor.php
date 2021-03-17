<?php
namespace Amasty\ExtraFeeGraphQl\Model\Resolver\FeeItems;

/**
 * Interceptor class for @see \Amasty\ExtraFeeGraphQl\Model\Resolver\FeeItems
 */
class Interceptor extends \Amasty\ExtraFeeGraphQl\Model\Resolver\FeeItems implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Extrafee\Model\ResourceModel\Fee\CollectionFactory $feeCollectionFactory)
    {
        $this->___init();
        parent::__construct($feeCollectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        if (!$pluginInfo) {
            return parent::resolve($field, $context, $info, $value, $args);
        } else {
            return $this->___callPlugins('resolve', func_get_args(), $pluginInfo);
        }
    }
}
