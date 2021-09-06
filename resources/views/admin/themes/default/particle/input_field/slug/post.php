<?php
$post_id = Request::get('post',false);

if( Request::get('action_post') !== 'edit' ){
	$post_id = false;
}

if( $input[$key] ){
	$input [ $key ] = registerSlug ( $input [ $key ], $type , $post_id );
}else{
	$input [ $key ] = registerSlug ( $input [ $value['key_slug'] ], $type , $post_id );
}
