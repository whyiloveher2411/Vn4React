<?php

function acp_get_field($post, $key, $default = null){
	return $post->getMeta('aptp_meta_post_'.$key,$default);
}

add_action('__Vn4Model_function__get',function($data, $post, $name){
	return $post->getMeta('aptp_meta_post_'.$name,null);
});