<?php

$id = $r->all('id');

if( $id && $post = get_post('ecom_prod', $id) ){
    return [
        'post'=>$post
    ];
}

return [
    'post'=>[]
];