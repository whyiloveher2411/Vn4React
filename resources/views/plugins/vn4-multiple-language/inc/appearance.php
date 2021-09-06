<?php



//register menu
add_action('register_nav_menus',function($menus){

	$languages = languages();

	$result = [];
	
	foreach ($menus as $key => $m) {
		foreach ($languages as $keyL => $l) {
			$result[$key.'-'.$l['lang_slug']] = $m.' ('.$l['lang_name'].')';
		}

		$result[$key.'-no-menu'] = 'no-menu';

	}
	return $result;

});


//admin image language after post when get post
add_action('appearance_menu_get_object_data',function($result, $type) use ($plugin) {

	$languages = languages();

	$customePostType = $plugin->getMeta('custom-post-types',[]);

	if( array_search($type, $customePostType) !== false ){
		foreach ($result as $key => $value) {
			if( isset($languages[$value->language]) ){
				$result[$key]->title .= ' - <img src="'.plugin_asset($plugin,'flags/'.$languages[$value->language]['flag'].'.png').'" > '.$languages[$value->language]['lang_name'];
			}
		}
	}

	return $result;
});


//register sidebar
add_action('register_sidebar',function($list_sidebar) use ($plugin) {

	$languages = languages();

	$siderbar_languages_current = Request::get('siderbar_languages');

	add_action('admin.master',function() use ($languages, $plugin, $siderbar_languages_current){


		$selectL = '<div class="dropdown" style="display:inline;"><a href="#" class="dropdown-toggle vn4-btn" data-toggle="dropdown" role="button" aria-expanded="false">Language <i class="fa fa-sort-desc" style="vertical-align: top;margin-top: 4px;"></i></a><ul class="dropdown-menu" role="menu" style="margin-top:8px;"><li><a href="#" onclick="window.location.href = \'?siderbar_languages=all\';return false;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All</a></li>';


		$languages = languages();
		foreach ($languages as $key => $value) {
			$selectL .= '<li><a href="?siderbar_languages='.$value['lang_slug'].'"><img title="'.$value['lang_name'].'" style="" src="'.plugin_asset($plugin,'flags/'.$value['flag'].'.png').'"> '.$value['lang_name'].'</a></li>';
		}
		$selectL .='</ul></div>';



		echo '<div class="x_panel" style=" border: 1px solid #e5e5e5; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04); box-shadow: 0 1px 1px rgba(0,0,0,.04);background:#fbfbfb;"><div class="x_content" style="height: 29px;padding:10px;margin:0;width:auto; box-sizing: content-box;"><span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;">'.__p('Select the language for a corresponding Sidebar version',$plugin->key_word).': </span>'.$selectL.'</div></div>';

	});

	if( $siderbar_languages_current === null || $siderbar_languages_current === 'all' ){
		
		$result = [];

		foreach ($list_sidebar as $key => $m) {

			$result[$key] = $m;

			foreach ($languages as $keyL => $l) {
				$result[$key.'-'.$l['lang_slug']] = array_merge($m,['title'=>$m['title'].' ('.$l['lang_name'].')']);
			}

		}

		return $result;

	}

	$result = [];

	foreach ($list_sidebar as $key => $m) {

		$result[$key.'-'.$languages[$siderbar_languages_current]['lang_slug']] = array_merge($m,['title'=>$m['title'].' ('.$languages[$siderbar_languages_current]['lang_name'].')']);

	}

	return $result;

});