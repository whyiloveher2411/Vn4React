<?php

$permission_plugin_action = check_permission('plugin_action');

if(!$permission_plugin_action){
	vn4_create_session_message( __('Fail'), 'You do not have permission to change plugin status', 'fail', true );
	return redirect()->back();
}


if( $r->has('plugin') ){

	if( env('EXPERIENCE_MODE') ){
        return experience_mode();
    }
    
	$content = $r->get('plugin');

	$obj = new Vn4Model(vn4_tbpf().'plugin');


	$plugin = Vn4Model::firstOrAddnew(vn4_tbpf().'plugin',['key_word'=>$content]);

	$status = $plugin->status === 'publish'? 'un_publish': 'publish';

	if( $status === 'publish' &&  file_exists( $file = cms_path('resource').'views/plugins/'.$plugin->key_word.'/inc/activate.php') ){

		$install = include $file;

		if( $install !== 1 ) return $install;

	}elseif( $status === 'un_publish' &&  file_exists( $file = cms_path('resource').'views/plugins/'.$plugin->key_word.'/inc/deactivate.php' ) ){
		$uninstall = include $file;

		if( $uninstall !== 1 ) return $uninstall;
	}

	$info = json_decode(File::get(Config::get('view.paths')[0].'/plugins/'.$content.'/info.json'));

	$plugin->author = Auth::id();
	$plugin->status = $status;

	$plugin->title = $info->name;


	$plugin->save();

}

return redirect()->back();
