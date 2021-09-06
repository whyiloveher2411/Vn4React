<?php

add_action('backend',function() use ($plugin) {

	if(!Route::has('admin.plugins.'.$plugin->key_word.'.index')){

		Route::any('/plugins/'.$plugin->key_word,['as'=>'admin.plugins.'.$plugin->key_word.'.index','uses'=>function() use ( $plugin){

			$viewplugin = check_permission('plugin_edit_debug_error');

			if(!$viewplugin){

				vn4_create_session_message( 'Warning', 'You do not have permission to view and edit this page', 'warning' , true);
      			return redirect()->route('admin.index');
			}

			$r = request();

			if($r->isMethod('GET')){	

				$data['plugin'] = plugin($plugin->key_word);

				$data2 =  $data['plugin']->getMeta();
				
				if($data2){

					$data = array_merge($data, $data2  );

				}

				return view_plugin($plugin,'view.admin-setting',$data);
			}

			if($r->isMethod('POST')){

				if( env('EXPERIENCE_MODE') ){
				    return experience_mode();
				}
				
				$input = $r->all();

				$data =  $plugin->getMeta();

				$data['general'] = $input;

				$plugin->updateMeta($data);

				vn4_create_session_message( __('Success'), __p('Update Setting Success.',$plugin->key_word), 'success' , true);
				return redirect()->back();

			}

		}]);

	}
	
});
