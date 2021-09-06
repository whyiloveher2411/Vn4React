<?php

Route::get('index', ['as'=>'api_index','uses'=>function(){
	dd(1);	
}]);

Route::get('post/{slug}',['as'=>'api_post_detail','uses'=>function($slug){
	$post = getPostBySlug('pnj_post',$slug);

	if( $post ){
		unset($post->ip);
		unset($post->pnj_category_detail);
		unset($post->is_homepage);
		unset($post->meta);
		unset($post->order);
		unset($post->password);
		unset($post->post_date_gmt);
		unset($post->starred);
		unset($post->status_old);
		unset($post->type);
		unset($post->updated_time);
		unset($post->visibility);
		unset($post->updated_at);
		unset($post->template);
		unset($post->status);
		unset($post->author);


		$cat = get_post('pnj_category',$post->pnj_category);

		unset($cat->ip);
		unset($cat->created_time);
		unset($cat->is_homepage);
		unset($cat->meta);
		unset($cat->order);
		unset($cat->password);
		unset($cat->post_date_gmt);
		unset($cat->starred);
		unset($cat->status_old);
		unset($cat->type);
		unset($cat->updated_time);
		unset($cat->content);
		unset($cat->visibility);
		unset($cat->updated_at);
		unset($cat->template);
		unset($cat->status);
		unset($cat->author);

		$post->category = $cat;
		unset($post->pnj_category);


		return response()->json($post);
	}else{
		return response()->json(['error'=>true,'message'=>'Post not found.']);
	}
}]);


Route::get('post', ['as'=>'api_posts','uses'=>function(){

	Cache::forget('pnj_posts');

	return response()->json(['data'=> Cache::rememberForever('pnj_posts',function(){
		$posts = get_posts('pnj_post');

		foreach ($posts as $key => $value) {
			unset($posts[$key]->ip);
			unset($posts[$key]->pnj_category_detail);
			unset($posts[$key]->is_homepage);
			unset($posts[$key]->meta);
			unset($posts[$key]->order);
			unset($posts[$key]->password);
			unset($posts[$key]->post_date_gmt);
			unset($posts[$key]->starred);
			unset($posts[$key]->status_old);
			unset($posts[$key]->type);
			unset($posts[$key]->updated_time);
			unset($posts[$key]->content);
			unset($posts[$key]->visibility);
			unset($posts[$key]->updated_at);
			unset($posts[$key]->template);
			unset($posts[$key]->status);
			unset($posts[$key]->author);
			$posts[$key]->featured = get_media($value->featured);


			$cat = get_post('pnj_category',$value->pnj_category);

			unset($cat->ip);
			unset($cat->created_time);
			unset($cat->is_homepage);
			unset($cat->meta);
			unset($cat->order);
			unset($cat->password);
			unset($cat->post_date_gmt);
			unset($cat->starred);
			unset($cat->status_old);
			unset($cat->type);
			unset($cat->updated_time);
			unset($cat->content);
			unset($cat->visibility);
			unset($cat->updated_at);
			unset($cat->template);
			unset($cat->status);
			unset($cat->author);

			$posts[$key]->category = $cat;
			unset($posts[$key]->pnj_category);
		}



		return $posts;
	})]);
}]);
