<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GiftCard
 */

declare(strict_types=1);

namespace Amasty\GiftCard\Block\Checkout\Cart\Item;

use Amasty\GiftCard\Helper\Catalog\Product\Configuration;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;

class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    /**
     * @var Configuration
     */
    private $giftCardConfiguration;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Product\Configuration $productConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Module\Manager $moduleManager,
        InterpretationStrategyInterface $messageInterpretationStrategy,
        Configuration $giftCardConfiguration,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $productConfig,
            $checkoutSession,
            $imageBuilder,
            $urlHelper,
            $messageManager,
            $priceCurrency,
            $moduleManager,
            $messageInterpretationStrategy,
            $data
        );
        $this->giftCardConfiguration = $giftCardConfiguration;
    }

    /**
     * @return array
     */
    public function getOptionList()
    {
        return $this->giftCardConfiguration->getOptions($this->getItem());
    }
}
