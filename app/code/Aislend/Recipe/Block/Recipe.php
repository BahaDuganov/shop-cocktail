<?php
namespace Aislend\Recipe\Block;

class Recipe extends \Magento\Framework\View\Element\Template
{
    protected $_helper;
    protected $_productloader;
    protected $eavAttribute;
    protected $imageHelper;
    protected $jsonHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Aislend\Recipe\Helper\Data $helper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productloader,
        \Magento\Eav\Model\Config $eavAttribute,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    )
    {
        parent::__construct($context);
        $this->_helper = $helper;
        $this->_productCollection = $_productloader;
        $this->_eavAttribute = $eavAttribute;
        $this->_imageHelper = $imageHelper;
        $this->_jsonHelper = $jsonHelper;
    }

    public function getRecipeData()
    {
        $recipeId = $this->getRequest()->getParam('recipe-id');
        if(!$recipeId)
        {
            return 'No Data Found';
        }
        $recipeUrl = 'http://api.yummly.com/v1/api/recipe/'.$recipeId.'?_app_id='.$this->_helper->getAppId().'&_app_key='.$this->_helper->getAppKey();
        $recipeApi = curl_init();
        curl_setopt($recipeApi, CURLOPT_URL, $recipeUrl);
        curl_setopt($recipeApi, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($recipeApi, CURLOPT_RETURNTRANSFER, true);

        $jsonData = json_decode(curl_exec($recipeApi), true);
        if(count($jsonData) == 0):
            echo "No Data Found.";
            return;
        endif;
        $recipeData = json_decode(curl_exec($recipeApi), true);
        return $recipeData;
    }

    public function getRecipeName()
    {
        $recipeName = $this->getRecipeData();
        if(!count($recipeName)):
            return ;
        endif;
        $recipeName = (isset($recipeName['name'])) ? $recipeName['name'] : '';
        return $recipeName;
    }

    public function getRecipeIngredientLines()
    {
        $recipeIngredientLines = $this->getRecipeData();

        if(!count($recipeIngredientLines)):
            return ;
        endif;
        $recipeIngredientLines = (isset($recipeIngredientLines['ingredientLines'])) ? $recipeIngredientLines['ingredientLines'] : '';
        return $recipeIngredientLines;
    }

    public function getRecipeLargeImage()
    {
        $recipeImage = $this->getRecipeData();
        if(!count($recipeImage)):
            return ;
        endif;
        $recipeImage = (isset($recipeImage['images'])) ? $recipeImage['images'][0]['hostedLargeUrl'] : '';
        return $recipeImage;
    }

    public function getRecipeSmallImage()
    {
        $recipeImage = $this->getRecipeData();
        if(!count($recipeImage)):
            return ;
        endif;
        $recipeImage = (isset($recipeImage['images'])) ? $recipeImage['images'][0]['hostedSmallUrl'] : '';
        return $recipeImage;
    }

     public function getRecipeNoServing()
    {
        $recipeServing = $this->getRecipeData();
        if(!count($recipeServing)):
            return ;
        endif;
        $recipeServing = (isset($recipeServing['numberOfServings'])) ? $recipeServing['numberOfServings'] : '';
        if(count($recipeServing) == 1):
            $recipeServing = '<span class="count">1 Serving</span>';
        elseif(count($recipeServing) > 1):
            $recipeServing = '<span class="count">'.count($recipeServing).' Servings</span>';
        else:
            $recipeServing = '';
        endif;
        return $recipeServing;
    }

    public function getRecipeIngredientsCount()
    {
        $recipeIngredients = $this->getRecipeData();
        if(!count($recipeIngredients)):
            return ;
        endif;
        $recipeIngredients = (isset($recipeIngredients['ingredientLines'])) ? $recipeIngredients['ingredientLines'] : '';
        if(count($recipeIngredients) == 1):
            $ingredientsCount = '<span class="count">1</span> Ingredient';
        elseif(count($recipeIngredients) > 1):
            $ingredientsCount = '<span class="count">'.count($recipeIngredients).'</span> Ingredients';
        else:
            $ingredientsCount = '';
        endif;
        return $ingredientsCount;
    }

    public function getRecipeTotalTime()
    {
        $recipeTotalTime = $this->getRecipeData();
        if(!count($recipeTotalTime)):
            return ;
        endif;
        $recipeTotalTime = (isset($recipeTotalTime['totalTime'])) ? $recipeTotalTime['totalTime'] : '';
        return $recipeTotalTime;
    }

    public function getRecipeIngredients()
    {
        $q = $this->getRequest()->getParam('q');
        $q = urlencode($q);
        $recipeId = $this->getRequest()->getParam('recipe-id');
        if(!$q && !$recipeId):
            return 'No Data Found';
        endif;
        $recipeUrl = 'http://api.yummly.com/v1/api/recipes?_app_id='.$this->_helper->getAppId().'&_app_key='.$this->_helper->getAppKey().'&q=' . $q . '&maxResult=48&start=1';
        $recipeApi = curl_init();
        curl_setopt($recipeApi, CURLOPT_URL, $recipeUrl);
        curl_setopt($recipeApi, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($recipeApi, CURLOPT_RETURNTRANSFER, true);
        $allRecipes = json_decode(curl_exec($recipeApi), true);
        $ingrendientsArrayList = array();
        foreach($allRecipes['matches'] as $ingrendients):
            if($ingrendients['id'] == $recipeId):
                $ingrendientsArrayList = $ingrendients['ingredients'];
            endif;
        endforeach;
        return $ingrendientsArrayList;
    }

    public function getLoadProductCollections()
    {
        $productArray = array();
        $ingredients = $this->getAttributeOptionIds();
        $attribute = $this->_eavAttribute->getAttribute('catalog_product', 'ingredients');
        if(count($ingredients)):
            $image = 'product_small_image';
            $productcollection = $this->_productCollection->create()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('ingredients', $ingredients)
                ->load();
            foreach($productcollection as $collection):
                 $productArray[$collection->getIngredients()][] =
                    array
                    (
                        'name'=>$collection->getName(),
                        'price'=>$collection->getPrice(),
                        'productId'=>$collection->getId(),
                        'final_price'=>$collection->getFinalPrice(),
                        'image'=> $this->_imageHelper->init($collection, $image)->resize('65','65')->getUrl(),
                        'ingredients'=>$attribute->getSource()->getOptionText($collection->getIngredients()),
                        'ingredientsID'=>$collection->getIngredients(),
                        'productUrl'=>$collection->getProductUrl()
                    );
            endforeach;
            $result = $this->_jsonHelper->jsonEncode($productArray);
            //return  $productArray;
            return  $productArray;
        endif;
        return;
    }

    public function getAttributeOptionIds()
    {
        $getYummlyIngredientsList = array();
        $getAttributeId = array();
        $attribute = $this->_eavAttribute->getAttribute('catalog_product', 'ingredients');
        $options = $attribute->getSource()->getAllOptions();
        foreach($options as $value):
            if($value['value'] != ''):
                $getYummlyIngredientsList[strtolower($value['label'])] = $value['value'];
            endif;
        endforeach;		
        $ingredients = $this->getRecipeIngredients();
        if(count($ingredients)):
            foreach($ingredients as $ingredientsName):
				if (array_key_exists($ingredientsName, $getYummlyIngredientsList)) :
					$getAttributeId[] = $getYummlyIngredientsList[$ingredientsName];
				endif;                
            endforeach;
        endif;
        $getAttributeId = array_values(array_filter($getAttributeId, 'strlen'));
        return $getAttributeId;
    }

    public function getRecipeViewUrl()
    {
        $recipeAttributes = $this->getRecipeData();
        if(!count($recipeAttributes)):
            return ;
        endif;
        $recipeAttributes = (isset($recipeAttributes['attributes'])) ? $recipeAttributes['attributes'] : '';
        return $recipeAttributes;
    }

    public function getRecipeSourceUrl()
    {
        $recipeSourceUrl = $this->getRecipeData();
        if(!count($recipeSourceUrl)):
            return ;
        endif;
        $recipeSourceUrl = (isset($recipeSourceUrl['source'])) ? $recipeSourceUrl['source'] : '';
        return $recipeSourceUrl;
    }

    public function getRelatedProductList()
    {
        $q = $this->getRequest()->getParam('q');
        $q = urlencode($q);
        $recipeId = $this->getRequest()->getParam('recipe-id');
        if(!$q && !$recipeId):
            return 'No Data Found';
        endif;
        $queryText = '';
        foreach($this->getRecipeIngredients() as $ingredients):
            $queryText .= '&excludedIngredient[]='.urlencode($ingredients);
        endforeach;
        $queryText .= '&maxResult=4&start=4';
        $adminUrl = 'http://api.yummly.com/v1/api/recipes?_app_id='.$this->_helper->getAppId().'&_app_key='.$this->_helper->getAppKey().'&q=' . $q . $queryText;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $adminUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        $recipeCollection = $result['matches'];
        return $recipeCollection;
    }
	
	public function multiFilterRequest() {
		$lsitFliters = array('allergy','diet','cuisine','course','holiday');
		$fliertCatgoryList = array(		
			'http://api.yummly.com/v1/api/metadata/allergy?_app_id=9fdbac04&_app_key=8503201214ca5236b8118c72a43b9c4e','http://api.yummly.com/v1/api/metadata/diet?_app_id=9fdbac04&_app_key=8503201214ca5236b8118c72a43b9c4e' ,'http://api.yummly.com/v1/api/metadata/cuisine?_app_id=9fdbac04&_app_key=8503201214ca5236b8118c72a43b9c4e','http://api.yummly.com/v1/api/metadata/course?_app_id=9fdbac04&_app_key=8503201214ca5236b8118c72a43b9c4e','http://api.yummly.com/v1/api/metadata/holiday?_app_id=9fdbac04&_app_key=8503201214ca5236b8118c72a43b9c4e'
		);
		$curly = array();
		$result = array();
		$mh = curl_multi_init();
		foreach ($fliertCatgoryList as $id => $d) :
			$curly[$id] = curl_init();
			$url = (is_array($d) && !empty($d)) ? $d : $d;
			curl_setopt($curly[$id], CURLOPT_URL,            $url);
			curl_setopt($curly[$id], CURLOPT_HEADER,         0);
			curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

			// post?
			if (is_array($d)) :
			  if (!empty($d['post'])) :
				curl_setopt($curly[$id], CURLOPT_POST,       1);
				curl_setopt($curly[$id], CURLOPT_POSTFIELDS, "GET");
			  endif;
			endif;
			
			if (!empty($options)) {
			  curl_setopt_array($curly[$id], $options);
			}
			curl_multi_add_handle($mh, $curly[$id]);
		
		endforeach;
		
		$running = null;
		do { curl_multi_exec($mh, $running); } while($running > 0);
		
		foreach($curly as $id => $c) :
			$result[$id] = curl_multi_getcontent($c);
			curl_multi_remove_handle($mh, $c);
		endforeach;
		
		curl_multi_close($mh);
		
		$jsonArray = array();
		$i = 0;		
		foreach($result as $recipeFilter):	
			if($recipeFilter[0] !== '[' && $recipeFilter[0] !== '{') : // we have JSONP
			   $recipeFilter = substr($recipeFilter, strpos($recipeFilter, '('));	   
			endif;
			$recipeFilter = trim($recipeFilter,'();');
			$num = ($i == 1) ? 7 : 10;
			$recipeFilter = substr_replace($recipeFilter,'',0,$num);
			$jsonArray[$lsitFliters[$i]] = json_decode($recipeFilter);
		$i++;	
		endforeach;
		return $jsonArray;
		
	}
	
 
}