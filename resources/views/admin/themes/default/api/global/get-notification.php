<?php
$action = $r->get('action');

if( $action === 'updateCount' ){
    return [ 
        'count'=>get_posts('admin_notification',[ 'count'=>true,'paginate'=>'page','callback'=>function($q){
            $q->where('is_read',0);
        }])
    ];
}

$posts = get_posts('admin_notification',[ 'count'=>6,'paginate'=>'page','callback'=>function($q){
    $q->where('is_read',0);
}]);

$count = get_posts('admin_notification',['count'=>true] );

foreach( $posts->items() as $key => $post ){
    $post->created_diffForHumans = (new Carbon\Carbon($post->created_at) )->diffForHumans();

    if( $post->url ){
        $parse = parse_url($post->url);

        if( isset($parse['host']) ){
            $post->host = $parse['host'];
        }
    }
}

return [
    'posts'=>$posts,
    'count'=>$count,
    'severitys'=>get_admin_object('admin_notification')['fields']['severity']['list_option'],
];