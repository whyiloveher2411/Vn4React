<?php
namespace Vn4Ecom\Product\Model;
use Request;

class Product{
    //product post
    protected $product;

    //product type
    public static $productType = [
        'SIMPLE'=>'simple',
        'GROUPED'=>'grouped',
        'EXTERNAL'=>'external',
        'VARIABLE'=>'variable',
    ];

    //product type options
    public static $productTypeOptions = [
        'simple'=>['title'=>'Simple','color'=>'#3f51b5'],
        'grouped'=>['title'=>'Grouped','color'=>'#ff5900'],
        'external'=>['title'=>'External','color'=>'#7903da'],
        'variable'=>['title'=>'Variable','color'=>'#43a047'],
    ];

    public static $productTypeOptionDefault = 'simple';

    public static $stockStatus = [
        'instock'=>['key'=>'instock', 'title'=>'In stock','color'=>'#7ad03a'],
        'outofstock'=>['key'=>'outofstock', 'title'=>'Out of stock','color'=>'#a44'],
        'onbackorder'=>['key'=>'onbackorder', 'title'=>'On backorder','color'=>'#eaa600'],
    ];

    protected $request;

    private $productDetail;

    private $detailedPrice = [];

    public function __construct($product){
        $this->request = request();
        $this->product = $product;
    }


    public function setRequsetProductDetail($productDetail){
        $this->productDetail = $productDetail;
    }
    /*
    * Get detailed product information
    */
    public function getRequsetProductDetail(){

        if( $this->productDetail ){
            return $this->productDetail;
        }

        $productDetail = $this->request->get('ecom_prod_detail');

        if( gettype($productDetail) === 'string' ){
            $productDetail = json_decode( $productDetail ) ?? [];
        }

        $this->productDetail = $productDetail;

        return $this->productDetail;
    }

    /*
    * Update pricing for product nomal
    */
    private function getParamUpdatePricing(){

        $taxCallback = function($productDetail){

            if( !isset($productDetail['tax_class_detail']) ) return 0;
            
            if( gettype($productDetail['tax_class_detail']) === 'string'){
                $productDetail['tax_class_detail'] = json_decode($productDetail['tax_class_detail'],true)??[];
            }

            if( isset($productDetail['tax_class_detail']['percentage']) ){
                return round($productDetail['tax_class_detail']['percentage']/100*$productDetail['price'],3);
            }

            return 0;
            
        };

        $priCallback = function($productDetail){
            return round(isset($productDetail['price']) ? $productDetail['price'] : 0, 2);
        };


        return  [
            'price'=> $priCallback,
            'compare_price'=>function($productDetail){
                return round($productDetail['compare_price']??0, 2);
            },
            'cost'=>function($productDetail){
                return round($productDetail['cost']??0, 2);
            },
            'profit'=>function($productDetail){
                return round( ($productDetail['price']??0) - ($productDetail['cost']??0), 2) ;
            },
            'profit_margin'=>function($productDetail){
                $productDetail['price'] = (float) (isset($productDetail['price']) ? $productDetail['price'] : 0 );

                if( $productDetail['price'] ){
                    return round((($productDetail['price']??0) - ($productDetail['cost']??0))/$productDetail['price']*100, 2);
                }
                return 0;
            },
            'percent_discount'=>function($productDetail){
                if( isset($productDetail['compare_price']) && intval($productDetail['compare_price']) > 0 ){
                    return round(100 - (($productDetail['price']??0)*100/$productDetail['compare_price']),2);
                }
                return 0;
            },
            'enable_tax'=>function($productDetail){
                return $productDetail['enable_tax']??0;
            },
            'tax_class'=>function($productDetail){
                return $productDetail['tax_class']??0;
            },
            'tax'=>$taxCallback,
            'price_after_tax'=>function($productDetail) use ($taxCallback, $priCallback){
                $tax = $taxCallback( $productDetail );

                $price = $priCallback( $productDetail );

                return round($tax + $price,2);
            }
        ];
    }

    /*
    * get Variations of product
    */
    private function getVariations(){

        $productDetail = $this->getRequsetProductDetail();

        if( isset($productDetail['variations']) ){
            
            if( !is_array($productDetail['variations']) ){
                $productDetail['variations'] = json_decode($productDetail['variations'], true);
                if( !$productDetail['variations'] ) $productDetail['variations'] = [];
            }
            return $productDetail['variations'];
        }else{
            return [];
        }

    }

    public function setVariations($variations){

        $productDetail = $this->request->get('ecom_prod_detail');
        
        $productDetail['variations'] = $variations;

        $this->request->merge([
            'ecom_prod_detail'=>$productDetail
        ]);
    }

    /*
    * Calculate price product normal
    */
    private function calculatePricingProductNormal(){
        $productDetail = $this->getRequsetProductDetail();

        $updateParams = $this->getParamUpdatePricing();
        
        foreach($updateParams as $key => $v){
            $this->product->{$key} = $v( $productDetail );
        }
    }

    /*
    * Calculate price product variation
    */
    private function calculatePricingProductVariation(){
        
        $variations = $this->getVariations();

        $listPrice = [];
        $listComparePrice = [];

        $updateParams = $this->getParamUpdatePricing();

        foreach($variations as $variationIndex => $variation){

            if( !$variation['delete'] ){

                foreach($updateParams as $key => $v){
                    $variations[$variationIndex][$key] = $v( $variation );
                }
                
                if( isset($variation['price']) ){
                    $listPrice[] = floatval( $variation['price'] );
                }

                if( isset($variation['compare_price']) ){
                    $listComparePrice[] = floatval( $variation['compare_price'] );
                }
            }
        }

        $this->setVariations( $variations );

        if( isset($listPrice[0]) ){
            $this->product->price_max = max($listPrice);
            $this->product->price_min = min($listPrice);
        }
        if( isset($listComparePrice[0]) ){
            $this->product->compare_price_max = max($listComparePrice);
            $this->product->compare_price_min = min($listComparePrice);
        }

    }

    /*
    * Calculate price
    */
    private function calculatePricing(){
        if( self::$productType['VARIABLE'] === $this->product->product_type ){
            $this->calculatePricingProductVariation();
        }else{
            $this->calculatePricingProductNormal();
        }
    }

    
    /*
    * Calculate the number of product Variation
    */
    private function calculateQuantityVariation(){

        $variations = $this->getVariations();
        
        $totalQuantity = 0;

        $numberOfVariation = 0;

        foreach( $variations as $key => $variation ){
            if(  !$variation['delete'] ){
                if( isset($variation['warehouse_manage_stock']) && $variation['warehouse_manage_stock'] ){
                    $totalQuantity += $variation['warehouse_quantity'] ?? 0;
                }
                ++$numberOfVariation;
            }
        }

        $this->product->number_of_variation = $numberOfVariation;
        $this->product->quantity = $totalQuantity;

    }

    /*
    * Calculate the number of product Normal
    */
    private function calculateQuantityProductNormal(){
        $productDetail = $this->getRequsetProductDetail();
        $this->product->quantity = $productDetail['warehouse_quantity'] ?? 0;
    }

    /*
    *  Calculate the number of products
    */
    private function calculateQuantity(){
        if( self::$productType['VARIABLE'] === $this->product->product_type ){
            $this->calculateQuantityVariation();
        }else{
            $this->calculateQuantityProductNormal();
        }
    }

    /*
    *
    */
    private function changeStockStatus(){

        $productDetail = $this->getRequsetProductDetail();

        if( self::$productType['VARIABLE'] === $this->product->product_type ){

            $variations = $this->getVariations();
            
            if( $this->product->quantity > 0 ){
                $stock_status = self::$stockStatus['instock']['key'];
            }else{

                $stock_status = self::$stockStatus['outofstock']['key'];

                foreach($variations as $key => $variation){
                    if( !$variation['delete'] ){

                        if( isset($variation['warehouse_manage_stock']) && $variation['warehouse_manage_stock'] ){
        
                            if( isset($variation['warehouse_pre_order_allowed']) && $variation['warehouse_pre_order_allowed'] !== 'no' ){
                                $stock_status = self::$stockStatus['onbackorder']['key'];
                            }
        
                        }elseif( isset($variation['stock_status']) ){
                            if( $variation['stock_status'] ===  self::$stockStatus['instock']['key'] ){
                                $stock_status = self::$stockStatus['instock']['key'];
                                break;
                            }elseif( $variation['stock_status'] !== self::$stockStatus['outofstock']['key'] && isset(self::$stockStatus[ $variation['stock_status'] ])){
                                $stock_status = $variation['stock_status'];
                            }
                        }else{
                            $stock_status = self::$stockStatus['instock']['key'];
                            $variation['stock_status'] = $stock_status;
                        }
                    }
                }

                $this->setVariations($variations);
            }

            $this->product->stock_status = $stock_status;
        }else{

            if( isset($productDetail['warehouse_manage_stock']) && $productDetail['warehouse_manage_stock'] ){

                if( isset($productDetail['warehouse_quantity']) && intval( $productDetail['warehouse_quantity'] ) > 0 ){
                    $this->product->stock_status = self::$stockStatus['instock']['key'];
                }elseif( isset($productDetail['warehouse_pre_order_allowed']) && $productDetail['warehouse_pre_order_allowed'] !== 'no' ){
                    $this->product->stock_status = self::$stockStatus['onbackorder']['key'];
                }else{
                    $this->product->stock_status = self::$stockStatus['outofstock']['key'];
                }

            }elseif( isset($productDetail['stock_status']) ){
                if( isset(self::$stockStatus[ $productDetail['stock_status'] ]) ){
                    $this->product->stock_status = self::$stockStatus[ $productDetail['stock_status'] ]['key'];
                }else{
                    $this->product->stock_status = self::$stockStatus['outofstock']['key'];
                }
            }
        }
    }
    
    public static function getProductVariations($id){
        $productDetail = get_post('ecom_prod_detail', $id);

        if( !$productDetail ){
            return false;
        }

        if( isset($productDetail['variations']) ){
            
            if( !is_array($productDetail['variations']) ){
                $productDetail['variations'] = json_decode($productDetail['variations'], true);
                if( !$productDetail['variations'] ) $productDetail['variations'] = [];
            }
            return $productDetail['variations'];
        }else{
            return [];
        }
    }

    public static function calculatePriceAfterTax( $product ){

        $price = $product['price'] ? floatval($product['price']) : 0;

        if( isset($product['enable_tax']) && $product['enable_tax'] ){

            $tax = isset($product['tax_class_detail']) ? $product['tax_class_detail'] : [] ;

            if( gettype($tax) === 'string'){
                $tax = json_decode($tax,true)??[];
            }
    
            if( isset($tax['percentage']) ){
                return $price + round($tax['percentage']/100*$price,3);
            }
        }

        return $price;
    }

    public function addQuantity($quantity){

    }

    public function setQuantity($quantity){
        
    }

    /*
    *  Normalize data posted from admin
    */
    public function standardized(){
        $this->calculatePricing();
        $this->calculateQuantity();
        $this->changeStockStatus();
    }
    
    
}