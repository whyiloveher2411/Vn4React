<?php

$post_type = get_admin_object($param1);

$key = $r->get('key');

$posts = Vn4Model::table($post_type['table'])->limit(100000)->where('type',$param1);

if( $key ){
    $posts = $posts->where('title','LIKE','%'.$key.'%');
}

if( ($conditions = $r->get('conditions',null)) && (isset($conditions[0])) ){

    foreach($conditions as $condition){
        $posts->where($condition[0], $condition[1], $condition[2]);
    }

}

$posts = $posts->orderBy('order')->orderBy('id')->get();

if( $key && Vn4Model::table($post_type['table'])->where('type',$param1)->where('title',$key)->count() < 1 ){
    $posts[] = ['id'=>str_slug($key), 'new_post'=>true,  'title'=>$key];
}

return ['rows'=>$posts];