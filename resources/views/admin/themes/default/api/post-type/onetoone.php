<?php

$admin_object = get_admin_object();

$postType = $r->get('postType');
$field = $r->get('field');
$configField = $admin_object[$postType]['fields'][$field];

unset( $admin_object[$configField['object']]['fields'][ $configField['field'] ] );

$result = [
    'config'=>$admin_object[$configField['object']],
    'post'=>[]
];

if( $postId = $r->get('postId') ){

    $post = get_post( $configField['object'], $postId );

    if( $post ){
        $result['post'] = $post;
    }

}

return $result;