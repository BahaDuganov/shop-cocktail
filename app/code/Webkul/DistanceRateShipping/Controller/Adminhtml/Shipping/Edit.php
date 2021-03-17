<?php
/**
 * Webkul DistanceRateShipping Shippingset Edit Controller
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

use Magento\Framework\Controller\ResultFactory;

use Magento\Framework\Locale\Resolver;

class Edit extends \Webkul\DistanceRateShipping\Controller\Adminhtml\Shippingset
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory
     */
    private $drshippingFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry         $coreRegistry
     * @param CollectionFactory                   $drshippingFactory
     * @param RoleFac                             $salesOrderCollectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory $drshippingFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->drshippingFactory = $drshippingFactory;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $id=(int)$this->getRequest()->getParam('id');
        $shippingModel=$this->drshippingFactory->create();
        if ($id) {
            $shippingModel->load($id);
            if (!$shippingModel->getDrshippingId()) {
                $this->messageManager->addError(__('This Shipping rule is no longer exists.'));
                $this->_redirect('mpshipping/*/');
                return;
            }
        }
        $this->coreRegistry->register('drshippingrule_shipping', $shippingModel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Webkul_DistanceRateShipping::distancerateshipping');
        $resultPage->getConfig()->getTitle()->prepend(__('Shipping Rule'));
        $resultPage->addContent(
            $resultPage
            ->getLayout()
            ->createBlock(
                \Webkul\DistanceRateShipping\Block\Adminhtml\ShippingRule\Edit::class
            )
        );
        $resultPage->addLeft(
            $resultPage
            ->getLayout()
            ->createBlock(
                \Webkul\DistanceRateShipping\Block\Adminhtml\ShippingRule\Edit\Tabs::class
            )
        );
          return $resultPage;
    }

    /**
     * check permission
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshipping');
    }
}
