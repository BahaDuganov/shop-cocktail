<?php 
namespace Aislend\Configurable\Block\ConfigurableProduct\Product\View\Type;

use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Json\DecoderInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class Configurable
{

    protected $jsonEncoder;
    protected $jsonDecoder;
    protected $stockRegistry;
	protected $cart;

    public function __construct(
        EncoderInterface $jsonEncoder,
        DecoderInterface $jsonDecoder,
        StockRegistryInterface $stockRegistry,
		\Magento\Checkout\Model\Cart $cart
    ) {

        $this->jsonDecoder = $jsonDecoder;
        $this->jsonEncoder = $jsonEncoder;
        $this->stockRegistry = $stockRegistry;
		$this->cart = $cart;
    }

    // Adding Quantitites (product=>qty)
    public function aroundGetJsonConfig(
        \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject,
        \Closure $proceed
    )
    {
        $quantities = [];
        $cartQty = [];
        $config = $proceed();
        $config = $this->jsonDecoder->decode($config);
		$cartdata = $this->cart->getQuote()->getAllVisibleItems();	
		
		$skuList = array();
		foreach($cartdata as $item) :				
			$skuList[$item->getSku()] = $item->getQty();
		endforeach;
		
        foreach ($subject->getAllowProducts() as $product) :
            $stockitem = $this->stockRegistry->getStockItem(
                $product->getId(),
                $product->getStore()->getWebsiteId()
            );
            $quantities[$product->getId()] = $stockitem->getQty();			
			$cartQty['sku_'.$product->getId()] = $product->getSku();			
        endforeach;
		
		$config['sku'] = $cartQty;
        $config['quantities'] = $quantities;

        return $this->jsonEncoder->encode($config);
    }
}

?>