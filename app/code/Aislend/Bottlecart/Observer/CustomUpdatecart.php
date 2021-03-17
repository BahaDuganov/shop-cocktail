<?php
    /**
     * Aislend bottol product add to cart Observer
     *
     * @category    Aislend
     * @package     Aislend_Bottlecart
     * @author      Aislend
     *
     */
    namespace Aislend\Bottlecart\Observer;
 
    use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\App\RequestInterface;
	use Magento\Framework\Controller\ResultFactory;
 
    class CustomUpdatecart implements ObserverInterface
    {
        protected $_productloader;
		protected $formKey;   
		protected $cart;
		protected $product;
		protected $redirect;
		
		public function __construct(
        \Magento\Catalog\Model\ProductFactory $_productloader,
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Data\Form\FormKey $formKey,
		\Magento\Checkout\Model\Cart $cart,
		\Magento\Catalog\Api\ProductRepositoryInterface $product,
		\Magento\Framework\App\Response\RedirectInterface $redirect,
		array $data = []) {
			$this->_productloader = $_productloader;
			$this->formKey = $formKey;
			$this->cart = $cart;
			$this->product = $product;
			$this->redirect = $redirect;			
			//parent::__construct($context);
		}
		
		public function execute(\Magento\Framework\Event\Observer $observer) {
			$redirectUrl = $this->redirect->getRedirectUrl();
			
			$items = $this->cart->getQuote()->getAllItems();
			$totalbottle = 0;
			foreach($items as $item) {
				$cartproductId = $item->getProductId();
				$itemId = $item->getItemId();
				$bottleproduct = $this->_productloader->create()->load($cartproductId);

				if($bottleproduct->getBottleDeposit()){
					$bottleqty = $bottleproduct->getBottleQuantity();
					$productqty = $item->getQty();
					$total = $bottleqty*$productqty;
					$totalbottle = $totalbottle + $total;
				}
				if($item->getSku() == 'bottle_deposit_tax'){
					$bottleItemId = $itemId;
					$this->cart->removeItem($bottleItemId);
				}
			}
			
			$qty = $totalbottle;
						
			$sku = 'bottle_deposit_tax';
			$_product = $this->product->get($sku);
			$productId = $_product->getId();
			
			$params = array(
						'form_key' => $this->formKey->getFormKey(),
						'product' => $productId, //product Id
						'qty'   => $qty //quantity of product                
					); 
					
			if($qty >0){
				$this->cart->addProduct($_product, $params);
			}
			
			$this->cart->save();
			
        }
		
    }