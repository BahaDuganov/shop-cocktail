<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aislend\Instruction\Controller\Index;

use Magento\Quote\Model\Quote\ItemFactory;

class AdditionalOptions extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Model\QuoteRepository $quoteRepo
    )
    {
        $this->_quoteRepo = $quoteRepo;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
		if($this->getRequest()->getParam('pageload') !== null && $this->getRequest()->getParam('pageload') == 1):
			$quoteid = $this->getRequest()->getParam('quoteid');
			$quote = $this->_quoteRepo->get($quoteid);	
			$itemid = $this->getRequest()->getParam('itemid');
			$dataValue = 1;			
			$itemids = explode(",",$itemid);
			$data = 'substitue';
			foreach($itemids as $eachId):
				foreach($quote->getAllVisibleItems() as $itemq):		
					if($itemq->getItemId() == $eachId):
						$buyRequest = !empty($itemq->getOptionByCode('info_buyRequest'))
						? ($itemq->getOptionByCode('info_buyRequest')->getValue())
						: null;						
						$buyRequest = json_decode($buyRequest);

						if(isset($buyRequest->$data))
						{
							$dataValue = $buyRequest->$data;
						}
						$buyRequest->$data = $dataValue;
						$buyRequest = json_encode($buyRequest);			
						$itemq->addOption(array(
							'code' => 'info_buyRequest',
							'value' => $buyRequest
						));
					endif;			
					$itemq->saveItemOptions();
					$result = ['status' => 'success', 'msg'=>'Customers can opt for replacements in case an item is out of stock. We will choose a replacement item that is comparable to the original based on brand, flavor, size and price. You will be notified of replacements and will have the opportunity to approve the replacement or request a refund for the item.'];				
				endforeach;
			endforeach;			
		else:
			$quoteid = $this->getRequest()->getParam('quoteid');
			$itemid = $this->getRequest()->getParam('itemid');
			if(!$quoteid || !$itemid):
				$result = ['status' => 'error', 'msg'=>'Something went wrong'];
				return $this->getResponse()->representJson(
					$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
				);
			endif;
			$quote = $this->_quoteRepo->get($quoteid);			
			if($this->getRequest()->getParam('action') == 'add'):
				$data = '';
				$msg = '';
				if($this->getRequest()->getParam('substitue') != ''):
					$data = 'substitue';
					$dataValue = $this->getRequest()->getParam('substitue');
					if($dataValue == 1):
						$msg = 'Substitute Allowed';
					else:
						$msg = 'Substitute Not Allowed';
					endif;
					
				elseif($this->getRequest()->getParam('instruction') != '') :
					$data = 'instruction';
					$dataValue = $this->getRequest()->getParam('instruction');
					$msg = 'Instruction Added';
				endif;
				foreach($quote->getAllVisibleItems() as $itemq):		
					if($itemq->getItemId() == $itemid):
						$buyRequest = !empty($itemq->getOptionByCode('info_buyRequest'))
						? ($itemq->getOptionByCode('info_buyRequest')->getValue())
						: null;
						$buyRequest = json_decode($buyRequest);
						$buyRequest->$data = $dataValue;
						$buyRequest = json_encode($buyRequest);			
						$itemq->addOption(array(
							'code' => 'info_buyRequest',
							'value' => $buyRequest
						));
					endif;			
					$itemq->saveItemOptions();
					$result = ['status' => 'success', 'msg'=>$msg];				
				endforeach;			
			elseif($this->getRequest()->getParam('action') == 'remove'):
				foreach($quote->getAllVisibleItems() as $itemq):		
					if($itemq->getItemId() == $itemid):
						$buyRequest = !empty($itemq->getOptionByCode('info_buyRequest'))
						? ($itemq->getOptionByCode('info_buyRequest')->getValue())
						: null;
						$buyRequest = json_decode($buyRequest);					
						unset($buyRequest->instruction);
						$buyRequest = json_encode($buyRequest);	
						$itemq->addOption(array(
							'code' => 'info_buyRequest',
							'value' => $buyRequest
						));
					endif;			
					$itemq->saveItemOptions();
					$result = ['status' => 'error', 'msg'=>'Instruction Removed'];
				endforeach;
			endif;				
		endif;
		
		
		return $this->getResponse()->representJson(
			$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
		);			
		
    }
}
?>
