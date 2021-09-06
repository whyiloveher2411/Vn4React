<?php 

// sleep(100);
$r = request();

$input = json_decode($r->getContent(),true);

if( $input ){
    $r->merge($input);
}

$result = [];


if( $param1 === 'in-active-plugin'){

   if( config('app.EXPERIENCE_MODE') ){
        return experience_mode();
    }
    
    $content = $r->get('plugin');

    $obj = new Vn4Model(vn4_tbpf().'plugin');


    $post = Vn4Model::firstOrAddnew(vn4_tbpf().'plugin',['type'=>'plugin','key_word'=>$content]);

    $status = $post->status === 'publish'? 'un_publish': 'publish';
    
    $info = json_decode(File::get(Config::get('view.paths')[0].'/plugins/'.$content.'/info.json'));

    $post->status = $status;
    $post->priority = isset($info->priority) ? $info->priority : 99;

    $post->title = $info->name;

    $post->save();

    unset($GLOBALS['listPlugin']);

    $result['message'] = apiMessage('Change Plugin Success.');
    
    $result['sidebar'] = include __DIR__.'/../adminSidebar/get.php';

    if( $status === 'publish' &&  file_exists( $file = cms_path('resource').'views/plugins/'.$post->key_word.'/inc/activate.php') ){

      $install = include $file;
  
      if( $install !== 1 ) return $install;
  
    }elseif( $status === 'un_publish' &&  file_exists( $file = cms_path('resource').'views/plugins/'.$post->key_word.'/inc/deactivate.php' ) ){
      
      $uninstall = include $file;
  
      if( $uninstall !== 1 ) return $uninstall;

    }
    
    require_once(__DIR__.'/../tool/compile-di.php');

}



 $plugin_status = Request::get('plugin_status','all');
 
 $plugin_status_all = ['all','active','inactive','update'];
 
 $plugin_status = array_search($plugin_status, $plugin_status_all) !== false ? $plugin_status : 'all';
 
 title_head( __('Plugins') );
 
 $strTable2 = '';
 
  $obj = Vn4Model::table(vn4_tbpf().'plugin');
 
  $list = File::directories(Config::get('view.paths')[0].'/plugins/');
  sort($list);
 
  $all = 0;
  $active = 0;
  $inactive = 0;
  $update = 0;
  
  $button ='';

  $permission_plugin_action = check_permission('plugin_action');

  $listPlugin = plugins(true)->keyBy('key_word');

foreach ($list as $value) {

     $folder_theme = basename($value);
 
     $fileName = $value.'/info.json';
 
     if( !file_exists( $fileName ) ){
 
         continue;
 
     }
 
     ++$all;
 
     $info = json_decode(File::get($fileName));
 
     $isActive = isset($listPlugin[$folder_theme]) && $listPlugin[$folder_theme]->status === 'publish';
 
     $class = '';
     if($isActive !== false){
        $plugin = $listPlugin[$folder_theme];
       ++$active;
       $class = 'active';
     }else{
        $plugin = null;
        ++$inactive;
     }
 
     if( $plugin_status !== 'all' ){
 
       if( ($isActive && $plugin_status !== 'active') || (!$isActive && $plugin_status !== 'inactive') ){
         continue;
       }
 
     }

      $result['rows'][$folder_theme] = [
        'info'=>$info,
        'active'=>$isActive,
        'image'=> plugin_asset($folder_theme, isset($info->featured) ? $info->featured : 'plugin.png'),
        'document'=>'https://www.google.com/search?'.http_build_query(['q'=>'vn4cms.com '.$info->name]),
      ];
 }

$result['plugins'] = plugins(true)->keyBy('key_word');
 return $result;