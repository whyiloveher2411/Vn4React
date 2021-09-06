<?php

$searchArray = [
	'default'=>['title'=>'Post','callback'=>function( $stringSearchArray, $search, $keySearch, $admin_object ){

        if( isset($admin_object[$stringSearchArray[0]]) ){

            $titleKey = array_keys($admin_object[$stringSearchArray[0]]['fields'])[0];

            $data = Vn4Model::table($admin_object[$stringSearchArray[0]]['table'])->where('type',$stringSearchArray[0])->select(Vn4Model::$id,$titleKey, 'type');


            if( isset($stringSearchArray[1]) && $title = trim($stringSearchArray[1]) ){
                $data = $data->where($titleKey,'LIKE','%'.$title.'%');
            }
            
            $data = $data->orderBy('created_at','desc')->limit(10)->get()->toArray();

            foreach ($data as $key => $value) {
                $data[$key]['title'] = $value[$titleKey]; 
            }


        }else{

            if( isset($stringSearchArray[1]) ){

                $object_find = [];
                $string2 = str_slug($stringSearchArray[0]);

                foreach ($admin_object as $key => $value) {

                    $string1 = str_slug($key);
                    similar_text($string1, $string2, $perc);

                    if( strpos( $string1 , $string2 ) !== false || $perc > 50 ){
                        $object_find[] = $key;
                    }
                }

                $data = [];

                foreach ($object_find as $key) {

                    $title = array_keys($admin_object[$key]['fields'])[0];

                    $dataTemp = \Illuminate\Support\Facades\DB::table($admin_object[$key]['table'])->where('type',$key)->where(function($q) use ($title, $stringSearchArray, $admin_object, $key ) {

                        $q->orWhere($title,'LIKE','%'.trim($stringSearchArray[1]).'%');

                        if( isset($admin_object[$key]['fields']['slug']) ){
                            $q->orWhere('slug','LIKE','%'.str_slug($stringSearchArray[1]).'%');
                        }


                    })->select(Vn4Model::$id,$title, 'type')->orderBy('created_at','desc')->limit(10)->get()->toArray();


                    foreach ($dataTemp as $keyData => $valueData) {
                        $dataTemp[$keyData]->title = $valueData->{$title}; 
                    }

                    $data = array_merge($data, $dataTemp);

                    if( count($data) >= 10 ){
                        break;
                    }

                }
                

            }else{

                $data = [];

                foreach ($admin_object as $key => $object) {

                    $title = array_keys($object['fields'])[0];

                    $dataTemp = \Illuminate\Support\Facades\DB::table($object['table'])->where('type',$key)->where(function($q) use ($title, $search, $admin_object, $key ) {

                        $q->orWhere($title,'LIKE','%'.$search.'%');

                        if( isset($admin_object[$key]['fields']['slug']) ){
                            $q->orWhere('slug','LIKE','%'.str_slug($search).'%');
                        }


                    })->select(Vn4Model::$id,$title, 'type')->orderBy('created_at','desc')->limit(10)->get()->toArray();

                    foreach ($dataTemp as $keyData => $valueData) {
                        $dataTemp[$keyData]->title = $valueData->{$title}; 
                    }

                    $data = array_merge($data, $dataTemp);

                    if( count($data) >= 10 ){
                        break;
                    }

                }

            }

        }

        $data = array_slice($data,0,10);

        foreach ($data as $key => $value) {

            $value = (array) $value;
            $data[$key] = $value;

            if( !isset($value['link']) && !isset($value['title_type']) ){

                $data[$key]['link'] = route('admin.create_data',['type'=>$value['type'],'post'=>$value[Vn4Model::$id],'action_post'=>'edit']);
                $data[$key]['title_type'] = $admin_object[$value['type']]['title'];
            }
        }
        // dd($data);
        return $data;
    }],
    'show'=>['title'=>'Show Data','callback'=>'new'],
    'new'=>['title'=>'New Data','callback'=>function( $stringSearchArray, $search, $keySearch, $admin_object ){

        $argRouteName = ['new'=>['admin.create_data','New'], 'create'=>['admin.create_data','New'] ,'show'=>['admin.show_data','Show Data']];

        if( isset($stringSearchArray[1]) && $string2 = str_slug($stringSearchArray[1]) ){
            
            $data = [];

            foreach ($admin_object as $key => $value) {

                $string1 = str_slug($key);

                similar_text($string1, $string2, $perc);

                if( strpos( $string1 , $string2 ) !== false || $perc > 50 ){
                    $data[] = ['title'=>$value['title'],'title_type'=>$argRouteName[$keySearch][1],'link'=>route($argRouteName[$keySearch][0],['type'=>$key])];
                }
            }

        }else{
            $data = [];

            foreach ($admin_object as $key => $value) {
                $data[] = ['title'=>$value['title'],'title_type'=>$argRouteName[$keySearch][1],'link'=>route($argRouteName[$keySearch][0],['type'=>$key])];
            }
        }

        return $data;

    }],
    'manage'=>['title'=>'Manage','callback'=>function( $stringSearchArray, $search, $keySearch, $admin_object ){

        $data = [];

        $data[] = ['title_type'=>'Manage','title'=>'Log','link'=>route('admin.page','log')];
        $data[] = ['title_type'=>'Manage','title'=>'Media','link'=>route('admin.page','media')];
        $data[] = ['title_type'=>'Manage','title'=>'Theme','link'=>route('admin.page','theme')];
        $data[] = ['title_type'=>'Manage','title'=>'Theme Customize','link'=>route('admin.page','appearance-customize')];
        $data[] = ['title_type'=>'Manage','title'=>'Theme Widget','link'=>route('admin.page','appearance-widget')];
        $data[] = ['title_type'=>'Manage','title'=>'Theme Menu','link'=>route('admin.page','appearance-menu')];
        $data[] = ['title_type'=>'Manage','title'=>'Theme options','link'=>route('admin.page','theme-options')];
        $data[] = ['title_type'=>'Manage','title'=>'Profile','link'=>route('admin.page','profile')];
        $data[] = ['title_type'=>'Manage','title'=>'Tool','link'=>route('admin.page','tool-genaral')];
        $data[] = ['title_type'=>'Manage','title'=>'Plugin','link'=>route('admin.page','plugin')];
        $data[] = ['title_type'=>'Manage','title'=>'Setting','link'=>route('admin.page','setting')];
        $data[] = ['title_type'=>'Manage','title'=>'Environment','link'=>route('admin.page','environment')];
        $data[] = ['title_type'=>'Manage','title'=>'Cache Management','link'=>route('admin.page','cache-management')];
        $data[] = ['title_type'=>'Manage','title'=>'Entity Relationship','link'=>route('admin.page','entity-relationship')];

        if( isset($stringSearchArray[1]) && trim($stringSearchArray[1]) ){

            $result = [];

            $string2 = mb_strtolower( trim($stringSearchArray[1]) );

            foreach ($data as $key => $value) {

                $string1 = mb_strtolower( str_replace(' ', '', preg_replace( '/[^ \w]+/', '', $value['title'])));

                similar_text( $string1, $string2, $perc);

                if( strpos( $string1 , $string2 ) !== false ||  $perc > 50 ){
                   $result[] = $value;
                }
            }

        }else{
            $result = $data;
        }

        return $result;
    }],
    'menu'=>['title'=>'Menu','callback'=>function( $stringSearchArray, $search, $keySearch, $admin_object ){
        $data = Vn4Model::table(vn4_tbpf().'menu')->where('type','menu_item')->where('status',1)->orderBy('title','asc')->where('theme',theme_name());

        if( isset($stringSearchArray[1]) && ( $title = trim($stringSearchArray[1] ) ) ){
            $data = $data->where('title','LIKE','%'.$title.'%');
        }

        $data = $data->select(Vn4Model::$id, 'title' , 'type')->limit(10)->get()->toArray();

        $data = array_slice($data,0,10);

        foreach ($data as $key => $value) {
            $data[$key]['link'] = route('admin.page',['page'=>'appearance-menu','id'=>$value[Vn4Model::$id]]);
            $data[$key]['title_type'] = 'Menu Item';
        }

        return $data;
    }],
    'tool'=>['title'=>'Tool','callback'=>function( $stringSearchArray, $search, $keySearch, $admin_object ){
        $data = [];

        $data[] = ['title_type'=>'Tool','title'=>'Render Model','link'=>route('admin.page',['page'=>'tool-genaral','action'=>'render-model','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Check Database','link'=>route('admin.page',['page'=>'tool-genaral','action'=>'check-database','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Backup Database','link'=>route('admin.page',['page'=>'tool-genaral','action'=>'backup-database','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Restore Database','link'=>route('admin.page',['page'=>'restore-database','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Copy Asset To Public','link'=>route('admin.page',['page'=>'restore-database', 'action'=>'develop-asset','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Minify Html View','link'=>route('admin.page',['page'=>'tool-genaral', 'action'=>'minify-html','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Refresh Views','link'=>route('admin.page',['page'=>'tool-genaral', 'action'=>'refresh-views','rel'=>'search'])];
        $data[] = ['title_type'=>'Tool','title'=>'Clear Cache','link'=>route('admin.page',['page'=>'tool-genaral', 'action'=>'clear-cache','rel'=>'search'])];
        

        if(  isset($stringSearchArray[1]) && trim($stringSearchArray[1]) ){

            $result = [];

            $string2 = mb_strtolower( trim($stringSearchArray[1]) );

            foreach ($data as $key => $value) {

                $string1 = mb_strtolower( str_replace(' ', '', preg_replace( '/[^ \w]+/', '', $value['title'])));

                similar_text( $string1, $string2, $perc);

                if( strpos( $string1 , $string2 ) !== false ||  $perc > 50 ){
                   $result[] = $value;
                }
            }

        }else{
            $result = $data;
        }

        return $result;
    }],
];


$plugins = plugins();

foreach ($plugins as $plugin) {
  if( file_exists( $file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/admin-search.php')) ){
    $serach = include $file;
    if( is_array($serach) ){
        $searchArray = array_merge($searchArray, $serach);
    }
  }
}

$theme_name = theme_name();
if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/admin-search.php')) ){
    $serach = include $file;
    if( is_array($serach) ){
        $searchArray = array_merge($searchArray, $serach);
    }
}

return $searchArray;