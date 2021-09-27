<?php

$r = request();

$post_type = json_decode($r->getContent(),true);

if( isset($post_type['postType']) ){
	$post_type = $post_type['postType'];
}else{
	$post_type = 'page';
}

$page_home = get_posts($post_type,[
    'count'=>1000,
    'order'=>['created_at','asc'],
    'select'=>[\App\Vn4Model::$id,'title']
]);

if( count($page_home) ){
    $page_home = $page_home->keyBy(Vn4Model::$id);
}

return response()->json(['items'=>$page_home]);