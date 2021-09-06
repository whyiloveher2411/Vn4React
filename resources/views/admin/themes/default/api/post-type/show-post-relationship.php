<?php
include __DIR__.'/__helper.php';

$r = request();

$input = $r->all();

$result = [];

$admin_object = get_admin_object();


$rowsPerPage = $input['rowsPerPage']??10;

if( $input['page'] ){
    Illuminate\Pagination\Paginator::currentPageResolver(function() use ($input){
        return $input['page'];
    });
}


switch ($input['view']) {
    
    case 'relationship_onetomany_show':

        $field = $admin_object[ $input['object'] ] ['fields'][ $input['field'] ];

        $post = get_post( $input['mainType'], $input['id'] );
        
        $posts = (new Vn4Model($admin_object[$input['object']]['table']))->where('type', $input['object'])->where( $input['field'], $input['id'])->orderBy('created_at','desc')->paginate($rowsPerPage);
        
        getPermalinksPosts($posts);
        requestMoreData($posts, $admin_object[ $input['object']  ] );

        $result['rows'] = $posts;
        $result['config'] = $config = getPostTypeConfig($input['object']);
        
        $result['config']['fields'][$input['field']]['valueDefault'] = $post;
        $result['config']['fields'][$input['field']]['inputProps'] = [
            'disableClearable'=> true,
            'disabled'=>true,
        ];

        $result['config']['label'] = [
            'allItems'=>'All '.$admin_object[ $input['object'] ]['title'],
            'name'=>$admin_object[ $input['object'] ]['title'].'s',
            'singularName'=>$admin_object[ $input['object'] ]['title'],
        ];  

        break;
    case 'relationship_manytomany_show':

        $field = $admin_object[ $input['object'] ] ['fields'][ $input['field'] ];

        $posts =  (new Vn4Model($admin_object[$input['object']]['table']))->where('type', $input['object'])->whereRaw(Vn4Model::$id.' in ( SELECT post_id as id FROM '.vn4_tbpf().$input['object'].'_'.$admin_object[$input['object']]['fields'][$input['field']]['object'].' WHERE tag_id = '.$input['id'].'  AND field = "'.$input['field'].'" )')->orderBy('created_at','desc')->paginate($rowsPerPage);
       
        getPermalinksPosts($posts);
        requestMoreData($posts, $admin_object[ $input['object']  ] );

        $result['rows'] = $posts;

        $result['config'] = getPostTypeConfig($input['object']);

        $result['config']['label'] = [
            'allItems'=>'All '.$admin_object[ $input['object'] ]['title'],
            'name'=>$admin_object[ $input['object'] ]['title'].'s',
            'singularName'=>$admin_object[ $input['object'] ]['title'],
        ];  

        break;
    default:
        return [];
        break;
}

return $result;