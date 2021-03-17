<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GiftCard
 */

declare(strict_types=1);

namespace Amasty\GiftCard\Model\Config\Source;

class EmailTemplate extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    const DEFAULT_EMAIL_TEMPLATE = 'amgiftcard_email_email_template';
    /**
     * @var \Magento\Config\Model\Config\Source\Email\Template
     */
    private $templates;

    public function __construct(
        \Magento\Config\Model\Config\Source\Email\Template $templates
    ) {
        $this->templates = $templates;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $this->templates->setPath(self::DEFAULT_EMAIL_TEMPLATE);

        return $this->templates->toOptionArray();
    }
}
