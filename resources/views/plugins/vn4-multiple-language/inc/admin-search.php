<?php

return [
	'language'=>['title'=>'Plugin Multi Language','callback' => function( $searchArray, $searchString ) use ($plugin){

		return [
			[
				'title_type'=>'Language',
				'title'=>'Languages',
				'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'languages','method'=>'languages']),
			],
			[
				'title_type'=>'Language',
				'title'=>'Setting',
				'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'languages','method'=>'setting']),
			],
			[
				'title_type'=>'Language',
				'title'=>'Translate',
				'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'translate','method'=>'index']),
			],
			[
				'title_type'=>'Language',
				'title'=>'Refesh File Lang',
				'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'translate','method'=>'refesh']),
			],
			[
				'title'=>'Create Connect Post',
				'title_type'=>'Language',
				'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'create-connect-post']),
			],
		];
		

	}]
];