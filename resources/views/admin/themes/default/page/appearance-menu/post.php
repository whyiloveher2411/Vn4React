<?php

$input = $r->all();

$theme = theme_name();

//Create new menu
if( $r->has('create_new_menu') && $r->has('name') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$newMenu = new Vn4Model(vn4_tbpf().'menu');

	$newMenu->title = $input['name'];
	$newMenu->json = '[]';
	$newMenu->status = 1;
	$newMenu->type = 'menu_item';
	$newMenu->key_word = Auth::user()->id.'_'.time().'_'.str_random(20);
	$newMenu->theme = $theme;
	$newMenu->save();

	vn4_create_session_message( __('Success'), __('Create menu success'), 'success', true );
	return response()->json(['url_redirect'=>route('admin.page',['page'=>$page,'id'=>$newMenu->id])]);

}

$plugins = plugins();

foreach ($plugins as $plugin) {

  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/appearance.php')) ){
    include $file;
  }

}

if( file_exists($file = cms_path('resource','views/themes/'.theme_name().'/inc/appearance.php') )) {
   include $file;
}

//Edit menu
if( $r->has('edit_menu') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$menu = Vn4Model::firstOrAddnew(vn4_tbpf().'menu',[Vn4Model::$id=>$input['id']]);

	if( !$menu ){
		return response()->json(['message'=>'Menu not found']);
	}

	$content_menu = $input['menu_item'];

	// dd($input);
	$menu->title = $input['name'];
	$menu->json = $content_menu;
	$menu->save();

	$setting_menu = array_flip( $r->get('setting_menu',[]) );


	$menusFilter = apply_filter('register_nav_menus',[]);

    $menusFilter2 = do_action('register_nav_menus',$menusFilter);

    if( $menusFilter2 ) $menusFilter = $menusFilter2;
    // dd($menusFilter);
	foreach ($menusFilter as $key => $m) {

		if( $m !== 'no-menu' ){
			$menu_filter = Vn4Model::firstOrAddnew(vn4_tbpf().'menu',['title'=>$m,'key_word'=>$key,'type'=>'menu']);

			if( isset($setting_menu[$key]) ){
				$menu_filter->json = $content_menu;
				$menu_filter->content = $menu->id;
			}elseif( $menu_filter->content == $menu->id ){
				$menu_filter->json = '[]';
				$menu_filter->content = '';
			}
			
			Cache::forget('menu - '.$menu_filter->key_word);

			$menu_filter->save();
		}
		
	}

	$list_nav_config = DB::table(vn4_tbpf().'menu')->whereType('menu')->whereIn('key_word',array_keys($menusFilter))->get();

	$list_content_menu_item = [];

	foreach ($list_nav_config as $nav) {
		$nav = (array)$nav;
		if( isset($nav['content']) ){
			$list_content_menu_item[$nav['content']][$nav['key_word']] = $nav['title'];
		}
			
	}

	$list_nav_menu_item = (new Vn4Model(vn4_tbpf().'menu'))->whereType('menu_item')->get();

	foreach ($list_nav_menu_item as $nav) {

		if( isset($list_content_menu_item[$nav->id]) ){
			$nav->content = json_encode($list_content_menu_item[$nav->id]);
		}else{
			$nav->content = '[]';
		}
		$nav->setTable(vn4_tbpf().'menu');
		$nav->save();
	}

	cache_tag('menu',null,'clear');

	vn4_create_session_message( __('Success'), __('Edit menu success'), 'success', true );
	return response()->json(['url_redirect'=>route('admin.page',['page'=>$page,'id'=>$input['id']])]);
}

// Delte menu
if( $id_delete = $r->get('delete_menu') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$menusFilter = apply_filter('register_nav_menus',[]);
    $menusFilter2 = do_action('register_nav_menus',$menusFilter);

    if( $menusFilter2 ) $menusFilter = $menusFilter2;

    $menusFilter = (new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',array_keys($menusFilter))->get();

	foreach ($menusFilter as $m) {

		if( $m->content === $id_delete ){
			$m->json = '[]';
			$m->content = '';
		}
		
		$m->save();
		
	}

	$menu = Vn4Model::seek(vn4_tbpf().'menu',$id_delete);

	$menu->delete();

	cache_tag('menu',null,'clear');

	vn4_create_session_message( __('Success'), __('Delete menu success'), 'success', true );
	return response()->json(['url_redirect'=>route('admin.page',['page'=>$page])]);
}

// Mange Locations
if( $manage_location = $r->get('manage_location') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}
	
	$key = array_keys($manage_location);

	$table = vn4_tbpf().'menu';

	$menus = (new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',$key)->get();
	$menus_item = (new Vn4Model(vn4_tbpf().'menu'))->whereIn(Vn4Model::$id,$manage_location)->pluck('json',Vn4Model::$id);

	$menu_item_contents = [];

	foreach ($menus as $value) {
	
		$value->setTable($table);

		if( isset($manage_location[$value->key_word]) && isset($menus_item[$manage_location[$value->key_word]]) ){

			$menu_item_contents[$manage_location[$value->key_word]][$value->key_word] = $value->title;

			$value->content = $manage_location[$value->key_word];
			$value->json = $menus_item[$value->content];
		}else{
			$value->content = '';
			$value->json = '[]';
		}
		

		$value->save();

	}

	$menus_item = (new Vn4Model(vn4_tbpf().'menu'))->whereType('menu_item')->get();

	foreach ($menus_item as $value) {
		$value->setTable($table);
		
		if( isset($menu_item_contents[$value->id.'']) ){
			$value->content = json_encode($menu_item_contents[$value->id.'']);
		}else{
			$value->content = '';
		}

		$value->save();
	}

	vn4_create_session_message( __('Success'), __('Edit location menu success'), 'success', true );
	return response()->json(['url_redirect'=>route('admin.page',['page'=>$page,'vn4-tab-top-'=>'manage-locations'])]);
}

$type = $input['type'];


//add menu item
if($type === 'add menu item'){

	$key = $input['key'];

	$html = '';

	$menu_add_filter = apply_filter('appearance-menu');

	if( isset($menu_add_filter[$key]) ){
		$html = $menu_add_filter[$key]['form_attr']();
	}else{

		switch ($key) {

			case 'custom links':
				$param = [
					'label'=>$input['label'],
					'label_type'=>__('Custom Links'),
					'links'=>$input['links'],
					'strData'=>' data-label="'.$input['label'].'" data-links="'.$input['links'].'" data-posttype="'.$key.'" ',
					'menu_type'=>$key,
					'class' => 'custom-links'
				];

				$param['param'] = $param;

				$html = vn4_view(backend_theme('page.appearance-menu.item-menu'),$param);
			break;

			case 'menu-items':

				$label_type = __('Menu Items');

				$obj = new Vn4Model(vn4_tbpf().'menu');

        		$theme = theme_name();

				foreach ($input['list_object'] as  $value) {
					$label = $obj->where(Vn4Model::$id,$value)->first()->title;

					$param = [
						'strData'=>' data-id="'.$value.'" data-posttype="menu-items" data-label="Menu: '.$label.'"',
						'label'=>'Menu: '.$label,
						'label_type'=>$label_type,
						'menu_type'=>$key,
						'class' => 'menu-items'
					];
					$param['param'] = $param;

					$html = $html.view(backend_theme('page.appearance-menu.item-menu'),$param);

				}
				
				break;
			case 'page-theme':


				$label_type = __('Page Theme');

				foreach ($input['list_object'] as  $value) {

					if( view()->exists( 'themes.'.theme_name().'.page.'.str_replace('.blade.php', '', $value) ) ) {

						$label = ucwords( preg_replace('/-/', ' ', str_slug(str_replace('.blade.php', '', $value)) )  );
						$page = str_replace('.blade.php', '', $value);

						$param = [
							'strData'=>' data-page="'.$page.'" data-posttype="page-theme" data-label="'.$label.'"',
							'label'=>$label,
							'label_type'=>$label_type,
							'menu_type'=>$key,
							'class' => 'page-theme'
						];

						$param['param'] = $param;

						$html = $html.view(backend_theme('page.appearance-menu.item-menu'),$param);

					}

				}
			break;
			case 'route-static':

				$label_type = __('Route Static');

				$lableRoute = ['index'=>'Home','error404'=>'Error 404'];

				foreach ($input['list_object'] as  $value) {

					$param = [
							'strData'=>' data-route="'.$value.'" data-posttype="route-static" data-label="'.$lableRoute[$value].'"',
							'label'=>$lableRoute[$value],
							'label_type'=>$label_type,
							'menu_type'=>$key,
							'class' => 'post-type'
						];

					$param['param'] = $param;

					$html = $html.view(backend_theme('page.appearance-menu.item-menu'),$param);

				}

			break;
			default:

				$label_type = $this->object->{$input['key']}['title'];

				foreach ($input['list_object'] as  $value) {

					$post = get_post($key,$value);

					if($post){

						$param = [
							'strData'=>'  data-slug="'.$post->slug.'" data-posttype="'.$post->type.'" data-label="'.$post->title.'" data-id="'.$post->id.'" ',
							'label'=>$post->title,
							'label_type'=>$label_type,
							'menu_type'=>$key,
							'class' => 'page-static'
						];

						$param['param'] = $param;

						$html = $html.view(backend_theme('page.appearance-menu.item-menu'),$param);

					}

				}
			break;
		}
	}


	return response()->json(['append'=>[['selector'=>$input['selector'],'html'=>$html]]]);

}



// //create menu
if($type === 'get object data'){

	if( $input['object_type'] === 'page-theme' ){

		if( file_exists(cms_path('resource','views/themes/'.theme_name().'/page')) ) {
			$files = File::allFiles(cms_path('resource','views/themes/'.theme_name().'/page'));
			$result = [];
			foreach ($files as $page) {

				if( strpos($page->getRelativePathname(), '.blade.php') ){

					$v = basename($page,'.blade.php');
	              
					$name = explode('/', $page->getFilename());

					$name = substr(end($name), 0, -10);

					$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));

					preg_match( '|Page Name:(.*)$|mi', file_get_contents( $page->getRealPath() ), $header );

					if( isset($header[1]) ){
					  $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
					}

					$result[] = [Vn4Model::$id=>$page->getRelativePathname(),'page-name'=>substr($page->getRelativePathname(), 0, -10), 'title'=>$name ];
				}
			}

		}else{
			$result = [];
		}

	}else{
		$result = get_posts($input['object_type'],1000);

		$result2 = do_action('appearance_menu_get_object_data',$result, $input['object_type']);

		if( $result2 ) $result = $result2;
	}

	return response()->json(['result'=>$result]);

}


