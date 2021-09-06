<?php


function get_body_class( $class = '' ){
	return 'class="' . trim(implode( ' ', apply_filter('body_class',[$class]) )) . '"';
}

function add_body_class( $class ){

	add_filter('body_class',function($filter) use ($class) {

		if( is_string( $class ) ){

			if( false === array_search($class, $filter) ){
				$filter[] = $class;
			}

		}elseif( is_array( $class )){

			foreach ($class as $c) {
				if( false === array_search($c, $filter) ){
					$filter[] = $c;
				}
			}

		}

		return $filter;

	});

}

function vn4_register_style($id, $source, $version = 1, $media = 'all', $in_footer = false ){

	if( $in_footer ){
		$GLOBALS['vn4_footer_style'][] = '<link id="style-'.$id.'" href="'.$source.'?v='.$version.'" rel="stylesheet" media="'.$media.'">';
	}else{
		$GLOBALS['vn4_head_style'][] = '<link id="style-'.$id.'" href="'.$source.'?v='.$version.'" rel="stylesheet" media="'.$media.'">';
	}

	return true;
}

function vn4_register_script($id, $source, $version = 1, $in_footer = true, $attr = ''){

	if( $in_footer ){
		$GLOBALS['vn4_enqueue_scripts'][] = '<script id="script-'.$id.'" type="text/javascript" src="'.$source.'?v='.$version.'" '.$attr.' ></script>';
	}else{
		$GLOBALS['vn4_head_style'][] = '<script id="script-'.$id.'" type="text/javascript" src="'.$source.'?v='.$version.'" '.$attr.' ></script>';
	}

	return true;

}


function the_header($header = 'layout.header'){

	do_action('before_header');

	if(Auth::check()){
		echo vn4_view('admin.nav-top');
	}

	echo theme_view($header);

	do_action('after_header');
}

function the_footer($footer = 'layout.footer'){

	do_action('before_footer');

	echo theme_view($footer);


	if( isset($GLOBALS['vn4_enqueue_scripts'][0]) ){
		foreach ($GLOBALS['vn4_enqueue_scripts'] as $style) {
			echo $style;
		}
	}
	
	do_action('vn4_footer');

	return '';
}

function get_particle($particle, $parameters = array() ){

	do_action('get_particle'.$particle);
	return vn4_view('themes.'.theme_name().'.particle.'.$particle, $parameters);    

}

function vn4_head(){

	do_action('before_vn4_head');
	
	$list_meta = apply_filter('meta',[]);

	$title = do_action('title_head');
	
	if( !$title ) $title = setting('general_description','A simple website using Vn4CMS');

	$title = $title.' | '.theme_options('definition','title','Vn4CMS');

	$favicon = get_media(theme_options('definition','favicon',false),asset('uploads/favicon.png'));
	
	echo vn4_view('default.head',[
		'title'=>$title,
		'favicon'=>$favicon,
		'meta'=>$list_meta
	]);

	
	if( isset($GLOBALS['vn4_head_style'][0]) ){
		foreach ($GLOBALS['vn4_head_style'] as $style) {
			echo $style;
		}
	}

	do_action('vn4_head');

}



function get_paginate( $paginator ,$theme = null){

	if( $theme === null ){
 		$theme = 'default.paginate';
	}else{
		$theme = 'themes.'.theme_name().'.paginate.'.$theme;
	}

	return vn4_view($theme,['paginator'=>$paginator]);
}

function get_language_attributes(){
	return 'lang="'.App::getLocale().'"';
}

function vn4_nav_menu($key, $view = null, $argParam = [], $name_cache = null){

	$argParam['key'] = $key;

	$key2 = do_action('vn4_nav_menu',$key);

	if( $key2 ) $key = $key2;

	if( !$name_cache ) $name_cache = 'menu - '.$key.$view;


	return cache_tag( 'menu', $name_cache, function() use($key,$view,$argParam){

		$theme = theme_name();

		$obj = (new Vn4Model(vn4_tbpf().'menu'))->where('key_word',$key)->first();

		if( !$obj ){

			$list_menu = [];

		}else{

			$list_menu = json_decode($obj->json,true);

		}

		$list_menu = vn4_get_list_nav($list_menu);

		if( !isset($list_menu[0]) ){
			$list_menu = [];
		}

		if( $view === null ){
			$result = vn4_view('default.nav',['menu'=>$list_menu, 'arg' => $argParam]);
		}else{
			$result = vn4_view('themes.'.theme_name().'.nav.'.$view ,['menu'=>$list_menu,'arg' => $argParam ]);
		}
			
		return $result;

	});
}

function vn4_nav_menu_db($key, $view = null, $argParam = [], $name_cache = null){

	$argParam['key'] = $key;

	if( !$name_cache ) $name_cache = 'menu - '.$key;

	return cache_tag( 'menu', $name_cache, function() use($key,$view,$argParam) {

		$theme = theme_name();

		$obj = (new Vn4Model(vn4_tbpf().'menu'))->where(Vn4Model::$id,$key)->first();

		if( !$obj ){

			$list_menu = [];

		}else{

			$list_menu = json_decode($obj->json,true);

		}

		$list_menu = vn4_get_list_nav($list_menu);

		if( !isset($list_menu[0]) ){
			$list_menu = [];
		}

		if( is_callable($view) ){

			$result = $view($list_menu,[ $argParam ]);

		}else{

			if( $view === null ){
				$result = vn4_view('default.nav',['menu'=>$list_menu, 'arg' => $argParam]);
			}else{
				$result = vn4_view('themes.'.theme_name().'.nav.'.$view ,['menu'=>$list_menu,'arg' => $argParam ]);
			}
			
		}

		return $result;

	});
}

function vn4_get_list_nav($list_menu){

	if( !is_array($list_menu) ) return [];
	
	$count = count($list_menu);

	for ($i=0; $i < $count; $i++) { 

		$attributes = ( isset($list_menu[$i]['attrtitle']) && $list_menu[$i]['attrtitle'] )?' title="'.$list_menu[$i]['attrtitle'].'"':'';
		$attributes .= ( isset($list_menu[$i]['target']) && $list_menu[$i]['target'] )?' target="'.$list_menu[$i]['target'].'"':'';
		$attributes .= ( isset($list_menu[$i]['xfn']) && $list_menu[$i]['xfn'] )?' rel="'.$list_menu[$i]['xfn'].'" ':' ';
		$attributes .= ( isset($list_menu[$i]['classes']) && $list_menu[$i]['classes'] )?' class="'.$list_menu[$i]['classes'].'"':'';

		$list_menu[$i]['link'] = get_link_menu($list_menu[$i]);
		$attributes .= ' href="'.$list_menu[$i]['link'].'"';

		$list_menu[$i]['attributes'] = $attributes;

		if( isset($list_menu[$i]['children']) ){
			$list_menu[$i]['children'] = vn4_get_list_nav($list_menu[$i]['children']);
		}

	}
	return $list_menu;
}


function get_link_menu($menu_item){
	$menuType = $menu_item['posttype']??'custom links';

	switch ($menuType) {
		case 'custom links':
			$link = $menu_item['links'];
			break;
		case 'page-theme':
			$link = route('page',$menu_item['page']);
			break;

		case 'route-static':
			$link = route($menu_item['route']);
			break;
		default:

			if( isset($menu_item['id']) ){
				$post = get_post($menu_item['posttype'],$menu_item['id']);

				if( !$post ){
					return '';
				}

				$link = get_permalinks($post);
			}else{
				return '';
			}
			

			break;
	}

	$link2 = do_action('get_link_menu',$link, $menuType, $menu_item);

	if( $link2 ) $link = $link2;

	return $link;

}

function get_sidebar($key, $view ){

	$key2 = do_action('get_sidebar',$key);

	if( $key2 ) $key = $key2;

	$theme_name = theme_name();

	return cache_tag('sidebar', 'sidebar - '.$key.'.'.$view, function() use ($key,$theme_name, $view){
		$sidebar =  DB::table(vn4_tbpf().'widget')->where('sidebar_id',$key)->where('theme',$theme_name)->first();

		if( $sidebar ){

			$html = json_decode($sidebar->html);

			$result = vn4_view('themes.'.$theme_name.'.sidebar.'.$view ,['sidebar'=>$sidebar,'widgets'=>$html]);

			return $result;
		}

		return '';
	});
}

function get_content($post, $key){

	use_module('read_html');

	$html = str_get_html($post->{$key});

	if(!$html) return '';
        
	$widgets = $html->find('.widget');

	$widgetsDefine = \CMS\Widget\Model\Widget::all();

	// dd($widgetsDefine);

	foreach( $widgets as $index => $widget){

		$data = json_decode( html_entity_decode($widget->data),true );
		
		$widgetHtml = '';

		if( isset( $widgetsDefine[ $data['__widget_type'] ] ) ){

			$widgetHtml = vn4_view('themes.'.theme_name().'.'.$widgetsDefine[ $data['__widget_type'] ]['template'],$data);
			// dd($widgets[$index]);
			// $widgets[$index] = str_get_html($widgetHtml);

			$html = str_replace($widgets[ $index ], $widgetHtml, $html);
		}

		
	}

	return $html.'';
}


add_shortcode('route', function($param, $content){

	extract( shortcode_atts([
    'name'=>false,
    ], $param) );
	$name = $param['name'];

	if( $name ){
		unset($param['name']);
		return '<a href="'.route($name,$param).'">'.$content.'</a>';
   	}

});


/**
	Template
*/
function get_single_post( $post, $arg = array() ){

	$arg['post'] = $post;

	if( $post->visibility === 'password' && session($post->type.'_password_'.$post->id,false) !== $post->password ) return vn4_view('default.post-type.post-protected',$arg);

	$theme_name = theme_name();

	if( view()->exists('themes.'.$theme_name.'.post-type.'.$post->type.'-single-'.$post->id ) ) {
		$view = 'themes.'.$theme_name.'.post-type.'.$post->type.'-single-'.$post->id;
	}elseif( view()->exists('themes.'.$theme_name.'.post-type.'.$post->type.'-single-'.$post->slug ) ) {
		$view = 'themes.'.$theme_name.'.post-type.'.$post->type.'-single-'.$post->slug;
	}elseif( view()->exists('themes.'.$theme_name.'.post-type.'.$post->type.'-single' ) ){
		$view = 'themes.'.$theme_name.'.post-type.'.$post->type.'-single';
	}else{
		$view = false;
	}

	if( $view !== false ) return vn4_view($view,$arg);

	return;

}

function get_link($data){
	if( !is_array($data) ){
		$data = json_decode($data,true);
	}

	if( isset($data['type']) ){
		
		if( $data['type'] === 'post-detail' && $post = get_post($data['post_type'],$data['id']) ){
			return get_permalinks($post);
		}

		if( $data['type'] === 'page' && isset($data['page']) ){
			return route('page',$data['page']);
		}

		return $data['link'];
	}

	return '#';
}


/**
	POST
*/
function view_post( $post, $slug_detail = '' ){
	
	if( $slug_detail ){
		$slug_detail = '.detail.'.$slug_detail;
	}

	if( !$post->exists ){
		return errorPage(404,'Page note found');
	}

	if( $post->visibility === 'password' &&  Session::get($post->type.'_password_'.$post->id, false) !== $post->password ) return redirect()->back();

	$theme_name = theme_name();

	load_shortcode_posttype();

	$view = '';

	if( view()->exists( $view = 'themes.'.$theme_name.'.post-type.'.$post->type.'-'.$post->id.$slug_detail ) ) {

	}elseif( view()->exists($view = 'themes.'.$theme_name.'.post-type.'.$post->type.'-'.$post->slug.$slug_detail ) ) {

	}

	if( !view()->exists($view) ){

		if( $post->template && view()->exists( $view =  'themes.'.$theme_name.'.post-type.'.$post->type.'.'.$post->template.$slug_detail ) ){

		}else{
			$view = 'themes.'.$theme_name.'.post-type.'.$post->type.$slug_detail;
		}
	}

	if( !view()->exists($view) ){

		return errorPage(404,'Page note found',__('This custom post does not exist in the view file ').': '.$view );
	}

	add_body_class(['post-detail',$post->type]);

	$title = do_action('title_head');
	if( !$title ) title_head($post->title);

	$GLOBALS['post_current'] = $post;

	add_action('vn4_adminbar',function() use ($post) {
		echo '<li class="li-title"><a href="'.route('admin.create_data',['type'=>$post->type,'post'=>$post->id,'action_post'=>'edit','rel'=>'vn4-adminbar']).'" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i>'.__('Edit Post').'</a></li>';
	});

	return vn4_view($view,['post'=>$post]);
}





