<?php
$table = vn4_tbpf().$type.'_'.$value['object'] ;
$admin_object = get_admin_object();

if( isset( $input [ $key ]) ){

    $detail = Request::get($key.'_detail' );

    if( isset($detail['new_post']) && $detail['new_post'] ){

        $attibutes = [];

        if( isset($admin_object[$value['object']]['slug'] ) ){
            $attibutes['slug'] = registerSlug( $detail['title'], $value['object'], null, true );
        }

        if( $post = Vn4Model::newOrEdit($value['object'],['title'=>$detail['title'] ], $attibutes ) ){
	        $input[$key] = $post->id;
        }
    }


    if( !isset($value['fields_related']) ){
        $value['fields_related'] = [];
    }
        
    $admin_object = get_admin_object($value['object'])['fields'];
    
    if( array_search('id', $value['fields_related']) === false ){
        $value['fields_related'][] = 'id';
    }
    
    if( array_search('title', $value['fields_related']) === false ){
        $value['fields_related'][] = 'title';
    }
    
    if( array_search('type', $value['fields_related']) === false ){
        $value['fields_related'][] = 'type';
    }
    
    if( isset($admin_object['slug']) && array_search('slug', $value['fields_related']) === false ){
        $value['fields_related'][] = 'slug';
    }
    
    $input [ $key.'_detail' ] =  json_encode( get_post($value['object'],$input[$key],$value['fields_related']));
}else{
    $input[$key] = 0;
	$input [ $key.'_detail' ] =  '';
}


