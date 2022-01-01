<?php

register_post_type(function($list_post_type){

	$add_object = [];

	// $add_object['plugin_demo'] = [
	//     'table'=>'plugin_demo',
	//     'title'=> 'Plugin Demo',
	//     'fields'=>[
	//         'title'=>[
	//             'title'=>__('Title'),
	//             'view'=>'text',
	//         ],
	//         'slug' => [
	//             'title'=>__('Slug'),
	//             'view' =>'slug',
	//             'key_slug'=>'title',
	//         ],
	//         'description' => [
	//             'title'=>__('Description'),
	//             'view' =>'textarea',
	//             'show_data'=>false,
	//         ],
	//         'content' => [
	//             'title'=>__('Content'),
	//             'view' =>'editor',
	//             'show_data'=>false,
	//         ],
	//     ],
	// ];

	return $add_object;

});
