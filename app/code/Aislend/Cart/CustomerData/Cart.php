<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aislend\Cart\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

/**
 * Cart source
 */
class Cart extends \Magento\Checkout\CustomerData\Cart
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $checkoutCart;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Url
     */
    protected $catalogUrl;

    /**
     * @var \Magento\Quote\Model\Quote|null
     */
    protected $quote = null;

    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var ItemPoolInterface
     */
    protected $itemPoolInterface;

    /**
     * @var int|float
     */
    protected $summeryCount;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

	
    
    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
		
        $totals = $this->getQuote()->getTotals();
        $subtotalAmount = $totals['subtotal']->getValue();
		
		$discount = $this->getQuote()->getShippingAddress()->getData();
		
		if(isset($discount['discount_amount']) && $discount['discount_amount'] != 0):
			$discountTotal = $this->checkoutHelper->formatPrice($discount['discount_amount']);			
		else:
			$discountTotal = '';
		endif;
		
        return [
            'summary_count' => $this->getSummaryCount(),
            'subtotalAmount' => $subtotalAmount,
			'discount'=> $discountTotal ,
            'subtotal' => isset($totals['subtotal'])
                ? $this->checkoutHelper->formatPrice($subtotalAmount)
                : 0,
            'possible_onepage_checkout' => $this->isPossibleOnepageCheckout(),
            'items' => $this->getRecentItems(),
            'extra_actions' => $this->layout->createBlock(\Magento\Catalog\Block\ShortcutButtons::class)->toHtml(),
            'isGuestCheckoutAllowed' => $this->isGuestCheckoutAllowed(),
            'website_id' => $this->getQuote()->getStore()->getWebsiteId()
        ];
    }

}
