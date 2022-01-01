<?php

function appearance_menu_get($id = null){
    
    $obj = new Vn4Model(vn4_tbpf().'menu');

    $menus = $obj->where('type','menu_item');
    
    if( $id ){
        $menus->where('id',$id);
    }

    $menus = $menus->where('status',1)->get();

    if( !isset($menus[0]) ){

        $obj = appearance_menu_new_menu([
            'name'=>'Menu name',
            'description'=>''
        ]);

        $menus[0] = $obj;
    }

    return $menus;
}

function appearance_menu_edit( $data ){

    if( isset($data['id']) && isset($data['name']) && $data['name'] ){

        $menu = Vn4Model::firstOrAddnew(vn4_tbpf().'menu',[Vn4Model::$id => $data['id']]);

        if( $menu ){
            $menu->title = $data['name'];
            $menu->description = $data['description']??'';
            $menu->save();
            return $menu;
        }

    }
    
    return false;

}

function appearance_menu_new_menu($data){

    if( isset($data['name']  )  ){

        $obj = new Vn4Model(vn4_tbpf().'menu');
        $obj->title = $data['name'];
        $obj->description = $data['description']??'';
        $obj->content = '';
        $obj->type = 'menu_item';
        $obj->status = 1;
        $obj->theme = theme_name();
        $obj->save();

        return $obj;
    }
    
    return false;
}

function appearance_menu_delete($data){

    if( isset($data['id']) ){

        $menusLocaltion = appearance_get_location();

        $menusFilter = (new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',array_keys($menusLocaltion))->get();

        foreach ($menusFilter as $m) {
            if( $m->content == $data['id'] ){
                $m->json = '[]';
                $m->content = '';
            }
            $m->save();
            Cache::forget('menu - '.$m->key_word);
        }


        $menu = Vn4Model::seek(vn4_tbpf().'menu',$data['id']);
        
        if( $menu ){
            $menu->delete();
            cache_tag('menu',null,'clear');
            return true;
        }
    }
    return false;
}

function appearance_get_location(){
    
    $menusLocaltion = do_action('register_nav_menus',[]);

    $key = array_keys($menusLocaltion);

    $menu_setting =(new Vn4Model(vn4_tbpf().'menu'))->whereIn('key_word',$key)->pluck('content','key_word');

    foreach ($menusLocaltion as $key => $location) {

        $menuLocaltion = $location;
        
        if( isset($menu_setting[$key]) ){
            $menuLocaltion['contentMenu'] = $menu_setting[$key];
        }

        $menusLocaltion[$key] = $menuLocaltion;

    }

    return $menusLocaltion;

}

function appearance_get_data($id = null, $getPostType = false){

    $result = [];

    $result['menus'] = appearance_menu_get($id);
    if( $getPostType ){
        $result['post_type'] = get_admin_object();
    }
    $result['location'] = appearance_get_location();
    return $result;
}