<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\Extrafee\Api\Data\TotalsInformationInterface;
use Amasty\Extrafee\Api\TotalsInformationManagementInterface;
use Amasty\Extrafee\Model\FeeRepository;
use Amasty\ExtraFeeGraphQl\Model\Utils\CartProvider;
use Magento\Checkout\Api\Data\TotalsInformationInterface as CheckoutTotalsInformation;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Phrase;
use Magento\Quote\Model\Quote\Address;

class ApplyExtraFees implements ResolverInterface
{
    const FEE_ID_KEY = 'fee_id';
    const OPTIONS_IDS_KEY = 'options_ids';

    /**
     * @var TotalsInformationInterface
     */
    private $totalsInformation;

    /**
     * @var CheckoutTotalsInformation
     */
    private $addressInformation;

    /**
     * @var TotalsInformationManagementInterface
     */
    private $totalsInformationManagement;

    /**
     * @var CartProvider
     */
    private $cartProvider;

    /**
     * @var FeeRepository
     */
    private $feeRepository;

    public function __construct(
        TotalsInformationInterface $totalsInformation,
        CheckoutTotalsInformation $addressInformation,
        TotalsInformationManagementInterface $totalsInformationManagement,
        CartProvider $cartProvider,
        FeeRepository $feeRepository
    ) {
        $this->totalsInformation = $totalsInformation;
        $this->addressInformation = $addressInformation;
        $this->totalsInformationManagement = $totalsInformationManagement;
        $this->cartProvider = $cartProvider;
        $this->feeRepository = $feeRepository;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return Value|Phrase|mixed
     * @throws GraphQlAuthorizationException
     * @throws GraphQlInputException
     * @throws GraphQlNoSuchEntityException
     * @throws NoSuchEntityException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args[CartProvider::CART_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', CartProvider::CART_ID_KEY));
        }

        if (empty($args[self::FEE_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::FEE_ID_KEY));
        }

        if (!isset($args[self::OPTIONS_IDS_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::OPTIONS_IDS_KEY));
        }

        $cart = $this->cartProvider->getCartForUser($args[CartProvider::CART_ID_KEY], $context);

        $this->prepareAddressInformation($cart->getShippingAddress());
        $this->prepareTotalsInformation($args[self::FEE_ID_KEY], $args[self::OPTIONS_IDS_KEY]);

        $fee = $this->feeRepository->getById($args[self::FEE_ID_KEY]);

        if (!$this->feeRepository->validateAddress($cart, $fee)) {
            return __('Extra fee is not available for your cart.');
        }

        try {
            $this->totalsInformationManagement
                ->calculate($cart->getId(), $this->totalsInformation, $this->addressInformation);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        if (!$args[self::OPTIONS_IDS_KEY]) {
            return __('Extra fee was canceled.');
        }

        return __('Extra fee was applied.');
    }

    /**
     * @param Address $shippingAddress
     * @throws GraphQlInputException
     */
    private function prepareAddressInformation(Address $shippingAddress)
    {
        if (!$shippingAddress->getShippingMethod()) {
            throw new GraphQlInputException(__('Shipping method in your cart does not applied'));
        }

        $this->addressInformation->setAddress($shippingAddress);

        list($carrier, $method) = explode('_', $shippingAddress->getShippingMethod());

        $this->addressInformation->setShippingMethodCode($method);
        $this->addressInformation->setShippingCarrierCode($carrier);
    }

    /**
     * @param int $feeId
     * @param string $optionsIds
     */
    private function prepareTotalsInformation(int $feeId, string $optionsIds)
    {
        $this->totalsInformation->setFeeId($feeId);
        $this->totalsInformation->setOptionsIds(explode(',', $optionsIds));
    }
}
