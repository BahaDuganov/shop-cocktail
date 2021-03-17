<?php
/**
 * Webkul DistanceRateShipping Shippingset Edit Controller
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Block\Adminhtml\ShippingRule\Edit;

/**
 * Adminhtml permissions warehouse edit form
 *
 */
/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @return $this
     */
    public function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                            'id' => 'edit_form',
                            'action' => $this->getData('action'),
                            'method' => 'post']
                        ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
