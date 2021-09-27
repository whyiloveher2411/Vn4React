<?php
include __DIR__.'/__helper.php';

use_module('post');
$r = request();

$param = json_decode($r->getContent(),true);

$rowsPerPage = $param['rowsPerPage']??10;

$page = $param['page']??0;


$post_type = get_admin_object($param1);

if( !$post_type ){
    return [
        'redirect'=>'/error404'
    ];
}

if( isset($param['starred']) ){

    $post = get_post($param1, $param['starred']);

    if( $post ){

        $star_current = $post->starred;

        if( $star_current ){
            $post->starred = 0;
        }else{
            $post->starred = 1;
        }
        $post->timestamps = false;
        
        $post->save();
    }

}

if( isset($param['trash']) ){
    vn4_trash_post($param1, $param['trash']);
}

if( isset($param['restore']) ){
    vn4_restore_post($post_type, $param1, $param['restore']);
}

if( isset($param['delete']) ){
    vn4_delete_post( $param1 , $param['delete'] );
}

if( isset($param['settingFilter']) ){
    updateSettingFilter($param1, $param['settingFilter']);
}
// setting_save('filters_post_type_'.$param1,[]);

$list_post_filter = null;
if( isset($param['filter']) ){
    $post_filter = $param['filter'];
}else{
    $post_filter = 'all';
}

$post_filter = explode('.', $post_filter);

$status = vn4_get_post_count_status($post_type, $param1, $list_post_filter, $post_filter);
$post_type['filters'] = $list_post_filter;

$posts = Vn4Model::table($post_type['table'])->where('type',$param1)->orderBy('id','desc');

if( isset($param['search']) && $param['search'] ){

    $posts = $posts->where('title','LIKE','%'.$param['search'].'%');

}

$order_by_default = $param['order']??['created_at','desc'];
$posts = $posts->orderBy($order_by_default[0], $order_by_default[1]);

if( isset($post_filter[0]) && isset($list_post_filter[$post_filter[0]]) ){
    if( isset($post_filter[1]) ){
        foreach ($list_post_filter[$post_filter[0]]['items'][$post_filter[1]]['where'] as $where) {

            if( is_callable($where) ){
                $posts = $where($posts);
            }else{
                $posts = $posts->where($where[0], $where[1] , $where[2] );
            }
        }
    }else{

        if( isset($list_post_filter[$post_filter[0]]['sql']) ){
            $posts = $posts->whereRaw($list_post_filter[$post_filter[0]]['sql']);
        }else{
            foreach ($list_post_filter[$post_filter[0]]['where'] as $where) {

                if( is_callable($where) ){
                    $posts = $where($posts);
                }else{
                    $posts = $posts->where($where[0], $where[1] , $where[2] );
                }
            }
        }
    }
}

$count  = $posts->count('id');

$length = $param['rowsPerPage']??10;

if($count != 0 && $length * $page > $count){

    $page = (int) ($count / $length);

    if($count % $length != 0){

        $page = $page + 1;

    }

}

Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
    return $page;
});

$posts = $posts->paginate($rowsPerPage);

$post_type['label'] = [
    'allItems'=>'All '.$post_type['title'],
    'name'=>$post_type['title'].'s',
    'singularName'=>$post_type['title'],
];

getPermalinksPosts( $posts );
requestMoreData($posts, $post_type );

return response()->json(['config'=>$post_type,'rows'=>$posts]);



function updateSettingFilter($post_type, $filter_detail){
    
    $admin_object = get_admin_object($post_type);

    $admin_object['fields'] = array_merge([
            'id'=>['title'=>'ID','view'=>'number'], 
            'created_at'=>['title'=>'Created At','view'=>'date'],
            'author'=>['title'=>'Author','view'=>'relationship_onetomany','object'=>'user','type'=>'many_record','data'=>['columns'=>['email']]]
    ], $admin_object['fields']);

    $filters_update = [];

    $hasCustom = false;

    foreach ($filter_detail as $filter) {

        if( isset($filter['default']) && $filter['default']){
            unset($filter['where']);
            $filters_update[ $filter['key'] ] = $filter;
            continue;
        }

        if( !isset($filter['conditions']['content'][0]) ){
            continue;
        }
        

        $sql = filterBuilder($admin_object, $filter['conditions'], 'where');

        $filterKey = isset($filter['key']) ? $filter['key'] : str_random(10).'_'.str_slug($filter['title']);

        $filters_update[$filterKey] = array_merge( $filter, [
            'sql'=>$sql
        ]);

        $hasCustom = true;
    }

    if( $hasCustom ){
        setting_save('filters_post_type_'.$post_type,$filters_update);
    }else{
        setting_save('filters_post_type_'.$post_type,'');
    }

    cache_tag('count_filter', $post_type, 'clear');
}


function filterBuilder($admin_object, $filter, $conditionsTypeParent){

    $conditionsType = 'where';

    if( $filter['type'] === 'any' ){
        $conditionsType = 'orWhere';
    }

    $queryBuilder = DB::table($admin_object['table']);
    
    $sql_prefix = sql_replace($queryBuilder);

    $queryBuilder->{$conditionsTypeParent}( function($q) use ($admin_object, $filter, $conditionsType) {

        foreach ($filter['content'] as $key => $value) {
            if( $value['field'] === 'conditions_combination' ){
                $q->{$conditionsType.'Raw'}( filterBuilder($admin_object, $value['value'], $conditionsType) );
            }else{
                switch ($value['comparisonOperators']) {
                    case '{}':
                        break;
                    case '!{}':
                        break;
                    case '()':
                        break;
                    case '!()':
                        break;
                    case 'IS NULL':
                        $q->{$conditionsType.'Null'}( $value['field'] );
                        break;
                    case 'IS NOT NULL':
                        $q->{$conditionsType.'NotNull'}( $value['field'] );
                        break;
                    case '=':
                    case '!=':
                    case '>=':
                    case '<=':
                    case '>':
                    case '<':
                        if( file_exists( $filter = __DIR__.'/fields/'.$admin_object['fields'][$value['field']]['view'].'/filter.php' ) ){
                            require ($filter);
                        }else{
                            $q->{$conditionsType}( $value['field'],$value['comparisonOperators'], $value['value'] );
                        }
                        break;
                    default:
                        break;
                }
            }
        }

    });

    $sql_end = sql_replace($queryBuilder);

    $sql = trim(str_replace($sql_prefix, '', $sql_end));
    
    $wordFirst = explode(' ',$sql)[0];

    $conditions = substr($sql, strlen($wordFirst) + 1);

    if( intval($filter['value']) !== 1 ){
        $conditions  = '!'.$conditions;
    }

    return $conditions;

}