<?php

add_action('before_save_post_ecom_order',function($post, $input){

    $r = request();
    $ecom_prod = $r->get('ecom_prod');
    
    $ecom_prod_post = json_decode($post->ecom_prod,true);

    if( isset($ecom_prod[0]) && isset($ecom_prod_post[0]) ){

        $ecom_prod_key_id = [];

        foreach($ecom_prod as $prod){
            $ecom_prod_key_id[ $prod['id'] ] = $prod;
        }

        foreach( $ecom_prod_post as $key => $prod ){
            if( isset($ecom_prod_key_id[ $prod['id'] ]) && intval($ecom_prod_key_id[ $prod['id'] ]['quantity']) > 0 ){
                $ecom_prod_post[ $key ]['quantity'] = intval($ecom_prod_key_id[ $prod['id'] ]['quantity']);
            }
        }

        $post->ecom_prod = json_encode($ecom_prod_post);

    }else{
        $post->ecom_prod = '';
    }

});