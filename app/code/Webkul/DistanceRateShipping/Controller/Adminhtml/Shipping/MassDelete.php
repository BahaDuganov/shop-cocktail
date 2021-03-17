<?php
/**
 * DistanceRateShipping Admin Shipping massDelete Controller
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Webkul\DistanceRateShipping\Model\ResourceModel\DistanceRateShipping\CollectionFactory;
use Webkul\DistanceRateShipping\Model\DistanceRateShipping;

/**
 * Class MassDelete is used for shipping rule mass delete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Field id
     */
    const ID_FIELD = 'drshipping_id';

    /**
     * Resource collectionFactory
     *
     * @var string
     */
    protected $collectionFactory;

    /**
     * Resource mpshipping
     *
     * @var string
     */
    protected $drshipping;

    /**
     * @param \Magento\Backend\App\Action\Context                      $context
     * @param CollectionFactory                                        $collectionFactory
     * @param MpsDistanceRateShippinghipping                                       $drshipping
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        DistanceRateShipping $drshipping
    ) {
      
        $this->collectionFactory = $collectionFactory;
        $this->drshipping = $drshipping;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!empty($params['distancerateshipping'])) {
            try {
                $selected = $params['distancerateshipping'];
                $this->selectedDelete($selected, $params);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        } else {
            $this->messageManager->addError(__('Please select item(s).'));
        }
        return $resultRedirect->setPath('distancerateshipping/*/index');
    }

    /**
     * Delete selected items
     *
     * @param array $selected
     * @return void
     * @throws \Exception
     */
    protected function selectedDelete(array $selected, $params)
    {
        /** @var AbstractCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(static::ID_FIELD, ['in' => $selected]);
        $this->setSuccessMessage($this->delete($collection, $params));
    }

    /**
     * Delete collection items
     *
     * @param AbstractCollection $collection
     * @return int
     */
    protected function delete(AbstractCollection $collection, $params)
    {
        $count = 0;
        foreach ($collection->getAllIds() as $id) {
            $model = $this->drshipping->load($id);
            $model->delete();
            ++$count;
        }
        return $count;
    }
    
    /**
     * Set error messages
     *
     * @param int $count
     * @return void
     */
    protected function setSuccessMessage($count)
    {
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $count));
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshipping');
    }
}
