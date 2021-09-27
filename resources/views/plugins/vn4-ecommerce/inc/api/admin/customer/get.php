<?php

$id = $r->get('id');

if( $id && $customer = get_post('ecom_customer', $id) ){

    return [
        'customer'=>$customer
    ];

}

return ['message'=>apiMessage('No customers found')];