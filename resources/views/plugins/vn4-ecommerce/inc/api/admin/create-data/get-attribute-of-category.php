<?php

$post = get_post('ecom_prod_cate', $r->get('value'));

if( $post ){
    return json_decode($post->groups_attribute);
}

return [];
