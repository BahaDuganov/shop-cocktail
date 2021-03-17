<?php


namespace Aislend\Recipe\Controller\Recipe;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Exception\NoSuchEntityException;

class RecipeIngredients extends \Magento\Checkout\Controller\Cart
{
    protected $productRepository;

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


    protected function _initProduct($productId)
    {
        /* $productId = (int)$this->getRequest()->getParam('product'); */
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

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {

        $params = $this->getRequest()->getParams();
        try {
            foreach($params['product'] as $key => $productId):
                $paramsFbt = [];
                if (isset($params['qty'][$key])) {
                    $filter = new \Zend_Filter_LocalizedToNormalized(
                        ['locale' => $this->_objectManager->get('Magento\Framework\Locale\ResolverInterface')->getLocale()]
                    );
                    $productQty = ($params['qty'][$key] == '') ? 1 : $params['qty'][$key];
                    $paramsFbt['qty'] = $productQty;
                }
                $paramsFbt['product'] = $productId;
                $product = $this->_initProduct($productId);

                $related = $this->getRequest()->getParam('related_product');
                /**
                 * Check product availability
                 */
                if (!$product) {
                    return $this->goBack();
                }
                $productsName[] = '"' . $product->getName() . '"';

                $this->cart->addProduct($product, $paramsFbt);
                if (!empty($related)) {
                    $this->cart->addProductsByIds(explode(',', $related));
                }
            endforeach;

            $this->cart->save();
            if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                if (!$this->cart->getQuote()->getHasError()) {
                    $message = __(
                        'You added %1 to your shopping cart.', join(', ', $productsName)
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

            $result = ['errorq' => __($messages[0])];
            $this->getResponse()->representJson(
                $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
            );
            return $this->goBack(null, $product);

        } catch (\Exception $e) {
            $result = ['errorg' => __('We can\'t add this item to your shopping cart right now.')];
            return $this->getResponse()->representJson(
                $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
            );
            return $this->goBack(null, $product);

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

?>