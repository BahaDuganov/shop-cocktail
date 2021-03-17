<?php
/**
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Block\Adminhtml\ShippingRule\Edit\Tab;

/**
 * Cms page edit form main tab
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Escaper $escaper,
        array $data = []
    ) {
        $this->escaper = $escaper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return \Magento\Backend\Block\Widget\Form
     */
    public function _prepareForm()
    {
        $shippingModel = $this->_coreRegistry->registry('drshippingrule_shipping');
       
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $baseFieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Shipping Rule Information')]
        );
        $data= $shippingModel->getData();

        if ($shippingModel->getDrshippingId()) {
            $baseFieldset->addField(
                'drshipping_id',
                'hidden',
                ['name' => 'drshipping_id']
            );
        }

        $baseFieldset->addField(
            'distance_from',
            'text',
            [
                'name' => 'distance_from',
                'label' => __('Distance from'),
                'id' => 'distance_from',
                'title' => __('Distance from'),
                'class' => 'required-entry validate-number validate-zero-or-greater',
                'required' => true
            ]
        );

        $baseFieldset->addField(
            'distance_to',
            'text',
            [
                'name' => 'distance_to',
                'label' => __('Distance To'),
                'id' => 'distance_to',
                'title' => __('Distance To'),
                'class' => 'required-entry validate-not-negative-number',
                'required' => true
            ]
        );

        $baseFieldset->addField(
            'rate',
            'text',
            [
                'name' => 'rate',
                'label' => __('Rate'),
                'id' => 'wk_range',
                'title' => __('Shipping Rate'),
                'class' => 'required-entry validate-not-negative-number',
                'style' => 'border-width: 1px',
                'required' => true
            ]
        );
       
        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
