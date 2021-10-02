<?php

add_action('before_save_post_ecom_order',function($order, $input){

    $user = getUser();

    $cart = new Vn4Ecom\Cart\Model\Cart( $order );

    $cart->calculateTotal();

    //add history when create order
    if( !$order->exists ){

        $history = new \Vn4Ecom\Cart\Model\Cart\History( [
            'name'=>$user->first_name.' '.$user->last_name,
            'email'=>$user->email
        ] );

        $history->addMessage( \Vn4Ecom\Cart\Model\Cart\History::ADDED,
            [
                'page'=>'Admin Page',
            ]
        );
        $cart->addHistory( $history, 0 );

    }else{

        if( $order->order_status !== ($old_status = $order->original('order_status')) ){

            $history = new \Vn4Ecom\Cart\Model\Cart\History([
                'name'=>$user->first_name.' '.$user->last_name,
                'email'=>$user->email
            ]);

            $history->addMessage( \Vn4Ecom\Cart\Model\Cart\History::CHANGE_STATUS,
                [
                    'page'=>'Admin Page',
                    'old_status'=>$old_status,
                    'new_status'=>$order->order_status,
                ]
            );
            
            $cart->addHistory( $history );
        }
    }


    // $r = request();
    // $products = $r->get('products');
    
    // $ecom_prod_post = json_decode($post->products,true);

    // if( isset($products[0]) && isset($ecom_prod_post[0]) ){

    //     $ecom_prod_key_id = [];

    //     foreach($products as $prod){
    //         $ecom_prod_key_id[ $prod['id'] ] = $prod;
    //     }

    //     foreach( $ecom_prod_post as $key => $prod ){
    //         if( isset($ecom_prod_key_id[ $prod['id'] ]) && intval($ecom_prod_key_id[ $prod['id'] ]['quantity']) > 0 ){
    //             $ecom_prod_post[ $key ]['quantity'] = intval($ecom_prod_key_id[ $prod['id'] ]['quantity']);
    //         }
    //     }

    //     $post->products = json_encode($ecom_prod_post);

    // }else{
    //     $post->products = '';
    // }

});