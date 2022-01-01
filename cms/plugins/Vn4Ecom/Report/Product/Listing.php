<?php
namespace Vn4Ecom\Report\Product;

use DB;

class Listing{
    
    private $product;

    private $dataCache = [];

    private $timeTypeList = [];

    private $timeType;
    private $startDate;
    private $endDate;

    public function __construct($timeType){
        $this->timeType = $timeType;
        list($this->startDate, $this->endDate) = \Vn4Ecom\Report\Time::{$timeType}();
    }

    public function getTimeReport(){
        $constName = $this->timeType.'_LABEL';
        return [$this->startDate, $this->endDate];
    }

     /*
    * Get all order in between time start and time end
    */
    private function getOrders(){

        if( !isset($dataCache['orders']) ){
            $dataCache['orders'] = get_posts('ecom_order',['count'=>1000000, 'select'=>[
                '*', 
                DB::raw('DATE(date_created) as date_created_group'),
                DB::raw('DATE_FORMAT(`date_created`,\'%Y-%m\') as month_created_group'),
                DB::raw('DATE_FORMAT(`date_created`,\'%H\') as hour_created_group'),

            ],'order'=>['date_created','asc'],'callback'=>function($q){
                $q->whereIn('order_status',array_keys(\Vn4Ecom\Order\SelectOptions::status()))
                    ->whereDate('date_created', '>=', $this->startDate)
                    ->whereDate('date_created','<=', $this->endDate);
            }]);
        }

        return $dataCache['orders'];
    }

    /*
    * Get all review in between time start and time end
    */
    private function getReviews(){

        if( !isset($dataCache['reviews']) ){
            
            $dataCache['reviews'] = get_posts('ecom_prod_review',['count'=>1000000,'select'=>['id','rating'], 'callback'=>function($q) {
                $q->where('review_status', 'approved')
                ->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at','<=', $this->endDate);
            }]);
            
        }

        return $dataCache['reviews'];
    }

    /*
    *Get all report for screen
    */
    public function getAllReport(){
        return [
            'order'=>$this->getOrderReport(),
            'review'=>$this->getReviewReport(),
            'channels'=>$this->getSaleChannelsReport(),
            'status_rate'=>$this->getStatusOrderReport(),
        ];
    }

    private function getReportValueByGroupTime($rangeTime, $orderGroups){

        $orderGroupByDate = [];
        
        foreach( $rangeTime as $date ){

            if( isset( $orderGroups[$date] ) ){
                $orderGroupByDate[] = [
                    'date'=>$date, 
                    'cost'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['pricing']['cost']) ){
                            return $carry + $order['pricing']['cost']; 
                        }
                        return $carry;
                    }),
                    'profit'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['pricing']['profit']) ){
                            return $carry + $order['pricing']['profit']; 
                        }
                        return $carry;
                    }),
                    'tax'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['pricing']['tax']) ){
                            return $carry + $order['pricing']['tax']; 
                        }
                        return $carry;
                    }),
                    'order_quantity'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['pricing']['order_quantity']) ){
                            return $carry + $order['pricing']['order_quantity']; 
                        }
                        return $carry;
                    }),
                    'discount'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['discount']) ){
                            return $carry + $order['discount']; 
                        }
                        return $carry;
                    }),
                    'revenue'=>array_reduce($orderGroups[$date]->toArray(), function($carry, $order){
                        if( isset($order['pricing']['revenue']) ){
                            return $carry + $order['pricing']['revenue']; 
                        }
                        return $carry;
                    }),
                ];

            }else{
                $orderGroupByDate[] = [
                    'date'=>$date,
                    'cost'=>0,
                    'profit'=>0,
                    'tax'=>0,
                    'order_quantity'=>0,
                    'revenue'=>0,
                    'discount'=>0,
                ];
            }
            
        }

        return $orderGroupByDate;

    }

    /*
    * Group order for chart by hour
    */
    private function groupOrderByHour($orders){

        $orderGroups = $orders->groupBy('hour_created_group');

        $dates = range(strtotime($this->startDate.' 00:00:00'), strtotime($this->endDate.' 23:59:59'),3600);
        $range_of_hour = array_map(function($x){
            return date('H', $x);
        }, $dates);

        return $this->getReportValueByGroupTime($range_of_hour, $orderGroups);
    }

    /*
    * Group order for chart by date
    */
    private function groupOrderByDate($orders){

        $orderGroups = $orders->groupBy('date_created_group');

        $dates = range(strtotime($this->startDate), strtotime($this->endDate),86400);
        $range_of_dates = array_map(function($x){
            return date('Y-m-d', $x);
        }, $dates);

        return $this->getReportValueByGroupTime($range_of_dates, $orderGroups);
    }

    /*
    * Group order for chart by month
    */
    private function groupOrderByMonth($orders){

        $orderGroups = $orders->groupBy('month_created_group');

        $dates = range(strtotime($this->startDate), strtotime($this->endDate),86400*28);
        $range_of_dates = array_map(function($x){
            return date('Y-m', $x);
        }, $dates);

        $range_of_month = array_unique($range_of_dates);

        return $this->getReportValueByGroupTime($range_of_month, $orderGroups);
    }

    /*
    * Group order for chart
    */
    private function groupOrder($orders){

        $listGroupMonth = [
            \Vn4Ecom\Report\Time::LAST_1_YEAR => true,
            \Vn4Ecom\Report\Time::LAST_2_YEARS => true,
            \Vn4Ecom\Report\Time::LAST_3_YEARS => true,
        ];

        if( $this->timeType === \Vn4Ecom\Report\Time::TODAY ){
            return $this->groupOrderByHour($orders);
        }elseif( isset($listGroupMonth[ $this->timeType ]) ){
            return $this->groupOrderByMonth($orders);
        }else{
            return $this->groupOrderByDate($orders);
        }
    }

    /*
    *Get order report
    */
    public function getOrderReport(){

        $orders = $this->getOrders();
        $revenue = 0;
        $cost = 0;
        $profit = 0;
        $tax = 0;
        $order_quantity = 0;
        $discount = 0;

        $groupOrder = new \Illuminate\Database\Eloquent\Collection();

        foreach( $orders as $order ){

            if( $order->order_status !== 'completed' ){
                continue;
            }
            
            $products = json_decode($order->products,true);

            
            $order->products = $products;

            if( isset($products['items'][0]) ){

                foreach($products['items'] as $productIndex => $prod){

                    if( $prod['product_type'] === 'variable' ){

                        $productCost = 0;
                        $productRevenue = 0;
                        $productProfit = 0;
                        $productTax = 0;
                        $productQuantity = 0;
                        
                        if( isset($prod['variations'][0]) ){
                            foreach( $prod['variations'] as $variationKey => $variation){
                                $pricingProduct = $this->getPricingProduct( $variation );
                                $productCost += $pricingProduct['cost'];
                                $productRevenue += $pricingProduct['revenue'];
                                $productProfit += $pricingProduct['profit'];
                                $productTax += $pricingProduct['tax'];
                                $productQuantity += $pricingProduct['order_quantity'];
                            }
                        }

                        $order->pricing = [
                            'revenue'=>$productRevenue,
                            'cost'=>$productCost,
                            'profit'=>$productProfit,
                            'tax'=>$productTax,
                            'order_quantity'=>$productQuantity,
                        ];

                        $cost += $productCost;
                        $revenue += $productRevenue;
                        $profit += $productProfit;
                        $tax += $productTax;
                        $order_quantity += $productQuantity;

                    }else{

                        $pricingProduct = $this->getPricingProduct( $prod );
                        $cost += $pricingProduct['cost'];
                        $revenue += $pricingProduct['revenue'];
                        $profit += $pricingProduct['profit'];
                        $tax += $pricingProduct['tax'];
                        $order_quantity += $pricingProduct['order_quantity'];

                        $order->pricing = [
                            'revenue'=>$pricingProduct['revenue'],
                            'cost'=>$pricingProduct['cost'],
                            'profit'=>$pricingProduct['profit'],
                            'tax'=>$pricingProduct['tax'],
                            'order_quantity'=>$pricingProduct['order_quantity'],
                        ];
                    }
                }
            }

            $order->discount = \Vn4Ecom\Cart\Model\Cart::getDiscount( $order->discount, isset($order->pricing['revenue'])?$order->pricing['revenue']:0 );

            $discount += $order->discount;

            $groupOrder->add($order);
        }
        
        return [
            'count'=>$orders->count(),
            'rows'=>$this->groupOrder($groupOrder),
            'pricing_detail'=>[
                'headers'=>[
                    'revenue'=>'Revenue',
                    'cost'=>'Cost',
                    'profit'=>'Profit',
                    'tax'=>'Tax',
                    'order_quantity'=>'Quantity',
                    'discount'=>'Discount',
                ],
                'rows'=>[
                    'revenue'=>$revenue,
                    'cost'=>$cost,
                    'profit'=>$profit,
                    'tax'=>$tax,
                    'order_quantity'=>$order_quantity,
                    'discount'=>$discount,
                ],
            ]
        ];

    }

    /*
    *Get pricing for one product in order
    */
    private function getPricingProduct($product){

        $revenue = 0;
        $profit = 0;
        $cost = 0;
        $tax = 0;
        $price_after_tax = 0;

        if( isset($product['order_quantity']) && intval($product['order_quantity']) > 0
        ){
            $price_after_tax = \Vn4Ecom\Product\Model\Product::calculatePriceAfterTax( $product );
            $revenue = $price_after_tax * intval($product['order_quantity']);
            $profit = ( isset( $product['profit'] ) ? $product['profit'] : 0 ) * intval($product['order_quantity']);
            $cost = ( isset( $product['cost'] ) ? $product['cost'] : 0 ) * intval($product['order_quantity']);
            $tax = ( isset($product['tax']) ? $product['tax'] : 0 )  * intval($product['order_quantity']);
        }

        return [
            'price' => $product['price'] ?? 0,
            'order_quantity' => isset($product['order_quantity']) ? $product['order_quantity'] : 0,
            'price_after_tax' => $price_after_tax,
            'cost' => $cost,
            'profit' => $profit,
            'revenue' => $revenue,
            'tax' => $tax,
        ];
    }

    /*
    *Get review report
    */
    public function getReviewReport(){

        $reviews = $this->getReviews();
    
        $reviewRows = [];
    
        $reviewDataGroup = $reviews->groupBy('rating');
    
        for( $i = 0 ; $i < 5; $i ++ ){
            $reviewRows[$i] = isset($reviewDataGroup[$i + 1]) ? count($reviewDataGroup[$i + 1]) : 0;
        }
    
        return [
            'total'=>$reviews->count(),
            'average'=>round($reviews->average('rating'),2),
            'rows'=>$reviewRows
        ];
    }

    /*
    *Get channel report
    */
    public function getSaleChannelsReport(){

        $orderGroups = $this->getOrders()->groupBy('sale_channel');

        $rows = [];

        foreach($orderGroups as $key => $orders){
            $rows[$key] = count($orders);
        }

        return [
            'headers'=>\Vn4Ecom\Order\SelectOptions::saleChannel(),
            'rows'=>$rows
        ];
    }

    /*
    *Get report for status
    */
    public function getStatusOrderReport(){

        $orderGroups = $this->getOrders()->groupBy('order_status');

        $rows = [];

        foreach($orderGroups as $key => $orders){
            $rows[$key] = count($orders);
        }

        return [
            'headers'=>\Vn4Ecom\Order\SelectOptions::status(),
            'rows'=>$rows
        ];
    }
}