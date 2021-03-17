<?php

namespace Freento\Progressbar\Block;

use Freento\Progressbar\Model\Config\Source\BasedOn;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Progressbar extends \Magento\Framework\View\Element\Template
{
    const XML_PATH_THRESHOLD = 'freento_progress_bar/general/threshold';

    const XML_PATH_ENABLE = 'freento_progress_bar/general/enabled';

    const XML_PATH_BASED_ON = 'freento_progress_bar/general/based_on';

    const XML_PATH_PROGRESSBAR_TEXT = 'freento_progress_bar/general/text';

    /**
     * @var SessionManagerInterface
     */
    private $checkoutSession;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Progressbar constructor
     *
     * @param Template\Context $context
     * @param SessionManagerInterface $checkoutSession
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        SessionManagerInterface $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Returns configuration field threshold
     *
     * @return float
     */
    public function getThreshold()
    {
        return (float)$this->scopeConfig->getValue(
            self::XML_PATH_THRESHOLD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Checks if the progress bar is on and the total in the cart is greater than 0
     *
     * @return boolean
     */
    public function isEnable()
    {
        $enable = (boolean)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return $enable;
    }

    /**
     * Returns configuration field based_on
     *
     * @return string
     */
    public function getBasedOn()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_BASED_ON,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Prepare text from configuration field
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProgressbarText()
    {
        $currencySymbol = $this->_storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol();
        $str = ["{{sum_spend}}", "{{sum_left}}"];
        $text = $this->scopeConfig->getValue(
            self::XML_PATH_PROGRESSBAR_TEXT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $sum = [];
        $sum[] = $currencySymbol . round($this->getSubtotal(), 2);
        $sum[] = $currencySymbol . round(bcsub($this->getThreshold(), $this->getSubtotal(), 2), 2);

        return str_replace($str, $sum, $text);
    }

    /**
     * Returns card subtotal based on the settings
     *
     * @return float
     */
    public function getSubtotal()
    {
        $total = 0;

        switch ($this->getBasedOn()) {
            case BasedOn::SUBTOTAL:
                $total = $this->checkoutSession->getQuote()->getBaseSubtotal();
                break;

            case BasedOn::SUBTOTAL_DISCOUNT:
                $total = $this->checkoutSession->getQuote()->getSubtotalWithDiscount();
                break;
        }

        return $total;
    }

    /**
     * Calculates the percentage of filling the progress bar
     *
     * @return float
     */
    public function getPercent()
    {
        if ($this->getThreshold() > 0) {
            return $this->getSubtotal() / $this->getThreshold() * 100;
        }

        return 0;
    }

    /**
     * Checks if all conditions are set
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isConfigured()
    {
        return $this->isEnable()
            && $this->getThreshold() > 0
            && !empty($this->getProgressbarText())
            && ($this->getSubtotal() > 0)
            && ($this->getPercent() < 100);
    }
}
