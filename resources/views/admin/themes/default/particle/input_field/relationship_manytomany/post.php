<?php
$table = vn4_tbpf().$type.'_'.$value['object'] ;

if( !isset($value['type']) || ($value['type'] === 'input_check' || $value['type'] === 'select2' || $value['type'] === 'many_record') ){

    $admin_object = get_admin_object();

    if( isset( $input [ $key ]) ){

        $category = new Vn4Model($admin_object[$value['object']]['table']);
        $category = $category->whereIn(Vn4Model::$id,$input[$key]);


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
   
}elseif( $value['type'] === 'tags' ) {

    if( isset( $input [ $key ]) ){

        $taxonomy[] = ['table'=>$table , 'current_post_type'=>$type, 'relationship_type'=>$value['view'] , 'type'=>'tags', 'key'=>$key, 'object'=>$value['object'],'tags'=>explode(',' , is_string( $input[ $key] )?$input[ $key]:'' )];

    }else{

        $input [ $key ]  = '[]';
        $taxonomy[] = ['table'=>$table , 'current_post_type'=>$type, 'relationship_type'=>$value['view'] , 'type'=>'tags', 'key'=>$key, 'object'=>$value['object'],'list_id'=>[]];

    }

}

