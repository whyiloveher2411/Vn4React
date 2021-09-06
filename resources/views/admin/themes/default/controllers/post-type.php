<?php 

return [
	'get-category'=>function($r){

		$data = do_action('getCategory',$r);

        $type = $r->get('type');
        
        if( !$data ) $data = get_posts($type,10000);

        return response()->json(['data'=>$data]);

	},
	'get-public-view-post'=>function($r){

		$type = $r->get('type');

        if( !$type ) return response()->json(['message'=>'type is request']);

        $admin_object = get_admin_object($type);

        if( !$admin_object ) return response()->json(['message'=>'None Post Type '.$type]);

        if( !$admin_object['public_view'] ) return response()->json(['message'=>'Post Type not design to view public']);

        $id = $r->get(Vn4Model::$id);

        if( !$id ) return response()->json(['message'=>'id is request']);

        $post = get_post($r->get('type'), $r->get(Vn4Model::$id));

        if( !$post ) return response()->json(['message'=>'Don\'t find post id: '.$id ]);

        return vn4_redirect(get_permalinks($post));


	},

	'register-slug'=>function($r){

		$slug = registerSlug($r->get('slug','slug'), $r->get('post_type','PostController_line_40'), $r->get('me_id',-1) );

        return response()->json(['slug'=>$slug,'permalinks'=>get_permalinks($r->get('post_type'), $slug)]);
        
	},

    'input-link'=>function($r){

        $type = $r->get('post_type');
                
        $post = null;

        if( get_admin_object($r->get('route_type')) ){
            $post = get_post($r->get('route_type'),$r->get('post'));
        }

        if( !$r->ajax() ){
            return redirect('/');
        }

        $data = do_action('get_post_controller',$r,$type, $post);

        if( !$data ) $data = get_posts($type,10000);
        // if( $r->get('type_get',false) === 'relationship_mm' ){
        //     return response()->json(['data'=>get_posts_not_paginate($type,100, function($q){
        //         return $q->where('language',Auth::user()->getMeta( 'lang', 'en' ));
        //     })]);
        // }
        return response()->json(['data'=>$data]);
    },

    'star'=>function($r){
        $post_type = $r->get('post_type');
        $id = $r->get('id');

        $post = get_post($post_type, $id);

        if( $post ){

            $star_current = $post->starred;

            if( $star_current ){
                $post->starred = 0;
            }else{
                $post->starred = 1;
            }
            $post->timestamps = false;
            
            $post->save();

            return response()->json(['success'=>true]);
        }

        return response()->json(['error'=>true]);
    },

    'export-data'=>function($r){

        use_module('post');

        $type = $r->get('post-type');
        $file_type = $r->get('file_type');

        $posts = vn4_get_data_table_admin($type, true, null, null, true, true )->get();

        $i = 0;

        $admin_object = get_admin_object($type);

        $file_name = str_slug($admin_object['title']);

        if( $file_type === 'xlsx' ){

            $_filename = $file_name.'.xls';

            header('Content-Encoding: UTF-8');
            header('Content-type: application/xls; charset=UTF-8');
            header('Content-Disposition: attachment; filename='.$_filename);
            echo "\xEF\xBB\xBF";

            echo '<style>  
                table {  
                    font-family: arial, sans-serif;  
                    border-collapse: collapse;  
                    width: 100%;  
                }  
          
                td, th {  
                    border: 1px solid #dddddd;  
                    text-align: left;  
                    padding: 8px; 
                    vertical-align: middle; 
                }  
          
                tr:nth-child(even) {  
                    background-color: #dddddd;  
                }  
            </style><table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>STT</th>';
            echo '<th>ID</th>';
            foreach ($admin_object['fields'] as $f) {
                echo '<th>'.$f['title'].'</th>';
            }
            echo '<th>Created At</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($posts as $p) {
                echo '<tr>';
                echo '<td>'.++$i.'</td>';
                echo '<td>'.$p->id.'</td>';


                foreach ($admin_object['fields'] as $k => $f) {

                    if( !isset($f['view']) || !is_string($f['view']) ) $f['view'] = 'input';
                    
                    if( isset( $f['data_callback']) ){
                        $content = $f['data_callback']($p);
                    }else{

                        if( view()->exists( $view = backend_theme('particle.input_field.'.$f['view'].'.export') ) ){
                            $content = vn4_view($view,['post'=>$p,'key'=>$k, 'field'=>$f, 'value'=>$p[$k], 'file_type'=>$file_type]);
                        }elseif( view()->exists( $view = backend_theme('particle.input_field.'.$f['view'].'.view') ) ){
                            $content = vn4_view($view,['post'=>$p,'key'=>$k, 'field'=>$f, 'value'=>$p[$k]]);
                        }else{
                            $content = $p[$k];
                        }
                    }
                    


                    echo '<td>'.$content.'</td>';
                }


                echo '<td>'.$p->created_at.'</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';

        }elseif( $file_type === 'csv' ){

            $data = [];

            $index = 0;

            foreach ($posts as $key => $p) {
                # code...
                foreach ($admin_object['fields'] as $k => $f) {

                    if( !isset($f['view']) || !is_string($f['view']) ) $f['view'] = 'input';
                    
                    if( isset( $f['data_callback']) ){
                        $content = $f['data_callback']($p);
                    }else{

                        if( view()->exists( $view = backend_theme('particle.input_field.'.$f['view'].'.export') ) ){
                            $content = vn4_view($view,['post'=>$p,'key'=>$k, 'field'=>$f, 'value'=>$p[$k], 'file_type'=>$file_type]);
                        }elseif( view()->exists( $view = backend_theme('particle.input_field.'.$f['view'].'.view') ) ){
                            $content = vn4_view($view,['post'=>$p,'key'=>$k, 'field'=>$f, 'value'=>$p[$k]]);
                        }else{
                            $content = $p[$k];
                        }
                    }
                    $data[$index][$k] = $content;
                }
                ++$index;
            }

            function array2csv(array &$array)
            {
               if (count($array) == 0) {
                 return null;
               }
               ob_start();
               $df = fopen("php://output", 'w');
               fputcsv($df, array_keys(reset($array)));
               foreach ($array as $row) {
                  fputcsv($df, $row);
               }
               fclose($df);
               return ob_get_clean();
            }

            function download_send_headers($filename) {
                // disable caching
                $now = gmdate("D, d M Y H:i:s");
                header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
                header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
                header("Last-Modified: {$now} GMT");

                // force download  
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");

                // disposition / encoding on response body
                header("Content-Disposition: attachment;filename={$filename}");
                header("Content-Transfer-Encoding: binary");
            }

            echo "\xEF\xBB\xBF";
            download_send_headers( $file_name. '.csv');
            echo array2csv($data);
            die();

        }elseif( $file_type === 'json' ){
            header('Content-disposition: attachment; filename='.$file_name.'.json');
            header('Content-type: application/json');
            echo json_encode($posts->toArray(),JSON_PRETTY_PRINT);
        }
    },


    'load-filter-template'=>function($r){
        return vn4_view(backend_theme('post-type.filters'),['r'=> $r]);
    },

    'save-filters'=>function($r){

        $post_type = $r->get('post-type');

        $admin_object = get_admin_object($post_type);

        $admin_object['fields'] = array_merge([
                'id'=>['title'=>'ID','view'=>'number'], 
                'created_at'=>['title'=>'Created At','view'=>'date'],
                'author'=>['title'=>'Author','view'=>'relationship_onetomany','object'=>'user','type'=>'many_record','data'=>['columns'=>['email']]]
        ], $admin_object['fields']);

        $filter_detail = $r->get('filters_added');

        $filters_update = [];

        foreach ($filter_detail as $filter) {
            
            $content = [];
            
            $sql = '';

            $post = get_posts($post_type,['count'=>1, 'callback'=>function($q) use ($admin_object, &$sql, &$content, $filter){

                $sql_prefix = sql_replace($q);

                foreach ($filter['content'] as $key => $value) {

                    $key = $value['type'];

                    if( isset($value[$key]) ){
                        $value = $value[$key];
                    }

                    if(  isset($admin_object['fields'][$key]) ){

                        if( !isset($admin_object['fields'][$key]['view']) ) $admin_object['fields'][$key]['view'] = 'input';
                        $content[$key] = $value;

                        switch ($admin_object['fields'][$key]['view']) {
                            case 'number':
                                $content[$key] = ['from'=>$value['from'],'to'=>$value['to']];
                                if( $value['from'] !== null && $value['to'] !== null){
                                    $q->whereBetween($key, $content[$key]);
                                }elseif( $value['from'] !== null ){
                                    $q->where($key,'>=', $value['from']);
                                }elseif( $value['to'] !== null ){
                                    $q->where($key,'<=', $value['to']);
                                }

                                break;
                            case 'date':

                                $content[$key] = ['from'=>$value['from'],'to'=>$value['to']];
                                if( $value['from'] !== null && $value['to'] !== null){
                                    $q->whereDate($key,'>=',$value['from'])->whereDate($key,'<=',$value['to']);
                                }elseif( $value['from'] !== null ){
                                    $q->whereDate($key,'>=',$value['from']);
                                }elseif( $value['to'] !== null ){
                                    $q->whereDate($key,'<=',$value['to']);
                                }                            
                                break;

                            case 'checkbox':
                            case 'select':
                                if( is_array($value) ){
                                    $q->whereIn( $key,$value );
                                }                     
                                break;
                            default:
                                if( is_array($value) ){
                                    $q->whereIn( $key,$value );
                                }
                                if( is_string($value) ){
                                    $q->where( $key,'LIKE','%'.$value.'%' );
                                }
                                break;
                        }

                    }

                }

                $sql_end = sql_replace($q);
                // dd($sql_end);

                $sql = str_replace($sql_prefix, '', $sql_end);

            }]);

            $filters_update[str_random(10).'_'.str_slug($filter['title'])] = [
                'title'=>$filter['title'],
                'content'=>$content,
                'sql'=>substr($sql, 5)
            ];

        }
        // dd($filters_update);
        // $filters_added = setting('filters_post_type_'.$post_type);

        // if( $filters_added ){
        //     $filters_added = json_decode($filters_added,true)??[];
        // }else{
        //     $filters_added = [];
        // }

        // $edit = $r->get('edit');


        // if( $edit && isset($filters_added[$edit]) ){
        //     $filters_added[$edit] = ['title'=>$filter_name, 'sql'=>substr($sql, 5), 'content'=>$content];
        // }else{
        //     $filters_added[str_random(10).str_slug($filter_name)] = ['title'=>$filter_name, 'sql'=>substr($sql, 5), 'content'=>$content];
        // }

        setting_save('filters_post_type_'.$post_type,$filters_update);

        cache_tag('count_filter', $post_type, 'clear');

        return response()->json(['success'=>true]);
    }
];