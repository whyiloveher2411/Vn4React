<?php

return [
	'get-homepage'=>function($r){
		$post_type = $r->get('post-type','page');

		$page_home = get_posts($post_type,[
            'count'=>1000,
            'order'=>['created_at','asc'],
            'select'=>[\App\Vn4Model::$id,'title']
        ]);

		return response()->json(['items'=>$page_home]);
	}
];