<?php

add_filter('settings_link',function($settings_link) use ($plugin) {

	$settings_link[] = [
		'title'=>'Languages',
		'icon'=>'<i class="fa fa-language"></i>',
		'description'=>'Manage the languages your customers can view on your website',
		'submenu'=>[
            ['title'=>__p('Languages',$plugin->key_word),'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'languages','method'=>'languages'])],
            ['title'=>__p('Translate',$plugin->key_word),'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'translate','method'=>'index'])],
            ['title'=>__p('Post type',$plugin->key_word),'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'languages','method'=>'setting'])],
        ]
	];

	return $settings_link;

});
