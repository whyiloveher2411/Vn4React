<?php

unset($input[$key]);

add_action('api_save_post_type',function($post) use ($key, $user, $value) {
    
	$request = request();

    $sharedData = [ 'author', 'editor', 'template', 'order', 'status', 'status_old', 'starred', 'update_count', 'password', 'post_date_gmt', 'visibility', 'is_homepage', 'ip',];

    $inputShare = $request->only($sharedData);

    $inputPost = $request->all();

    if( isset($inputPost[$key]) ){

        $inputPost = array_merge( $inputPost, $inputPost[$key], $inputShare )  ;

        $inputPost[Vn4Model::$id] = $post->id;
        unset( $inputPost[$key] );
        unset( $inputPost['meta']);
        unset( $inputPost['update_count']);
        unset( $inputPost['created_at']);
        unset( $inputPost['updated_at']);
        unset( $inputPost['created_time']);
        unset( $inputPost['updated_time']);
        unset( $inputPost['is_homepage']);

        $post = newOrEdit($inputPost, $value['object'], $user);

    }

    return $post;

},'add_post_onetoone_'.$key,true);




// dd($r->all());