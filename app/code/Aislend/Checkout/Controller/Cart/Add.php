<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
 
namespace Aislend\Checkout\Controller\Cart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Add extends \Magento\Checkout\Controller\Cart
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param CustomerCart $cart
     * @param ProductRepositoryInterface $productRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        CustomerCart $cart,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
        $this->productRepository = $productRepository;
    }

    /**
     * Initialize product instance from request data
     *
     * @return \Magento\Catalog\Model\Product|false
     */
    protected function _initProduct()
    {
        $productId = (int)$this->getRequest()->getParam('product');
        if ($productId) {
            $storeId = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getId();
            try {
                return $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }
	
	public function deleteQuoteItems($productId= null){		
	
    $checkoutSession = $this->getCheckoutSession();
    $allItems = $checkoutSession->getQuote()->getAllVisibleItems();//returns all teh items in session
    foreach ($allItems as $item) {		
        $itemId = $item->getItemId();//item id of particular item		
		if($item->getProductId() == $productId):
			$quoteItem=$this->getItemModel()->load($itemId);//load particular item which you want to delete by his item id
			$this->cart->removeItem($itemId)->save();
			/* $quoteItem->delete(); */
			$result = ['success' => __('You have added maximum sale item quantity!')];
							return $this->getResponse()->representJson(
								$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
							);			
			return $result;
			
		endif;       
    }
	}
	public function getCheckoutSession(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager 
		$checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');//checkout session
		return $checkoutSession;
	}
	 
	public function getItemModel(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager
		$itemModel = $objectManager->create('Magento\Quote\Model\Quote\Item');//Quote item model to load quote item
		return $itemModel;
	}

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $params = $this->getRequest()->getParams();		
		if(isset($params['deduct'])){
        	try{
        		$product = $this->_initProduct();
				if($product->getTypeId() == 'configurable'):

					$checkoutSession = $this->getCheckoutSession();
					$allItems = $checkoutSession->getQuote()->getAllVisibleItems();
					$removeItemAttribute = $params['super_attribute'];
					$temp = 0;
					foreach($removeItemAttribute as $key => $value):
						if($value == ''):
							$temp = 1;
						endif;
					endforeach;
					$array = array();
					$deleteItemId = '';
					
					if($temp == 0):
						foreach ($allItems as $item) :
							if($item->getOptionByCode('attributes')):
								$attributes = $item->getOptionByCode('attributes')->getValue();						
								$array = json_decode($attributes);
								foreach($array as $key  => $val):
									if($removeItemAttribute[$key] == $val):									
										$temp = 2;	
										$deleteItemId = $item->getOptionByCode('attributes')->getItemId();
										$qty = $item->getQty();									
									endif;
								endforeach;	
							endif;
						endforeach;						
					endif;
					
					switch ($temp){
						case 0:
							$message = __(
											'This product (%1) is not in cart.',
											$product->getName()
										);
							break;
							
						case 1:
							$message = __(
											'You need to choose options for your item.',
											$product->getName()
										);
							break;
						case 2:
							$product = $this->_initProduct();
							$deductQty = ($qty > 1) ? $item->getQty() - 1 : 0;							
							$itemData = [$deleteItemId => ['qty' => $deductQty]];							
							$this->cart->updateItems($itemData)->save();											
							$message = __(
								'You have removed %1 from your shopping cart.',
								$product->getName()
							);
							break;						
													
					}	
					$this->messageManager->addError($message);
									
				else:				
					if(
						($quoteItem = $this->cart->getQuote()->getItemByProduct($product)) && $quoteItem->getQty() && ($itemId = $quoteItem->getItemId()) && !(in_array('options',$params))){					
						unset($params['deduct']);
						
						if(is_float($quoteItem->getQty()) && $quoteItem->getQty() > .25):
							$itemQty =  $quoteItem->getQty() - .25;
						elseif(is_float($quoteItem->getQty()) && $quoteItem->getQty() <= .25):
							$itemQty =  0;
						else:
							$itemQty =  $quoteItem->getQty() - 1;
						endif;

						$itemData = [$itemId => ['qty' => $itemQty]];
						$this->cart->updateItems($itemData)->save();
						
						$this->_eventManager->dispatch(
							'checkout_cart_update_item_complete',
							['item' => $quoteItem, 'request' => $this->getRequest(), 'response' => $this->getResponse()]
						);
					
						if (!$this->_checkoutSession->getNoCartRedirect(true)) {
							if (!$this->cart->getQuote()->getHasError()) {
								$message = __(
									'You have removed %1 from your shopping cart.',
									$product->getName()
								);
								$this->messageManager->addError($message);
							}
						}
					}
				endif;
				
				if(isset($params['options']))
				{
					$productId = $params['product'];
					$this->deleteQuoteItems($productId);
					if (!$this->_checkoutSession->getNoCartRedirect(true)) {
		                if (!$this->cart->getQuote()->getHasError()) {
		                    $message = __(
		                        'You have removed %1 from your shopping cart.',
		                        $product->getName()
		                    );
		                    $this->messageManager->addError($message);
		                }
		            }	
					
				}
        		return $this->goBack(null, $product);
	        } catch (\Magento\Framework\Exception\LocalizedException $e) {
				echo $e->getMessage();
	            if ($this->_checkoutSession->getUseNotice(true)) {
	                $this->messageManager->addNotice(
	                    $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($e->getMessage())
	                );
	            } else {
					echo $e->getMessage();
	                $messages = array_unique(explode("\n", $e->getMessage()));
	                foreach ($messages as $message) {
	                    $this->messageManager->addError(
	                        $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($message)
	                    );
	                }
	            }

	            $url = $this->_checkoutSession->getRedirectUrl(true);

	            if (!$url) {
	                $cartUrl = $this->_objectManager->get('Magento\Checkout\Helper\Cart')->getCartUrl();
	                $url = $this->_redirect->getRedirectUrl($cartUrl);
	            }

	            return $this->goBack($url);

	        } catch (\Exception $e) {
				echo $e->getMessage();
	            $this->messageManager->addException($e, __('We can\'t deduct this item to your shopping cart right now.'));
	            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
	            return $this->goBack();
	        }
        }else{

        try {
            if (isset($params['qty'])) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_objectManager->get('Magento\Framework\Locale\ResolverInterface')->getLocale()]
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                return $this->goBack();
            }
			
			if ($this->isProductInventory($product) != 0) {  
						$result = ['error' => __('You have added maximum sale item quantity!')];
							return $this->getResponse()->representJson(
								$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
							);			
				return $result;								
            }
			
            $this->cart->addProduct($product, $params);
            if (!empty($related)) {
                $this->cart->addProductsByIds(explode(',', $related));
            }

            $this->cart->save();

            /**
             * @todo remove wishlist observer \Magento\Wishlist\Observer\AddToCart
             */
            $this->_eventManager->dispatch(
                'checkout_cart_add_product_complete',
                ['product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse()]
            );

            if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                if (!$this->cart->getQuote()->getHasError()) {
                    $message = __(
                        'You added %1 to your shopping cart.',
                        $product->getName()
                    );
                    $this->messageManager->addSuccessMessage($message);
                }
                return $this->goBack(null, $product);
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            if ($this->_checkoutSession->getUseNotice(true)) {
				$messages = array_unique(explode("\n", $e->getMessage()));
                $this->messageManager->addNotice(
                    $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($e->getMessage())
                );
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->messageManager->addError(
                        $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($message)
                    );
                }
            }

            $url = $this->_checkoutSession->getRedirectUrl(true);

            if (!$url) {
                $cartUrl = $this->_objectManager->get('Magento\Checkout\Helper\Cart')->getCartUrl();
                $url = $this->_redirect->getRedirectUrl($cartUrl);
            }
			
			$result = ['error' => __($messages[0])];
			return $this->getResponse()->representJson(
				$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
			);
            /* return $this->goBack($url); */

        } catch (\Exception $e) {
            /* $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            return $this->goBack(); */
			
			$result = ['error' => __('We can\'t add this item to your shopping cart right now.')];
			return $this->getResponse()->representJson(
				$this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
			);
			
        }
		}
    }

    /**
     * Resolve response
     *
     * @param string $backUrl
     * @param \Magento\Catalog\Model\Product $product
     * @return $this|\Magento\Framework\Controller\Result\Redirect
     */
    protected function goBack($backUrl = null, $product = null)
    {
        if (!$this->getRequest()->isAjax()) {
            return parent::_goBack($backUrl);
        }

        $result = [];

        if ($backUrl || $backUrl = $this->getBackUrl()) {
            $result['backUrl'] = $backUrl;
        } else {
            if ($product && !$product->getIsSalable()) {
                $result['product'] = [
                    'statusText' => __('Out of stock')
                ];
            }
        }

        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
        );
    }
	
	protected function isProductInventory($product)
    {
        if (!$this->getRequest()->isAjax()) {
            return parent::_goBack($backUrl);
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
		$inStock = $StockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
		if(($quoteItem = $this->cart->getQuote()->getItemByProduct($product)) && $quoteItem->getQty() && ($itemId = $quoteItem->getItemId()))
		{
			
			if($quoteItem->getQty() == $inStock)
			{
				
			}else{
				echo false;
			}
		}

        
    }
	
}
