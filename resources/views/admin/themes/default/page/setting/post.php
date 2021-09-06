<?php

if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

if( $r->ajax() ){
  return response()->json(['result'=>date($r->get('data'))]);
}


if(!check_permission('view_setting')){
  vn4_create_session_message( __('Warning'), __('You do not have permission to view the setting'), 'warning');
  return redirect()->back();
}

if( $r->get('type_view') === 'custom-fields' ){

  $metas = $r->get('setting');

  $input = [];

  foreach ($metas as $i) {

    if( $i['delete'] ){
      DB::table(vn4_tbpf().'setting')->where('type','setting')->where('key_word',$i['key'])->delete();
    }else{
      $value = $i['value'];
      $key = $i['key'];

      $string = str_replace('\n', '', $value);
      $string = rtrim($string, ',');
      $string = "[" . trim($string) . "]";
      $json = json_decode($string, true);

      if( isset($json[0]) ) $value = $json[0];

      $input[$key] = $value;
    }

  }
}else{
  $input = $r->post();

  unset($input['_token']);
  
  file_put_contents( cms_path('root', 'cms/overwrite_function.php' ) , file_get_contents( cms_path('root','cms/environment_'.$input['general_status'].'.php') ) );

  $setting_config = get_setting_object();

  foreach ($setting_config as $key => $v) {
    foreach ($v['fields'] as $key2 => $v2) {
      if( isset($v2['save']) && is_callable($v2['save']) ){
          $input[$key.'_'.$key2] =  call_user_func_array($v2['save'], [$input]);
      }

    }
  }

}




if( isset($input['security_accept_ip_login']) ){
  $ipAccess = $input['security_accept_ip_login']??'';

  preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $ipAccess, $ip_matches);

  if( count($ip_matches[0]) ){
    array_unshift($ip_matches[0], '127.0.0.1');
    $ip_matches = array_flip($ip_matches[0]);
    $ip_matches = array_flip($ip_matches);
    $input['security_accept_ip_login'] = implode("\r\n",$ip_matches);
  }else{
    $input['security_accept_ip_login'] = '';
  }
}

if( isset($input['general_date_format']) && $input['general_date_format'] === 'custom_date' ){
  $input['general_date_format'] = $input['general_date_format_input_custom'];
}

if( isset($input['general_time_format']) && $input['general_time_format'] === 'custom_date' ){
  $input['general_time_format'] = $input['general_time_format_input_custom'];
}

$linkAdminOld = $linkAdminNew = setting('security_prefix_link_admin','admin');

if( isset($input['security_prefix_link_admin']) ){
  $linkAdminNew = $input['security_prefix_link_admin'];

  if( !$linkAdminNew ) $linkAdminNew = 'admin';
}

foreach ($input as $k => $v) {
    if( $v ){
      setting_save($k, $v);
    }else{
      setting_save($k, '');
    }
}

Cache::forget('setting.');

vn4_create_session_message( __('Success'), __('Update setting successful.'), 'success');

return redirect( str_replace('/'.$linkAdminOld.'/page/tool-genaral', '/'.$linkAdminNew.'/page/tool-genaral',route('admin.page',['page'=>'tool-genaral','clear_cache'=>'true','rel'=>str_replace($linkAdminOld, $linkAdminNew, URL::previous() )])) );
  

