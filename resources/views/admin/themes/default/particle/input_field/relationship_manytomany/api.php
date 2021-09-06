<?php
$table = vn4_tbpf().$type.'_'.$value['object'] ;
$admin_object = get_admin_object();

if( isset( $input [ $key ]) ){

    $ids = [];

    if( is_string($input[$key]) ){
        $input[$key] = json_decode($input[$key],true);
    }
    if( !is_array($input[$key]) ) $input[$key] = [];
    
    foreach( $input [ $key ] as $v){

        if( isset($v['new_post']) ){

            $attibutes = [];

            if( isset($admin_object[$value['object']]['slug'] ) ){
                $attibutes['slug'] = registerSlug( $v['title'], $value['object'], null, true );
            }

            if( $post = Vn4Model::newOrEdit($value['object'],['title'=>$v['title'] ], $attibutes ) ){
                $ids[] = $post[Vn4Model::$id];
            }

        }else{
            $ids[] = $v[Vn4Model::$id];
        }
    }

    $category = new Vn4Model($admin_object[$value['object']]['table']);
    $category = $category->whereIn(Vn4Model::$id,$ids);


    if( !isset($value['fields_related']) ){
        $value['fields_related'] = [];
    }

    if( array_search('id', $value['fields_related']) === false ){
        $value['fields_related'][] = 'id';
    }

    if( array_search('title', $value['fields_related']) === false ){
        $value['fields_related'][] = 'title';
    }

    if( array_search('type', $value['fields_related']) === false ){
        $value['fields_related'][] = 'type';
    }

    if( isset($admin_object[$value['object']]['slug']) && array_search('slug', $value['fields_related']) === false ){
        $value['fields_related'][] = 'slug';
    }

    $category = $category->select($value['fields_related'])->get();

    $input [ $key ] =  json_encode($category);

    $taxonomy[] = ['table'=>$table, 'current_post_type'=>$type, 'relationship_type'=>$value['view'],'type'=>'input_check', 'key'=>$key, 'object'=>$value['object'],'list_id'=>json_decode( $input [ $key ] , true)];

}else{
    $input [ $key ]  = '[]';
    $taxonomy[] = ['table'=>$table , 'current_post_type'=>$type, 'relationship_type'=>$value['view'] , 'type'=>'input_check', 'key'=>$key, 'object'=>$value['object'],'list_id'=>[]];

}


