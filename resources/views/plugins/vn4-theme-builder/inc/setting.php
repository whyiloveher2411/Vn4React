<?php 
add_filter('settings_link',function($settings_link) use ($plugin) {

	$settings_link[] = [
		'title'=>'SEO',
		'link'=>route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'setting','method'=>'index']),
		'icon'=>'<i class="fa fa-share-alt"></i>',
		'popup'=>true,
		'description'=>'Setting seo admin as webmaster tools as well as sitemap'
	];

	return $settings_link;
});
