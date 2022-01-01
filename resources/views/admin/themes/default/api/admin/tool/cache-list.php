<?php

return [
	'all'=>[
		'title'=>'All',
		'description'=>'All cache on all website',
		'type'=>'Database, HTML,...',
		'creator'=>'System',
		'flush'=>function(){
			
			Cache::flush();

			// if( !function_exists('clear_all_cached_Dir') ){
			// 	function clear_all_cached_Dir($dirPath) {
			// 	    if (! is_dir($dirPath)) {
			// 	        throw new InvalidArgumentException("$dirPath must be a directory");
			// 	    }
			// 	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			// 	        $dirPath .= '/';
			// 	    }
			// 	    $files = glob($dirPath . '*', GLOB_MARK);
			// 	    foreach ($files as $file) {
			// 	        if (is_dir($file)) {
			// 	            clear_all_cached_Dir($file);
			// 	        } else {
			// 	            unlink($file);
			// 	        }
			// 	    }
			// 	    rmdir($dirPath);
			// 	}
			// }
			// clear_all_cached_Dir(cms_path('storage', 'framework/cache/'));
		}
	],
	'curd'=>[
		'title'=>'Post Type (CURD)',
		'description'=>'Array Config Post Type',
		'type'=>'Config',
		'creator'=>'System',
		'flush'=>function(){
			cache_tag('curd',null,'clear');
		}
	],
	'settings'=>[
		'title'=>'Settings',
		'description'=>'Website settings',
		'type'=>'Database',
		'creator'=>'System',
		'flush'=>function(){

			$settings = (new Vn4Model(vn4_tbpf().'setting'))->whereType('setting')->pluck('id','key_word');

			foreach ($settings as $key => $s) {
				Cache::forget('setting.'.$key);
			}

			Cache::forget('setting.');
		}
	],
	'theme_option'=>[
		'title'=>'Theme option',
		'description'=>'Website theme options',
		'type'=>'Database',
		'creator'=>'System',
		'flush'=>function(){

			$theme_name = theme_name();

			$theme_options = (new Vn4Model(vn4_tbpf().'theme_option'))->pluck('id','key');

			foreach ($theme_options as $key => $s) {
				Cache::forget('theme-options.'.$key);
			}

		}
	],
	'layout'=>[
		'title'=>'Menu, sidebar',
		'description'=>'Layout menu, sidebar, header, footer...',
		'type'=>'HTML, Database, Layout',
		'creator'=>'System',
		'flush'=>function(){
			cache_tag('menu',null,'clear');
			cache_tag('sidebar',null,'clear');
		}
	]
];