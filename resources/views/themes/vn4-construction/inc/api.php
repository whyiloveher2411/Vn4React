<?php

Route::any('post_type/{type}',function($type){

	// sleep(25);

	$r = request();

	$param = json_decode($r->getContent(),true);

	$rowsPerPage = $param['rowsPerPage']??2;
	$page = ($param['page']??0 ) + 1;

	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
        return $page;
    });

	$post_type = get_admin_object($type);

	$posts = Vn4Model::table($post_type['table'])->where('type',$type)->orderBy('id','desc');

	if( isset($param['search']) && $param['search'] ){

		$posts = $posts->where('title','LIKE','%'.$param['search'].'%');

	}

	$posts = $posts->paginate($rowsPerPage);

	// $posts = get_posts($type, ['count'=>10,'paginate'=>'page']);

	// $config = ['fields'=>[]];

	// foreach ($post_type['fields'] as $key => $value) {

	// 	if( !isset($value['show_data']) || $value['show_data'] ){
	// 		$config['fields'][] = [
	// 			'key'=>$key,
	// 			'title'=>$value['title'],
	// 			'view'=>$value['view']
	// 		];
	// 	}
	// }

	$post_type['label'] = [
		'allItems'=>'All Posts',
		'name'=>'Blogs',
		'singularName'=>'Blog',
	];

	// $message = [
	// 	'content'=>'Hello message',
	// 	'options'=>[
	// 		'variant'=>'success',
	// 		'anchorOrigin'=>[
	// 			'vertical'=>'bottom',
	// 			'horizontal'=>'left'
	// 		]
	// 	]
	// ];

	return response()->json(['config'=>$post_type,'rows'=>$posts]);

});


Route::any('post_type/relationship/{type}',function($type){

	$post_type = get_admin_object($type);

	$posts = Vn4Model::table($post_type['table'])->where('type',$type)->orderBy('id','desc')->get();

	return response()->json(['rows'=>$posts]);

});

Route::any('menu',function(){

	$obj = new Vn4Model(vn4_tbpf().'menu');

    $theme = theme_name();

    $list_option = $obj->where('type','menu_item')->where('status',1)->orderBy('title','asc')->get();
    
    return ['rows'=>$list_option];
});



Route::any('post_type/{type}/{id}',function($type, $id){

	// sleep(25);

	$r = request();

	$post_type = get_admin_object($type);

	$post = Vn4Model::table($post_type['table'])->where('type',$type)->where('id',$id)->first();


	// $param = json_decode($r->getContent(),true);

	// $rowsPerPage = $param['rowsPerPage']??2;
	// $page = ($param['page']??0 ) + 1;

	// Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
 //        return $page;
 //    });

	// $posts = Vn4Model::table($post_type['table'])->where('type',$type)->paginate($rowsPerPage);

	// $posts = get_posts($type, ['count'=>10,'paginate'=>'page']);

	$config = ['fields'=>[]];

	foreach ($post_type['fields'] as $key => $value) {

		if( !isset($value['show_data']) || $value['show_data'] ){
			$config['fields'][] = [
				'key'=>$key,
				'title'=>$value['title'],
				'view'=>$value['view']
			];
		}
	}

	$config['label'] = [
		'allItems'=>'All Posts',
		'name'=>'Blogs',
		'singularName'=>'Blog',
	];

	// $message = [
	// 	'content'=>'Hello message',
	// 	'options'=>[
	// 		'variant'=>'success',
	// 		'anchorOrigin'=>[
	// 			'vertical'=>'bottom',
	// 			'horizontal'=>'left'
	// 		]
	// 	]
	// ];

	return response()->json(['config'=>$post_type,'post'=>$post]);

});


Route::any('login',function(){

	$r = request();

	$input = json_decode($r->getContent(),true);

	 if( $user = Vn4Model::table('vn4_user')->where('email',trim($input['username']))->where('status','publish')->first() ){
        if (Hash::check( $input['password'] , $user->password)) {
        	return [
        		'user'=>$user,
		   		'message'=> apiMessage('Success')
		   	];
        }
    }

   	return [
   		'message'=>apiMessage('Error','error')
   	];


});


Route::any('post/{type}',function($type){

	

});