<?php

$id = $r->all('id');

if( $id && $post = get_post('ecom_prod_detail', $id) ){
    return [
        'post'=>$post
    ];
}

return [
    'post'=>[]
];