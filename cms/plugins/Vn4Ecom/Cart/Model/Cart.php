<?php
namespace Vn4Ecom\Cart\Model;

class Cart{

    protected $order;

    private $detailedPrice = [];

    public function __construct($order){
        $this->order = $order;
    }

    public function calculateTotal(){

        $itemsSubtotal = $this->calculateItemsSubtotal();
        $coupon = $this->calculateCoupon();
        $discount = $this->calculateDiscount();

        $total = $itemsSubtotal - $coupon - $discount;

        if( $total < 0 ) $total = 0;
        
        $this->order->total_money = $total;

        return $total;
    }

    /*
    *Calculate the total amount of products based on order
    */
    public function calculateItemsSubtotal(){

        if( !isset($this->detailedPrice['itemsSubtotal']) ){

            $products = json_decode($this->order->products, true);

            if( !$products ) $products = []; 

            $itemsSubtotal = 0;

            if( isset($products['items'][0]) ){
                foreach( $products['items'] as $index => $product){
                    switch ($product['product_type']) {
                        case 'variable':
                            $totalVariable = 0;
                            if ( isset($product['variations']) && count($product['variations']) > 0) {
                                foreach( $product['variations'] as $variation ){

                                    $quantity = $variation['order_quantity'] ? intval($variation['order_quantity']) : 0;
                                    $price = $variation['price'] ? floatval($variation['price']) : 0;
                                    $tax = isset($variation['tax']) && floatval($variation['tax']) > 0 ? floatval($variation['tax']) * $quantity : 0;

                                    $variation['total'] = $quantity *  $price + $tax;

                                    $totalVariable += $variation['total'];
                                }
                                $product['total'] = $totalVariable;
                                $itemsSubtotal += $totalVariable;
                            }else{
                                unset($products['items'][$index]);
                            }
                            break;
                        default:
                            if( !isset($product['order_quantity']) || intval($product['order_quantity']) < 1 ){
                                unset($products['items'][$index]);
                            }else{
                                $quantity = $product['order_quantity'] ? intval($product['order_quantity']) : 0;
                                $price = $product['price'] ? floatval($product['price']) : 0;
                                $tax = isset($product['tax']) && floatval($product['tax']) > 0 ? floatval($product['tax']) * $quantity : 0;

                                $product['total'] = $price * $quantity + $tax;
                                $itemsSubtotal += $product['total'];
                            }
                            break;
                    }
                }
            }
            
            $products['total'] = $itemsSubtotal;

            $this->order->products = json_encode( $products );
            $this->detailedPrice['itemsSubtotal'] = $itemsSubtotal;

        }
        
        return $this->detailedPrice['itemsSubtotal'];
    }

    /*
    *Calculate the total amount of coupon based on order
    */
    public function calculateCoupon(){

        if( !isset($this->detailedPrice['coupons']) ){
            $coupons = json_decode($this->order->coupons, true);

            if( !$coupons ) $coupons = []; 

            $money = 0;

            $productAmount = $this->calculateItemsSubtotal();

            if( isset($coupons['items'][0]) ){

                foreach( $coupons['items'] as $index => $coupon){
                    $money += ( 
                        $coupon['discount_type'] === '%' ? 
                        $productAmount*$coupon['coupon_amount']/100
                        : $coupon['coupon_amount'] );

                }
            }
            
            $coupons['total'] = $money;

            $this->order->coupons = json_encode($coupons);
            $this->detailedPrice['coupons'] = $money;

        }

        return $this->detailedPrice['coupons'];
    }

    public static function getDiscount( $discount, $total ){

        if( is_string($discount) ){
            $discount = json_decode($discount,true);
        }

        if( isset($discount['value']) && $discount['value'] ){
            if( $discount['type'] === '%' ){
                return $total*$discount['value']/100;
            }else{
                return $discount['value'];
            }
        }else{
            return 0;
        }
    }

    /*
    *Calculate the total amount of discount based on order
    */
    public function calculateDiscount(){

        if( !isset($this->detailedPrice['discount']) ){

            $discount = json_decode($this->order->discount, true);

            if( !$discount ) $discount = []; 

            $discount['total'] = self::getDiscount($discount, $this->calculateItemsSubtotal());

            $this->order->discount = json_encode( $discount );
            $this->detailedPrice['coupons'] = $discount['total'];
        }

        return $this->detailedPrice['coupons'];

    }

    public function addHistory(  \Vn4Ecom\Cart\Model\Cart\History $history, $index = null ){

        $historyJson = json_decode($this->order->history,true);

        if( !$historyJson ) $historyJson = [];
       
        if( $index === null ){
            array_splice( $historyJson, $index, 0, [$history->toArray()] );
        }else{
            $historyJson[] = $history->toArray();
        }

        $this->order->history = json_encode($historyJson);

    }

    public static function getRevenueOrder( $product, $quantity ){

        return [
            'price'=>'',
            'compare_price'=>'',
            'cost'=>'',
            'profit_margin'=>'',
            'profit'=>'',
            'percent_discount'=>'',
            'tax'=>'',
            'tax_class'=>'',
        ];

    }

}