<?php
namespace Amasty\ExtraFeeGraphQl\Model\Resolver\ApplyExtraFees;

/**
 * Interceptor class for @see \Amasty\ExtraFeeGraphQl\Model\Resolver\ApplyExtraFees
 */
class Interceptor extends \Amasty\ExtraFeeGraphQl\Model\Resolver\ApplyExtraFees implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Extrafee\Api\Data\TotalsInformationInterface $totalsInformation, \Magento\Checkout\Api\Data\TotalsInformationInterface $addressInformation, \Amasty\Extrafee\Api\TotalsInformationManagementInterface $totalsInformationManagement, \Amasty\ExtraFeeGraphQl\Model\Utils\CartProvider $cartProvider, \Amasty\Extrafee\Model\FeeRepository $feeRepository)
    {
        $this->___init();
        parent::__construct($totalsInformation, $addressInformation, $totalsInformationManagement, $cartProvider, $feeRepository);
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
