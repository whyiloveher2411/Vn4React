<?php

include __DIR__.'/__helper.php';

$r = request();

$input =  $r->all();
$result = [];


// UPDATE MENU
foreach( $input['menuItem'] as $idMenu => $menuRequest){

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

$result = appearance_get_data($idMenu, true);

$result['message'] = apiMessage('Menu update successful');

return $result;
