<?php

/**
 * DistanceRateShipping Admin Shipping Save Controller.
 *
 * @category  Webkul
 * @package   Webkul_DistanceRateShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\DistanceRateShipping\Controller\Adminhtml\Shipping;

use Magento\Backend\App\Action;
use Webkul\DistanceRateShipping\Model\DistanceRateShippingFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var Webkul\DistanceRateShipping\Model\DistanceRateShipping
     */
    protected $_distancerateshipping;
    /**
     * @var Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploader;
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $_csvReader;

    /**
     * @param Action\Context                             $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry                $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        DistanceRateShippingFactory $distancerateshipping,
        UploaderFactory $fileUploader,
        \Magento\Framework\File\Csv $csvReader
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_distancerateshipping = $distancerateshipping;
        $this->_fileUploader = $fileUploader;
        $this->_csvReader = $csvReader;
    }

    /**
     * Check for is allowed.
     *
     * @return bool
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->isPost()) {
            try {
                if (!$this->_formKeyValidator->validate($this->getRequest())) {
                    return $this->resultRedirectFactory->create()->setPath('*/*/index');
                }
                $uploader = $this->_fileUploader->create(
                    ['fileId' => 'import_file']
                );
                $result = $uploader->validateFile();
                $rows = [];
                $file = $result['tmp_name'];
                $fileNameArray = explode('.', $result['name']);
                $ext = end($fileNameArray);
                $status = true;
                $totalSaved = 0;
                $totalUpdated = 0;
                $headerArray = ['distance_from',
                'distance_to','rate'];
                if ($file != '' && $ext == 'csv') {
                    $csvFileData = $this->_csvReader->getData($file);
                    $partnerid = 0;
                    $count = 0;
                    foreach ($csvFileData as $key => $rowData) {
                        if ($count==0) {
                            $this->getCsvFileData($rowData, $count, $headerArray);
                            $count++;
                            $data = $rowData;
                        } else {
                            $wholedata = $this->getForeachData($rowData, $data);
                            list($updatedWholedata, $errors) = $this->validateCsvDataToSave($wholedata);
                            
                            $rowSaved = $this->getUpdateWholeData(
                                $errors,
                                $updatedWholedata,
                                $totalSaved,
                                $totalUpdated
                            );
                                $totalSaved = $rowSaved[0];
                                $totalUpdated = $rowSaved[1];
                        }
                    }
                    $this->getCount($rows, $count, $totalSaved, $totalUpdated);
                    
                    return $this->resultRedirectFactory->create()->setPath('*/*/index');
                } else {
                    $this->messageManager->addError(__('Please upload CSV file'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_DistanceRateShipping::distancerateshipping');
    }

    public function addDataToCollection($temp, $updatedWholedata)
    {
        $updated =0;
        $saved = 0;
        $collection = $this->_distancerateshipping->create()
            ->getCollection()
            ->addFieldToFilter('distance_from', ['lteq' =>$updatedWholedata['distance_from']])
            ->addFieldToFilter('distance_to', ['gteq' =>$updatedWholedata['distance_to']]);
       
        if ($collection->getSize() > 0) {
            ++$updated;
        } else {
            $shippingModel = $this->_distancerateshipping->create();
            $shippingModel->setData($temp)->save();
            ++$saved;
        }
        return [$saved, $updated];
    }

    public function validateCsvDataToSave($wholedata)
    {
        $data = [];
        $errors = [];
        foreach ($wholedata as $key => $value) {

            switch ($key) {
                case 'distance_from':
                    $data[$key] = $this->caseDistanceFrom($value, $key);
                    break;
                case 'distance_to':
                    $data[$key] = $this->caseDistanceTo($value, $key);
                    break;
                case 'rate':
                    if ($value == '') {
                        $errors[] = __('Rate can not be empty');
                    } elseif (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
                        $errors[] = __('Not a valid value for Rate %1', $value);
                    } else {
                        $data[$key] = $value;
                    }
                    break;
            }
        }
        return [$data, $errors];
    }

    /**
     * Get Distance To Data
     *
     * @param  $value  [$value description]
     * @param  $key    [$key description]
     *
     * @return $data   [return description]
     */
    public function caseDistanceTo($value, $key)
    {
        if ($value == '') {
            $errors[] = __('Distance To can not be empty');
        } elseif (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
            $errors[] = __('Not a valid value for distance to field %1', $value);
            if (isset($data['distance_from'])) {
                if ($data['distance_from'] >= $value) {
                    $errors[] = __('Distance to should be greater then distance from field');
                }
            } else {
                $errors[] = __('Distance From can not be empty');
            }
        } else {
            $data[$key] = $value;
        }
        return $data[$key];
    }

    /**
     * Get Distance From Data
     *
     * @param  $value  [$value description]
     * @param  $key    [$key description]
     *
     * @return $data   [return description]
     */
    public function caseDistanceFrom($value, $key)
    {
        if ($value == '') {
            $errors[] = __('Distance From can not be empty');
        } elseif (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
            $errors[] = __('Not a valid value for distance from field %1', $value);
        } else {
            $data[$key] = $value;
        }
        return $data[$key];
    }

    /**
     * Get Count Of Data Save or Update
     *
     * @param $rows          [$rows description]
     * @param $count         [$count description]
     * @param $totalSaved    [$totalSaved description]
     * @param $totalUpdated  [$totalUpdated description]
     */
    public function getCount($rows, $count, $totalSaved, $totalUpdated)
    {
        if (count($rows)) {
            $this->messageManager->addError(
                __(
                    'Following rows are not valid rows : %1',
                    implode(',', $rows)
                )
            );
        }
        if (($count - 1) <= 1) {
            if ($totalSaved) {
                $this->messageManager
                ->addSuccess(
                    __('%1 Row(s) shipping detail has been successfully saved', $totalSaved)
                );
            }
            if ($totalUpdated) {
                $this->messageManager
                ->addNotice(
                    __('%1 Row(s) shipping rule already exist for the given range.', $totalUpdated)
                );
            }
        }
    }

    /**
     * Get Csv File Data
     *
     * @param $rowData          [$rowData description]
     * @param $count            [$count description]
     * @param $headerArray      [$headerArray description]
     */
    public function getCsvFileData($rowData, $count, $headerArray)
    {
        if (count($rowData) < 3) {
            $this->messageManager->addError(__('CSV file is not a valid file!'));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        } else {
            $status =($headerArray === $rowData);
            if (!$status) {
                $this->messageManager->addError(__('Please write the correct header formation of CSV file!'));
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
        }
    }

    /**
     * Get Update Data
     *
     * @param $errors            [$errors description]
     * @param $updatedWholedata  [$updatedWholedata description]
     * @param $totalSaved        [$totalSaved description]
     * @param $totalUpdated      [$totalUpdated description]
     *
     * @return                   [$wholedata description]
     */
    public function getUpdateWholeData($errors, $updatedWholedata, $totalSaved, $totalUpdated)
    {
        if (empty($errors)) {
            $temp = [
            'distance_from' => $updatedWholedata['distance_from'],
            'distance_to' => $updatedWholedata['distance_to'],
            'rate' => $updatedWholedata['rate'],
            ];
            list($saved, $updated) = $this->
            addDataToCollection($temp, $updatedWholedata);
            $totalSaved += $saved;
            $totalUpdated += $updated;
        } else {
            $rows[] = $key.':'.$errors[0];
        }
        return [$totalSaved, $totalUpdated];
    }

    /**
     * Get Data by Foreach loop
     *
     * @param $rowData   [$row description]
     * @param $data      [$data description]
     *
     * @return       [$wholedata description]
     */
    public function getForeachData($rowData, $data)
    {
        foreach ($rowData as $filekey => $filevalue) {
            $wholedata[$data[$filekey]] = $filevalue;
        }
        return $wholedata;
    }
}
