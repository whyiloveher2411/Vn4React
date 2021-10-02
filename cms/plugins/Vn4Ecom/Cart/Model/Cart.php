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

                    if( intval($product['quantity']) < 1 ){
                        unset($products['items'][$index]);
                        continue;
                    }

                    $itemsSubtotal += ($product['price']*$product['quantity']);

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

    /*
    *Calculate the total amount of discount based on order
    */
    public function calculateDiscount(){

        if( !isset($this->detailedPrice['discount']) ){

            $discount = json_decode($this->order->discount, true);

            if( !$discount ) $discount = []; 

            if( isset($discount['value']) && $discount['value'] ){
                if( $discount['type'] === '%' ){
                    $productAmount = $this->calculateItemsSubtotal();
                    $discount['total'] = $productAmount*$discount['value']/100;
                }else{
                    $discount['total'] = $discount['value'];
                }
            }else{
                $discount['total'] = 0;
            }

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

}