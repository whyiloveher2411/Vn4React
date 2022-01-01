<?php

add_action('before_save_post_ecom_prod',function($post, $input){

    $products = new \Vn4Ecom\Product\Model\Product( $post );

    $products->standardized();

    // $products->calculatePricing();
});