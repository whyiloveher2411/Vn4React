<?php


add_filter('list_widget',function($list_widgets){

	$list_widgets['wiget-theme'] = [
		'title'=>'Widget By Theme',
		'description'=>'Widget Create By Theme Demo',
		'fields'=>[
			'content'=>[
				'title'=>'Content',
				'view'=>'editor',
			]
		],
	 	'show'=>function($data){
	 		return $data->get_data('content');
      	}
	];

	return $list_widgets;
});