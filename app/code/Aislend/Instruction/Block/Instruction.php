<?php
namespace Aislend\Instruction\Block;

class Instruction extends \Magento\Framework\View\Element\Template
{
	private $_objectManager;
	
	protected $quoteRepository;
	
	/**
     * @var Registry
     */
    protected $registry;
	
	/**
     * @var Product
     */
    private $product;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectmanager,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Quote\Model\QuoteRepository $quoteRepository,
		\Magento\Framework\Registry $registry		
	)
	{
		$this->_objectManager = $objectmanager;
		$this->checkoutSession = $checkoutSession;
		$this->quoteRepository = $quoteRepository;
		$this->registry = $registry;
		parent::__construct($context);
	}
	
	public function getQuoteId()
	{
		return $this->checkoutSession->getQuoteId();
	}
	
	public function getCurrentProductId()
	{
		$product = $this->registry->registry('product');
		return $product->getId();
	}
	
	public function getQuoteItems($quoteId)
    {
         try {
			 $product = $this->registry->registry('product');				
             $quote = $this->quoteRepository->get($quoteId);
             $items = $quote->getAllItems();
             return $items;
         } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
             return [];
         }
    }
	
	public function getItemDetails()
	{
		$quoteId = $this->getQuoteId();
		if(!$quoteId):
			return false;
		endif;
		
		$items = $this->getQuoteItems($quoteId);
		foreach($items as $item):
			echo $item->getProductId();
		endforeach;		
		return ;
	}
	
	public function getItemId()
	{
		$productId = $this->getCurrentProductId();
		
		$quoteId = $this->getQuoteId();
		if(!$quoteId):
			return false;
		endif;
		
		$items = $this->getQuoteItems($quoteId);
		$itemId = array();
		if(count($items) > 0) :
			foreach($items as $item):				
				if($productId == $item->getProductId()):
					$itemId = $item->getItemId();
				endif;
			endforeach;	
		endif;
			
		return $itemId;
	}
	
	public function isEnable()
	{
		$productId = $this->getCurrentProductId();
		
		$quoteId = $this->getQuoteId();
		if(!$quoteId):
			return false;
		endif;
		
		$items = $this->getQuoteItems($quoteId);
		$itemId = array();
		if(count($items) > 0) :
			foreach($items as $item):
				$itemId[] = $item->getProductId();
			endforeach;	
		endif;
		
		if(count($itemId) == 0):
			return false;
		endif;
		
		$status = (in_array($productId , $itemId)) ? 1 : 0;		
		return $status;
	}
	
	
}

?>