<?php

if ( !function_exists('vn4_get_post_count_status') ){

    function get_count_filter_post_type($arg_where_count, $admin_object, $type, $status){
        $table = $admin_object['table'];

        $arg_where_count2 = [];

        if( isset($GLOBALS['post_php']['button_status']['status']) && $GLOBALS['post_php']['button_status']['status'] === $status ){

            return $GLOBALS['post_php']['button_status'];

        }

        if( !$status ){
            $status = Request::get('post_filter','all');
            $status = explode('.', $status);
        }

        $str_query_count = '';

        $counts = [];

        foreach ($arg_where_count as $key=>$filter) {

            $db = DB::table($table);
            $db->where('type',$type);

            if( isset($filter['sql']) ){

                $db->whereRaw($filter['sql']);
                $arg_where_count2[$key]['count'] = $db->count();

            }elseif( isset($filter['items']) ){
                foreach ($filter['items'] as $key2 => $filter2) {

                    foreach ($filter2['where'] as $where) {

                        if( is_callable($where) ){
                            $db = $where($db);
                        }else{
                            $db->where($where[0], $where[1], $where[2]);
                        }

                    }


                    $arg_where_count2[$key]['items'][$key2]['count'] = $db->count();
                }
            }else{

                foreach ($filter['where'] as $where) {

                    if( is_callable($where) ){
                        $db = $where($db);
                    }else{
                        $db->where($where[0], $where[1], $where[2]);
                    }

                }

                $arg_where_count2[$key]['count'] = $db->count();
            }

        }

        return $arg_where_count2;
    }

    function vn4_get_post_count_status( $admin_object, $type, &$arg_where_count = null, $status = null ){

        $arg_where_count = [

            'all'=>['key'=>'all', 'where'=>[['status','!=','']],'title'=>__('All') ,'default'=>true,'icon'=>'PublicRounded','color'=>'#fff', 'showOnHeader'=>1],
            'publish'=>['key'=>'publish','where'=>[['status','=','publish']],'title'=>__('Published'),'default'=>true, 'icon'=>'Publish','color'=>'#188038', 'showOnHeader'=>1],
            'starred'=>['key'=>'starred','where'=>[['starred','=',1]],'title'=>__('Starred'),'default'=>true,'icon'=>'StarOutlined','color'=>'#f4b400', 'showOnHeader'=>1],


            'future'=>['key'=>'future', 'where'=>[['post_date_gmt','!=',''],function($q){ return $q->whereNotNull('post_date_gmt'); }], 'title'=>__('Future'),'default'=>true, 'icon'=> 'UpdateRounded','color'=>'#0079be', 'showOnHeader'=>1],

            'draft'=>['key'=>'draft', 'where'=>[['status','=','draft']],'title'=>__('Drafts'),'default'=>true, 'icon'=>'InsertDriveFileRounded','color'=>'#757575', 'showOnHeader'=>1],

            'pending'=>['key'=>'pending','where'=>[['status','=','pending']],'title'=>__('Pending'),'default'=>true, 'icon'=>'CreateRounded','color'=>'#f68924', 'showOnHeader'=>1],

            'private'=>['key'=>'private','where'=>[['visibility','=','private']],'title'=>__('Private'),'default'=>true, 'icon'=>'LockRounded','color'=>'#8604c4'],

            'password'=>['key'=>'password','where'=>[['visibility','=','password']],'title'=>__('Password protected'),'default'=>true, 'icon'=>'VpnKeyRounded','color'=>'#00851d'],

            'trash'=>['key'=>'trash','where'=>[['status','=','trash']],'title'=>__('Trash'),'default'=>true, 'icon'=>'DeleteRounded','color'=>'#e53935', 'showOnHeader'=>1],


         ];




        if( isset($admin_object['filter']) ){

            $valueTemp = $admin_object['filter']($arg_where_count);

            if( $valueTemp ) $arg_where_count = $valueTemp;

        }

        add_action('post_filter',function() use ($arg_where_count){

            return $arg_where_count;

         });

        if( $filters_added = setting('filters_post_type_'.$type) ){

            $filterSettingsDB = json_decode($filters_added,true);

            foreach ($arg_where_count as $filterKey => $filterValue) {

                if( isset( $filterSettingsDB[$filterKey]) ){
                    $filterSettingsDB[$filterKey]['where'] = $arg_where_count[$filterValue['key']]['where'];
                }else{
                    $filterSettingsDB[$filterKey] = $filterValue;
                }

                // if( isset($filterValue['key']) && isset($arg_where_count[ $filterValue['key'] ])){

                //     $filterSettingsDB[$filterKey]['where'] = $arg_where_count[$filterValue['key']]['where'];
                // }
            }
            
            $arg_where_count = $filterSettingsDB;
        }

        $count = cache_tag('count_filter', $type, function() use ($arg_where_count, $admin_object, $type, $status) {
            return get_count_filter_post_type($arg_where_count, $admin_object, $type, $status);
        });

        foreach ($arg_where_count as $key => $filter) {
            if( isset($filter['items']) ){
                foreach ($filter['items'] as $key2 => $filter2) {
                    $arg_where_count[$key]['items'][$key2]['count'] = $count[$key]['items'][$key2]['count'];
                }
            }else{
                $arg_where_count[$key]['count'] = $count[$key]['count'];
            }
        }

        $string_html = vn4_view(backend_theme('particle.post-type.button-status'),['filter'=>$arg_where_count, 'status_current'=>$status] );

        $GLOBALS['post_php']['button_status'] = ['status_count'=>$string_html, 'status'=>$status];

        return $GLOBALS['post_php']['button_status'];

    }

}

if( !function_exists('vn4_add_new_post') ){

    function vn4_add_new_post( $admin_object, $input, $type, $save = true ){

        $input['type'] = $type;

        $tableName = null;

        if( isset( $admin_object['table']) ){

          $tableName = $admin_object['table'];

        }

        $tag = new Vn4Model($tableName);

        $tag->fillDynamic($input);

        return $tag;

    }

}

if( !function_exists('vn4_unset_input_not_belong_post') ){

    function vn4_unset_input_not_belong_post( $admin_object, $input, $type ){

        $fields = $admin_object['fields'];

        $fields = apply_filter('add_fields_'.$type,$fields);

        if( isset($input['select-status-password'])  ){

            if( $input['select-status-password'] === 'password' && trim($input['publish-password']) !== '' ){

                $input['password'] = $input['publish-password'];

                $input['visibility'] = 'password';

            }elseif( $input['select-status-password'] == 'private' ){

                $input['visibility'] = 'private';

            }else{

                $input['visibility'] = 'publish';

            }

        }

        if( isset($input['publish-date']) && $input['publish-date'] && isset($input['publish-hour']) && $input['publish-hour'] ){

            $input['post_date_gmt'] = date_format( date_create($input['publish-date'].' '.$input['publish-hour']) , 'Y-m-d H:i:s');

        }elseif( isset($input['publish-date']) && $input['publish-date'] ){

            $input['post_date_gmt'] = date_format( date_create($input['publish-date'].' 00:00:00') , 'Y-m-d H:i:s');

        }elseif( isset($input['publish-hour']) && $input['publish-hour'] ){

            $input['post_date_gmt'] = date_format( date_create(date('Y-m-d').' '.$input['publish-hour']) , 'Y-m-d H:i:s');

        }else{

            $input['post_date_gmt'] = '';

        }

        $input['post_date_gmt'] = strtotime($input['post_date_gmt'])?strtotime($input['post_date_gmt']):0;

        $list_default = ['password','visibility','post_date_gmt','status'];

        foreach ($input as $key => $value) {

            if( !isset($fields[$key]) && !in_array( $key , $list_default ) ){

                unset($input[$key]);

            }

        }

        return $input;

    }

}

function encoding_to_html_code($string){

    return mb_convert_encoding(mb_strtolower(trim($string),'UTF-8'),'HTML-ENTITIES');

}

function vn4_create_taxonomy( $taxonomys, $post ){
    foreach ($taxonomys as $taxonomy) {
        if( $taxonomy['relationship_type'] === 'relationship_manytomany' ){

            if( $taxonomy['type'] === 'input_check' ){

                DB::table($taxonomy['table'])->where('post_id',$post->id)->where('type',$taxonomy['object'])->where('field',$taxonomy['key'])->delete();

                if ( isset($taxonomy['list_id'][0]) ){
                    $table = $taxonomy['table'];
                    $field = $taxonomy['key'];
                    $key = $taxonomy['object'];
                    $list_insert = [];
                    
                    foreach ($taxonomy['list_id'] as $id) {
                        DB::table($table)->where('post_id',$post->id)->where('field',$field)->where('type',$key)->where('tag_id',$id[Vn4Model::$id])->delete();
                        $list_insert[] = ['post_id'=>$post->id,'tag_id'=>$id[Vn4Model::$id],'type'=>$key, 'field'=>$field];
                    }
                    DB::table($table)->insert($list_insert);

                    $admin_object = get_admin_object();

                    $list_id = DB::table($table)->where('post_id',$post->id)->where('type',$key)->where('field',$field)->pluck('tag_id');
                    foreach ($list_id as  $categoryId) {
                        DB::table($admin_object[$key]['table'])->where(Vn4Model::$id,$categoryId)->update(['count_'.$taxonomy['current_post_type'].'_'.$field => DB::table($table)->where('tag_id',$categoryId)->where('type',$key)->where('field',$field)->count() ]);
                    }

                }
            }elseif( $taxonomy['type'] === 'tags' ){

                $field = $taxonomy['key'];
                $key = $taxonomy['object'];

                DB::table($taxonomy['table'])->where('post_id',$post->id)->where('type',$key)->where('field',$field)->delete();

                 if ( isset($taxonomy['tags'][0]) && trim($taxonomy['tags'][0]) !== '' ){
                    $admin_object = get_admin_object();

                    $string_find = $taxonomy['tags'];

                    $table_object = $admin_object[$key]['table'];
                    $list_insert = [];
                    $post_tags = [];

                    foreach ($string_find as $title) {


                        $tag = do_action('vn4_create_taxonomy',$table_object, $title, $key, $post);

                        if( !$tag ){

                            $tag = Vn4Model::firstOrAddnew($table_object,['title'=>$title]);

                            if( !$tag->exists ){
                                $tag->slug = registerSlug($title, $key);
                                $tag->type = $key;
                                $tag->post_date_gmt = $post->post_date_gmt;
                                $tag->visibility = 'publish';
                                $tag->status = 'publish';
                                $tag->template = '';
                                $tag->author = Auth::id();
                                $tag->status_old = 'publish';
                                $tag->ip = request()->ip();
                                $tag->meta = '';
                                $tag->order = 0;
                            }
                        }

                        $tag->save();

                        $list_insert[] = ['post_id'=>$post->id,'tag_id'=>$tag->id,'type'=>$key, 'field'=>$field];

                        $post_tags[] = $tag;
                    }

                    DB::table($taxonomy['table'])->insert($list_insert);

                    foreach ($post_tags as $value) {
                        DB::table($admin_object[$key]['table'])->where(Vn4Model::$id,$value->id)->update(['count_'.$taxonomy['current_post_type'].'_'.$field =>DB::table($taxonomy['table'])->where('tag_id',$value->id)->where('type',$key)->where('field',$field)->count()]);
                    }
                    $post->setAttribute($field, json_encode($post_tags));
                    $post->save();

                }

            }

        }
    }
}

function vn4_delete_post( $type, $ids ){

        $list_admin_object = get_admin_object();
        $admin_object = $list_admin_object[$type];
        $table = $admin_object['table'];
        if( is_string($ids) ) $ids = explode(',', $ids);
        foreach ($admin_object['fields'] as $key_field => $field) {
            if( !isset($field['view']) ) $field['view'] = 'input';
            if( is_string($field['view']) && File::exists( $resources = backend_resources('particle/input_field/'.$field['view'].'/delete.php') ) ){
                include $resources;
            }
        }
        foreach ($list_admin_object as $post_type => $object) {
            foreach ($object['fields'] as $key_field => $field) {
                if( !isset($field['view']) ) $field['view'] = 'input';
                if( $field['view'] === 'relationship_manytomany' && $field['object'] === $type ){
                    $table_relationships = vn4_tbpf().$post_type.'_'.$type ;
                    $relationships = new Vn4Model($table_relationships);
                    $list_post_id = $relationships->whereIn('tag_id',$ids)->where('type',$type)->pluck('post_id',Vn4Model::$id);
                    //change post
                    $list_post = new Vn4Model($object['table']);
                    $list_post = $list_post->whereIn(Vn4Model::$id,$list_post_id)->get();
                    foreach ($list_post as $post ) {
                        $list_tag = json_decode($post->{$key_field},true);
                        if( !is_array($list_tag) ) $list_tag = [];
                        $list_tag2 = [];
                        $count = count($list_tag);
                        for ($i=0; $i < $count; $i++) { 
                            if( array_search($list_tag[$i][Vn4Model::$id], $ids ) === false ){
                                $list_tag2[] = $list_tag[$i];
                            }
                        }
                        $post->{$key_field} = json_encode($list_tag2);
                        $post->save();
                    }
                    $relationships->whereIn('tag_id',$ids)->delete();
                }
            }
        }
        foreach ($ids as $id) {
            $post = Vn4Model::findCustomPost($type, $id);
            if( $post ){
                if( isset($admin_object['action_callback']['delete']) ){
                    $admin_object['action_callback']['delete']($post);
                }
                do_action('delete_post',$post, $admin_object);
                $post->remove();
            }
        }

}

function vn4_trash_post( $type, $ids ){

    $admin_object = get_admin_object($type);

    if( is_string($ids) )  $ids = explode(',', $ids);

    if( is_array($ids) ){

         foreach ($ids as $id) {

            $post = Vn4Model::findCustomPost($type, $id);

            if( $post ){

                if( $post->status != 'trash' ){

                    if( isset($admin_object['action_callback']['trash']) ){

                        $admin_object['action_callback']['trash']($post);

                    }

                    $post->status_old = $post->status;

                    $post->status = 'trash';

                    $post->save();

                }

               

            }

        }
    }
}

function vn4_restore_post( $admin_object ,$type, $ids ){

    if( is_string($ids) )  $ids = explode(',', $ids);

    foreach ($ids as $id) {

        $post = Vn4Model::findCustomPost($type, $id);

        if( $post ){

            if( isset($admin_object['action_callback']['restore']) ){

                $admin_object['action_callback']['restore']($post);

            }

            $status_old = $post->status_old;

            $post->status_old = 'trash';

            if( $status_old != 'trash' ){

                $post->status = $status_old;

            }else{

                $post->status = 'publish';

            }

            $post->save();

        }

    }

}

function vn4_get_data_table_admin( $type, $getJS = false, $post_filter = null, $order_by_default = null, $notGroupBy = true, $onGetData = false ){
    $r = request();

    $isAjax = $r->ajax();

    $admin_object = get_admin_object($type);

    $admin_object2 = do_action('custome-post-table',$type, $admin_object);

    if( $admin_object2 ) $admin_object = $admin_object2;

    $obj = new Vn4Model( $admin_object['table'] );

    $input = '';

    $post = $r->get('post',false);

    $action_post = $r->get('action_post','default');

    $isMethodPost =  $r->isMethod('POST');

    if( $notGroupBy && $post && $isMethodPost && $r->has('submit_action_post') ){

        if( $action_post == 'delete' && check_permission($type.'_delete')){

            if( config('app.EXPERIENCE_MODE') ){
                return experience_mode();
            }

            if( !$isAjax ){
                vn4_create_session_message('Success!','Delete Post Success!','success');
            }

            vn4_delete_post( $type, $post);
        }

        if( $action_post == 'trash' && check_permission($type.'_trash')){

            if( config('app.EXPERIENCE_MODE') ){
                return experience_mode();
            }

           vn4_trash_post( $type, $post );
        }

        if( $action_post == 'restore' && check_permission($type.'_restore')){

            vn4_restore_post( $admin_object, $type, $post );

        }

    }

    $multi_trash = $r->get('multi_trash',false);

    if( $notGroupBy && $multi_trash != false && $isMethodPost ){

        vn4_trash_post( $type, $multi_trash );

    }

    $multi_trash = $r->get('multi_restore',false);

    if( $notGroupBy && $multi_trash != false && $isMethodPost ){

        vn4_restore_post( $admin_object, $type, $multi_trash );

    }

     $multi_trash = $r->get('multi_delete',false);

    if( $notGroupBy && $multi_trash != false && $isMethodPost ){

        if( config('app.EXPERIENCE_MODE') ){
            return experience_mode();
        }
        
        vn4_delete_post( $type, $multi_trash );
    }

    $data = $obj->where('type',$type);

    $data2 = do_action('vn4_get_data_table_admin',$data,$type);

    if( $data2 ) $data = $data2;

    if( !$post_filter ) $post_filter = $r->get('post_filter', 'all');

    $list_post_filter = null;

    $post_filter = explode('.', $post_filter);

    if( $notGroupBy ){
        
        $post_filter_count = vn4_get_post_count_status( $admin_object , $type , $list_post_filter, $post_filter );

        if( isset($post_filter[0]) && isset($list_post_filter[$post_filter[0]]) ){

            if( isset($post_filter[1]) ){
                foreach ($list_post_filter[$post_filter[0]]['items'][$post_filter[1]]['where'] as $where) {

                    if( is_callable($where) ){
                        $data = $where($data);
                    }else{
                        $data = $data->where($where[0], $where[1] , $where[2] );
                    }
                }
            }else{

                if( isset($list_post_filter[$post_filter[0]]['sql']) ){
                    $data = $data->whereRaw($list_post_filter[$post_filter[0]]['sql']);
                }else{
                    foreach ($list_post_filter[$post_filter[0]]['where'] as $where) {

                        if( is_callable($where) ){
                            $data = $where($data);
                        }else{
                            $data = $data->where($where[0], $where[1] , $where[2] );
                        }
                    }
                }
            }
            
        }

    }

    if( isset($admin_object['data_filter']) ){

        foreach ($admin_object['data_filter'] as $key_filter => $value) {

            $condition = '=';

            if( is_array($value) && isset($value['value_callback']) && is_callable($value['value_callback']) ){

                $value = $value['value_callback']();

                if( isset($value['condition']) ) $condition = $value['condition'];

            }elseif ( is_callable($value) ) {

                $value = $value();

            }

            $data = $data->where($key_filter, $condition, $value);

        }

    }

    if( isset($admin_object['data_table_callback']) && is_callable($admin_object['data_table_callback']) ) {

        if( $result = $admin_object['data_table_callback']($data) ){

             $data = $result;

        }else{


        }

    }

    if($r->has('search')){

        $search_text = $r->get('search');

        $data = $data->where(function($query) use ($admin_object,$search_text){

            $argNotSearch = ['relationship_manytomany_show'=>1,'relationship_onetomany_show'=>1,'relationship_onetoone_show'=>1];

            foreach ($admin_object['fields'] as $key => $value) {
                if( !isset($value['view']) ) $value['view'] = 'text';
                
                if( is_string( $value['view'] ) && !isset($argNotSearch[$value['view']] ) ){
                    $query->orWhere($key,'like', '%'.$search_text.'%');
                }
            }
            $query->orWhere(Vn4Model::$id,'like', '%'.$search_text.'%');
            $query->orWhere('created_at','like', '%'. $search_text.'%');
        });

    }

    $fields = $admin_object['fields'];

    $page = $r->get('page',1);

    if( !$order_by_default ){
        $order_by_default = isset($admin_object['order_by_default'])?$admin_object['order_by_default']:['created_at','desc'];

        $order_by_default = [$r->get('order_field',$order_by_default[0]), $r->get('order_value',$order_by_default[1])];
    }

    $data = $data->orderBy($order_by_default[0], $order_by_default[1]);

    $length = $r->get('length',10);

    $length = intval ($length);

    $count  = $data->count('id');

    if($count != 0 && $length * $page > $count){

        $page = (int) ($count / $length);

        if($count % $length != 0){

            $page = $page + 1;

        }

    }

    Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
        return $page;
    });

    $show_column = Auth::user()->getMeta('show_fields_show_template_table_'.$type)??[];
    $groupby_column = Auth::user()->getMeta('show_fields_groupby_template_table_'.$type)??'';

    if( ( $date_from = $r->get('date_from')??'0000-00-00 00:00:00' ) || $r->get('date_to') ){

        $date_to = $r->get('date_to');

        if( strtotime($date_to) ){
            $date_to = strtotime($r->get('date_to'));
            $date_to = date('Y-m-d',$date_to).' 23:59:59';
        }else{
            $date_to = '9999-01-01';
        }
   
        $data = $data->whereBetween('created_at',[$date_from,$date_to]);
    }

    if( $onGetData ){
        return $data;
    }

    if( $notGroupBy && $groupby_column && isset($admin_object['fields'][$groupby_column]) && ( $admin_object['fields'][$groupby_column]['view'] === 'select' || $admin_object['fields'][$groupby_column]['view'] === 'relationship_onetomany' )){

        if (($key = array_search($groupby_column, $show_column)) !== false) {
            unset($show_column[$key]);
        }

        if( $admin_object['fields'][$groupby_column]['view'] === 'relationship_onetomany' ){

            // $group = DB::table( get_admin_object($admin_object['fields'][$groupby_column]['object'])['table'] )
            //     ->where('type', $admin_object['fields'][$groupby_column]['object'])->get();

            //     dd($group);

            $groupObject = vn4_get_data_table_admin( $admin_object['fields'][$groupby_column]['object'], false , 'all', ['title','asc'], false );
            $pagination = $groupObject['pagination'];
            // $data = $data->whereIn($groupby_column, $groupObject['data']->pluck(Vn4Model::$id))->groupBy($groupby_column)->select($groupby_column,DB::raw('count(*) as count'))->get();
            $data = $data->whereIn($groupby_column, $groupObject['data']->pluck(Vn4Model::$id))->get();
            $result = [];

            foreach ($data as $ob) {
                $result[$ob->{$groupby_column}][] = $ob;
            }
            foreach ($groupObject['data'] as $group) {
                if( isset($result[$group->id]) ){
                    $result[$group->title] = $result[$group->id];
                    unset($result[$group->id]);
                }
                else{
                    $result[$group->title] = [];
                }
            }

            $html = vn4_get_tbody_data( $result, $type, $admin_object, $show_column, $groupby_column );
        }else{

            $result = [];
            $keys = array_keys($admin_object['fields'][$groupby_column]['list_option']);
            $keys[] = '';

            // $data = $data->whereIn($groupby_column,$keys)->groupBy($groupby_column)->select($groupby_column,DB::raw('count(*) as count'))->get();
            $data = $data->whereIn($groupby_column,$keys)->get();

            $result = [];

            foreach ($data as $ob) {

                if( isset($admin_object['fields'][$groupby_column]['list_option'][ $ob->{$groupby_column} ]) ){
                    $result[$admin_object['fields'][$groupby_column]['list_option'][ $ob->{$groupby_column} ]['title']][] = $ob;
                }else{
                    $result['(Undefined )'][] = $ob;
                }
            }
            $pagination = '';
            $html = vn4_get_tbody_data( $result, $type, $admin_object, $show_column, $groupby_column );

        }

    }else{

        $data = $data->paginate($length)->setPath($type);

        if ( $data->count() === 0 &&  $post_filter[0] !== 'all' ){
           return vn4_get_data_table_admin( $type, $getJS,'all' );
        }

        $pagination = vn4_get_pagination($data, $post_filter);

    }

    if(!$getJS){
        return ['data'=>$data,'pagination'=>$pagination];
    }

    $theader = '<th><input type="checkbox" class="show-data-checkall" ></th>';

    foreach($fields as $key => $value){
        $width = '';

        if( isset($value['width_column_table']) ){
            $width = 'style="width:'.$value['width_column_table'].'px"';
        }
        if( ( $show_column && array_search($key, $show_column) !== false ) ||  (!$show_column && (!isset($value['show_data']) || $value['show_data'])) ){
            $theader = $theader.'<th class="sorting '. ($order_by_default[0] == $key ? 'sorting_'.$order_by_default[1]: '') .'" data-field="'.$key.'" '.$width.'>'.$value['title'].'</th>';
        }
    }

    $theader = $theader.'<th style="width:150px;text-align:center;">'.__('Edit history').'</th>';

    if( !isset($html) ){
        $html = vn4_get_tbody_data( $data, $type, $admin_object, $show_column );
    }

    $result = ['data'=>$html,'thead'=>$theader,'pagination'=>$pagination,'pnk'=>$input,'post_filter'=>implode('.',$post_filter)];

    $result = array_merge($result, $post_filter_count);

    if( $isAjax ){
        return response()->json($result);
    }

    return redirect()->route('admin.show_data',['type'=>$type]);


}

function get_row_actions($post, $row_actions_list, $permission_list, $view = null){

    $status = $post->status;

    $row_actions_result = [];

    if($status === 'trash'){

        if($permission_list['delete']) $row_actions_result['delete'] = $row_actions_list['delete'];

        if($permission_list['restore']) $row_actions_result['restore'] = $row_actions_list['restore'];

    }else{

        if($permission_list['edit']){
             $row_actions_result['edit'] = $row_actions_list['edit'];
             $row_actions_result['quick-edit'] = $row_actions_list['quick-edit']($post);
             $row_actions_result['copy'] = $row_actions_list['copy'];
        }

        if($permission_list['trash']) $row_actions_result['trash'] = $row_actions_list['trash'];

        if($permission_list['detail']) $row_actions_result['detail'] = $row_actions_list['detail']($post);

        if( $view ){

            $row_actions_result['view'] = '<a href="'.route('admin.controller',['controller'=>'post-type','method'=>'get-public-view-post','id'=>$post->id,'type'=>$post->type]).'" target="_blank">'.__('View').'</a>';

        }

    }
    $row_actions_result = ['id'=>'<a href="javascript:void(0)" style="color:gray;">ID: '.$post->id.'</a>'] + $row_actions_result;

    return $row_actions_result;

}

function vn4_get_tbody_data( $list_data, $type, $admin_object, $list_column_show = false, $groupBy = false ){
    $fields = $admin_object['fields'];
    $post_active = Request::get('post',0);
    $is_add_row_action = isset( $admin_object['row_actions'] );
    $route_name_edit = $GLOBALS['route_name'];
    if( $route_name_edit === 'admin.show_data' ){
        $route_name_edit = 'admin.create_data';
    }
    if( isset($admin_object['route_update']) ){
        $route_name_edit = $admin_object['route_update'];
    }
    $str = '';
        
    if( !$groupBy && method_exists($list_data,'total') && $list_data->total() == 0 ){
        $tbody = '<tr class="odd"><td valign="top" colspan="1000" class="dataTables_empty"><h4 style="font-size:18px;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="'.asset('admin/images/data-not-found.png').'"><strong>'.__('Nothing To Display.').' <br> <span style="color:#ababab;font-size: 16px;">Seems like no '.$admin_object['title'].' have been created yet.</span></strong></h4></td></tr>';
    }else{
        $list_post_filter = do_action('post_filter');
        $tbody  = '';
        $post_filter = Request::get('post_filter','all');
        $permission_list = [
            'edit'=>check_permission($type.'_edit'),
            'quick-edit'=>check_permission($type.'_edit'),
            'trash'=>check_permission($type.'_trash'),
            'restore'=>check_permission($type.'_restore'),
            'detail'=>check_permission($type.'_detail'),
            'delete'=>check_permission($type.'_delete')
        ];
        $row_actions_list = [
            'edit' => '<a class="editRow action_post" action="edit" href="#">'.__('Edit').'</a>',
            'quick-edit' =>function($post) use ($type, $admin_object) { return '<a data-popup="1" data-title="Editing: '.$post->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$post->id,'action_post'=>'edit']).'" href="#">'.__('Quick Edit').'</a>';},
            'copy' => '<a class="editRow action_post" action="copy" href="#">'.__('Copy').'</a>',
            'trash' => '<a class="trashRow action_post" href="#" action="trash">'.__('Trash').'</a>',
            'detail' => function($post) use ($type, $admin_object) { return '<a data-popup="1" data-title="Detail: '.$post->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$post->id,'action_post'=>'detail']).'" href="#">'.__('Detail').'</a>';},
            'delete' => '<a class="delete action_post" href="#" action="delete">'.__('Delete').'</a>',
            'restore' => '<a class="restoreRow action_post" href="#" action="restore">'.__('Restore').'</a>',
        ];

        $class_tr = 'item_group';

        if( !$groupBy ){
            $list_data = [$list_data];
            $class_tr = '';
        }
        
        foreach ($list_data as $group => $data) {
            
            if( $groupBy ){
                $tbody  .= '<tr><td colspan="100" data-key="'.$group.'" class="td_show_group_data_table"><i class="fa fa-caret-right" aria-hidden="true"></i> '.$group.' ('.count($data).')</td></tr>';
            }

            foreach($data as $item){

                $showed_filter = true;
                $class = 'post-data';
                if($item->id == $post_active){
                    $class = 'post-data my-post';
                }
                $row_actions = get_row_actions($item,$row_actions_list, $permission_list, $admin_object['public_view']);
                if( $is_add_row_action ){
                    $row_actions2 = $admin_object['row_actions']($item, $row_actions);
                    if( is_array($row_actions2) ) $row_actions = $row_actions2;
                }

                // $row_actions_html = '<div class="action" >'.implode('<li class="divider"></li>',$row_actions).'</div>';

                $row_actions_html = '<div class="action">'.implode(' | ',$row_actions).'</div>';

                // $row_actions_html = '<li>'.implode('</li><li>',$row_actions).'</li>';
                $tbody = $tbody.'<tr data-group="'.$group.'" class="'.$class.' '.$class_tr.'" data-status="'.$item->status.'" data-edit="'.route('admin.create_and_show_data',['type'=>$type]).'"" data-id="'.$item->id.'" post-type="'.$item->group.'" tag-type="'.$item->type.'">';
                $tbody = $tbody.'<td><input class="data-show-item" type="checkbox" value="'.$item->id.'" ></td>';
                $string_status = '';
                if( $item->visibility !== 'publish' && $post_filter != 'visibility_'.str_slug($item->visibility) && isset($list_post_filter[str_slug($item->visibility)]['title']) ){
                    $string_status = $string_status.' - '.$list_post_filter[str_slug($item->visibility)]['title'];
                }
                if ( $item->post_date_gmt  && $post_filter != 'post_date_gmt_' && isset( $list_post_filter['future']['title'] ) ){
                     $string_status = $string_status.' - '.$list_post_filter['future']['title'];
                }
                if( $item->status !== 'publish' && $post_filter != 'status_'.str_slug($item->status)  && isset($list_post_filter[str_slug($item->status)]['title']) ){
                    $string_status = $string_status.' - '.$list_post_filter[str_slug($item->status)]['title'];
                }
                if( $item->is_homepage ){
                    $json = json_decode($item->is_homepage,true);
                    $string_status .= ' - '.$json['title'];
                }

                $starred = $item->starred;
                if( $starred ){
                    $starred = '<i class="fa fa-star post-star active" aria-hidden="true"></i>';
                }else{
                    $starred = '<i class="fa fa-star-o post-star" aria-hidden="true"></i>';
                }

                $row_actions_html  = $starred.$row_actions_html;

                $info_time = '<p class="edit_history">Added: '.get_date_time($item->created_at).'<br>Last Updated: '.get_date_time($item->updated_at).'</p>';
                $string_status = '<strong style="font-size:14px;"> '.$string_status.'</strong>';
                $add_row_action = true;

                foreach($fields as $key => $value){
                    if( !isset($value['view']) ) $value['view'] = 'input';
                    if( ( $list_column_show && array_search($key, $list_column_show) !== false ) || (!$list_column_show && (!isset($value['show_data']) || $value['show_data']) ) ){
                        if( isset($value['live_edit']) && $value['live_edit'] && $permission_list['edit'] ){
                            $value['type_post'] = $item->type;
                            $value['value'] = $item[$key];
                            $value['is_live_edit'] = true;
                            $value['key'] = $key;
                            $content = '<div class="live_edit">'.get_field($value['view'], $value, $item).'</div>';
                        }else{
                            if( isset($value['show_data']) && is_callable( $value['show_data']) ){
                                $content =  call_user_func_array($value['show_data'],[$item,$item->{$key}]);
                            }else{
                                if( !is_array($value['view']) ){
                                    if( is_string($value['view']) ){
                                        if( view()->exists( $view = backend_theme('particle.input_field.'.$value['view'].'.view') ) ){
                                            $content = vn4_view($view,['post'=>$item,'key'=>$key, 'field'=>$value, 'value'=> $item->{$key}]);
                                        }else{
                                            $content = e($item[$key]);
                                        }
                                    }else{
                                        $content = e($item[$key]);
                                    }
                                }else{
                                    $content = e($item[$key]);
                                }
                            }
                        }
                        if( $add_row_action ){
                            $add_row_action = false;
                            if( $permission_list['edit'] ){
                                $tbody = $tbody.'<td class="post-col" data-name="'.$key.'"><a href="'.route($route_name_edit,['type'=>$type,'post'=>$item->id,'action_post'=>'edit']).'">'.$content.'</a>'.$string_status.$row_actions_html.'</td>';
                            }else{
                                 if( $permission_list['detail'] ){
                                    $tbody = $tbody.'<td class="post-col" data-name="'.$key.'"><a href="'.route($route_name_edit,['type'=>$type,'post'=>$item->id,'action_post'=>'detail']).'">'.$content.'</a>'.$string_status.$row_actions_html.'</td>';
                                }else{
                                    $tbody = $tbody.'<td class="post-col" data-name="'.$key.'">'.$content.$string_status.$row_actions_html.'</td>';
                                }
                            }
                        }else{
                            $tbody = $tbody.'<td class="post-col" data-name="'.$key.'">'.$content.'</td>';
                        }
                    }
                }

                $tbody = $tbody.'<td>'.$info_time.'</td></tr>';

                // $tbody = $tbody.'<td><div class="dropdown"><div class="action_dots dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span></span></div><ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="ecommerce_category">'.$row_actions_html.'</ul></div></td></tr>';
            }

        }
    }
     $str = $str.$tbody;
    return $str;
}

function vn4_get_pagination($list_data, $post_filter = null ){
    return vn4_view(backend_theme('particle.post-type.paginate'),['list_data'=> $list_data, 'post_filter'=>$post_filter]);
}

