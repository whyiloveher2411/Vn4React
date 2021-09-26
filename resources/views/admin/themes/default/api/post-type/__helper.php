<?php

include __DIR__.'/update_post_relationship.php';

function newOrEdit($input, $type, $user){
    

    // $input = json_decode($r->getContent(),true);

    $input['attributes_order'] = $input['order']??0;
    $input['attributes_template'] = $input['template']??0;

    if( isset($input['_copy']) ){
        $post_id = false;
    }else{
        $post_id = $input[Vn4Model::$id]??false;
    }

    if( $post_id ){
        $list_param_find = [Vn4Model::$id=>$post_id];
    }else{
        $list_param_find = [];
    }

    $post_type = get_admin_object();

    if( isset($post_type[$type]['fields']['slug']) ){
        $input['slug'] = registerSlug( $input['slug'] ?? $input[array_key_first($post_type[$type]['fields'])], $type, $post_id, isset($list_param_find[0])?false:true );
    }

    $validate = validate_input($input, $type, $user, $post_id);

    if( $input['_action'] === 'ADD_NEW' || !isset($input['author']) ){
        $validate['input']['author'] = $user->id;
    }

    $validate['input']['editor'] = $input['editor']??'';

    if( strpos($validate['input']['editor'], $user->id.',') === false ){
        $validate['input']['editor'] = $validate['input']['editor'].$user->id.', ';
    }

    $post = Vn4Model::newOrEdit( $type, $list_param_find, $validate['input'], $validate['taxonomy'] );
    $post->starred = $input['starred']??0;
    $post->update_count = $post->update_count*1 + 1;
    $post->post_date_gmt = $input['post_date_gmt']??'';

    $post->save();

    return $post;
}


function changeDataInput( $input, $fields, $table, $type, &$taxonomy, $user, $post_id ){

    $fields['status'] = true;

    foreach ($fields as $key => $value) {

        if( is_array($value) && !isset($value['view']) ) $value['view'] = 'input';

        if( is_array($value) && !is_array($value['view']) ){

            if( isset( $input [ $key ] ) && is_string( $input [ $key ] ) ){
                $input[ $key ] = trim($input[ $key ]);
            }

            if(  File::exists( $resources = __DIR__.'/fields/'.$value['view'].'/api.php' )) {
                include $resources;
            }
        }else{

            if( isset($value['view']['post']) ){
                $input = $value['view']['post']($input);
            }
            
        }
    }

    $input = apply_filter('change_data_'.$type,$input,false);
    
    return $input;
    
}


function validate_input($input, $type, $user, $post_id){

    use_module(['post']);

    $admin_object = get_admin_object($type);

    $fields = $admin_object['fields'];

    $taxonomy = null;

    $inputCopy = vn4_unset_input_not_belong_post( $admin_object, $input, $type );

    $inputCopy = changeDataInput($inputCopy, $fields ,$admin_object['table'],$type, $taxonomy, $user, $post_id);

    // if( $admin_object['public_view'] ){
        $inputCopy = array_merge($inputCopy,['template'=>$input['attributes_template'] ?? '','order'=>$input['attributes_order'] ?? 0 ]);
    // }

    $inputCopy['type'] = $type;

    return ['input'=>$inputCopy,'taxonomy'=>$taxonomy];	

}


function getPostTypeConfig( $type ){
    
    $admin_object = get_admin_object($type);
    
    if( isset($admin_object['fields']['order']) ){
        $admin_object['fields']['order'] = [
            'title'=>'Order',
            'name'=>'attributes_order',
            'view'=>'number',
            'advance'=>'right',
            'show_data'=>false,
        ];
    }

    $theme_name = theme_name();

    if( file_exists(cms_path('resource').'/views/themes/'.$theme_name.'/post-type/'.$type) || isset($admin_object['template']) ){

        // $template = $post && $post->template?$post->template:'';

        if( !isset($admin_object['template']) ){
            $file_page = glob(cms_path('resource').'/views/themes/'.$theme_name.'/post-type/'.$type.'/*.blade.php');
        }else{
            $file_page = glob( cms_path('resource').'/views/'. str_replace('.', '/', $admin_object['template']).'/*.blade.php');
        }

        sort($file_page);

        $template = [];

        foreach($file_page as $page){
            $v = basename($page,'.blade.php');

            $name = $v;

            $name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
            preg_match( '|Template Name:(.*)$|mi', file_get_contents( $page ), $header );

            if( isset($header[1]) ){
                $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
            }

            $template[$v] = ['title'=>$name];
        }

        $admin_object['fields']['template'] = [
            'title'=>'Template',
            'name'=>'attributes_template',
            'list_option'=>$template,
            'view'=>'select',
            'advance'=>'right',
        ];

    }

    return $admin_object;

}

function getPermalinksPosts(&$posts){

    if( isset($posts[0]) ){

        $admin_object = get_admin_object($posts[0]->type);

        if( isset( $admin_object['public_view']) &&  $admin_object['public_view'] ){
            foreach( $posts as $post){
                $post->_permalink = get_permalinks($post);
            }
        }

    }

}


function requestMoreData( &$posts, $admin_object ){

    $admin_objects = get_admin_object();

    foreach( $admin_object['fields'] as $column => $config ){

        if( isset($config['requestMoreData']) ){
            
            switch ($config['view']) {

                case 'relationship_onetomany':

                    $listIds = [];

                    foreach($posts as $key => $p){
                        $listIds[] = $p->{$column};
                    }

                    $postsRelationship = DB::table($admin_objects[ $config['object'] ]['table'] )
                        ->where('type',$config['object']  )
                        ->whereIn('id', $listIds)
                        ->groupBy('id')
                        ->get()
                        ->keyBy('id');

                    foreach($posts as $key => $p){
                        $posts[$key]->{$column.'_moredata'} = isset($postsRelationship[ $p->{$column} ]) ? $postsRelationship[ $p->{$column} ] : null;
                    }

                    break;
                case 'relationship_manytomany':
                    $posts[$key]->{$column.'_moredata'} = $p->related( $config['object'], $column );
                    break;
            }

            
        }
    }
}