<?php

$post = get_post('ecom_prod_spec_sets', $r->get('value'));

if( $post ){
    return json_decode($post->specifications);
}

return [];
