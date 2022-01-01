<?php
$r = request();

$input =  $r->all();

$theme = theme_name();

$result = [];

$menusLocaltion = apply_filter('register_nav_menus',[]);
$menusLocaltion = do_action('register_nav_menus',$menusLocaltion);

// CREATE MENU NEW
if( $param1 === 'create' && isset($input['name']) && $input['name'] ){

	$newMenu = new Vn4Model(vn4_tbpf().'menu');
	$newMenu->title = $input['name'];
	$newMenu->content = $input['description'];
	$newMenu->json = '[]';
	$newMenu->status = 1;
	$newMenu->type = 'menu_item';
	$newMenu->key_word = '_'.time().'_'.str_random(20);
	$newMenu->theme = $theme;
	$newMenu->save();

}


// DELETE MENU
if( $param1 === 'delete' && isset($input['id']) && $input['id'] ){

    if( config('app.EXPERIENCE_MODE') ){
		return experience_mode();
	}

    $menusFilter = (new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',array_keys($menusLocaltion))->get();

	foreach ($menusFilter as $m) {
		if( $m->content == $input['id'] ){
			$m->json = '[]';
			$m->content = '';
		}
		
		$m->save();
		Cache::forget('menu - '.$m->key_word);
		
	}


	$menu = Vn4Model::seek(vn4_tbpf().'menu',$input['id']);

	$menu->delete();

    cache_tag('menu',null,'clear');
    	
    $result['message'] = apiMessage('Delete Success');
}

// UPDATE MENU
if( $param1 === 'update' && isset($input['menuItem']) && $input['menuItem'] ){

    foreach( $input['menuItem'] as $menuRequest){

        $menu = Vn4Model::firstOrAddnew(vn4_tbpf().'menu',[Vn4Model::$id => $menuRequest['id']]);
        if( $menu ){
            $menu->title = $menuRequest['title'];
            $menu->json = json_encode($menuRequest['json']);
            $menu->save();
        }
    }

    $result['message'] = apiMessage('Update Menu Success');

	foreach ($input['location'] as $key => $location) {

		$menu_filter = Vn4Model::firstOrAddnew(vn4_tbpf().'menu',['title'=>$location['title'],'key_word'=>$key,'type'=>'menu']);

		if( isset($location['contentMenu']) && $location['contentMenu'] ){

			$menuItem = (new Vn4Model(vn4_tbpf().'menu'))->where(Vn4Model::$id,$location['contentMenu'])->where('type','menu_item')->first();

			if( $menuItem ){
				$menu_filter->json = $menuItem->json;
				$menu_filter->content = $menuItem->id;
			}else{
				$menu_filter->json = '[]';
				$menu_filter->content = '';
			}
		}else{
			$menu_filter->json = '[]';
			$menu_filter->content = '';
		}

		$menu_filter->save();
		Cache::forget('menu - '.$menu_filter->key_word);

	}
}

$obj = new Vn4Model(vn4_tbpf().'menu');

$menus = $obj->where('type','menu_item')->where('status',1)->orderBy('title','asc')->get();

if( !isset($menus[0]) ){
    $obj->title = 'Menu name';
    $obj->type = 'menu_item';
    $obj->status = 1;
    $obj->theme = $theme;
    $obj->save();
    $menus[0] = $obj;
}



$key = array_keys($menusLocaltion);

$menu_setting =(new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',$key)->pluck('content','key_word');

foreach ($menusLocaltion as $key => $title) {

	$menuLocaltion = [
		'title'=>$title,
	];
	if( isset($menu_setting[$key]) ){
		$menuLocaltion['contentMenu'] = $menu_setting[$key];
	}

	$menusLocaltion[$key] = $menuLocaltion;

}

$result['menus'] = $menus;
$result['location'] = $menusLocaltion;
$result['post_type'] = get_admin_object();

return $result;
