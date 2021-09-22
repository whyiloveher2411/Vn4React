<?php

add_action('before_save_post_ecom_prod',function($post, $input){

    $r = request();

    if( $post->product_type === 'variable' ){

        $productDetail = $r->get('ecom_prod_detail');
        
        if( gettype($productDetail['variations']) === 'string' ){
            $productDetail['variations'] = json_decode($productDetail['variations'],true);
        }

        if( isset($productDetail['variations']) && !empty( $productDetail['variations'] ) ){

            $price = PHP_FLOAT_MAX;
            $compare_price = 0;
            $cost = 0;

            foreach ( $productDetail['variations'] as $variationKey => $variable) {
                
                if( !$variable['delete'] ){
                    if( isset($variable['price']) && $variable['price']*1 && $price > $variable['price']){
                        $price = $variable['price']*1;
                    }

                    if( isset($variable['compare_price']) && $variable['compare_price']*1 && $compare_price < $variable['compare_price']){
                        $compare_price = $variable['compare_price']*1;
                    }

                    if( isset($variable['cost']) && $variable['cost']*1 && $cost < $variable['cost']){
                        $cost = $variable['cost']*1;
                    }
                }
            }

            if( $price ){
                $post->price = $price;
            }

            if( $compare_price ){
                $post->compare_price = $compare_price;
            }

            if( $cost ){
                $post->cost = $cost;
            }

            
        }
    }

    if( $post->price && $post->cost ){
        $post->profit = round( $post->price - $post->cost, 2) ;
        $post->profit_margin = round( ($post->price - $post->cost )/  $post->price * 100 ,1) ;
    }

});