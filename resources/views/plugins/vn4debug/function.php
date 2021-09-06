<?php
if( is_admin() ){
	include __DIR__.'/inc/backend.php';
	
}

//show query
add_action('init',function() use ($plugin){

	if(!Auth::check()){
		return;
	}

	$data_plugin = $plugin->getMeta();

	$query_admin 	= false;
	$query_client 	= false;
	$request = request();

	$active_query = $request->get('active_query',false);

	if(isset($data_plugin['general']['show_query_message']) && $data_plugin['general']['show_query_message'] != '' && $active_query == $data_plugin['general']['show_query_message']){
		$active_query = true;
	}else{
		$active_query = false;
	}

	if(isset($data_plugin['general']['show_query_backend'])){
		$query_admin = $data_plugin['general']['show_query_backend'];
	}

	if(isset($data_plugin['general']['show_query_frontend'])){
		$query_client = $data_plugin['general']['show_query_frontend'];
	}

	$is_link_admin =  is_admin();

	if( ($is_link_admin && $query_admin) || (!$is_link_admin && $query_client ) || $active_query){

		if( Auth::user()->customize_time < time() ){
			add_action(['admin_after_open_head','before_vn4_head'],function() use ($plugin){
				echo view_plugin($plugin,'view.script-debug');
			},'debug_error_plugin_time_load_page',true);
		}
		
		$GLOBALS['total_query_debug'] = 0;
		$GLOBALS['total_query_time_debug'] = 0;

		DB::listen(
		    function ($q) {

		    	add_action(['debug_error_query'],function() use ($q){
		    		$time = $q->time;
		    		$sql =  vsprintf( str_replace(['?'], ['\'%s\''], $q->sql ), $q->bindings );

	    			$GLOBALS['total_query_debug'] = $GLOBALS['total_query_debug'] + 1;
	    			$GLOBALS['total_query_time_debug'] = $GLOBALS['total_query_time_debug'] + $time;
	    			echo '<span style="background:#a20000;border: 1px solid white;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;">'.e($sql);
	    			echo ' <span style="color:black;background:white;"> Time: '.$time.'</span>';
	        		echo "</span>";
				});
		    }
		); 

		if(!$is_link_admin ){

			if( Auth::user()->customize_time < time() ){

						
				add_action(['vn4_footer'],function() use ($plugin) {

					echo view_plugin($plugin,'view.info-query');
					
				},'debug_error_plugin_time_query',true);
			}
		}else{

			add_action('list_screen',function($list_screen) use ($plugin) {

				$list_screen[$plugin->key_word] = [
					'title'=>'Plugin Debug Error _ Show Query',
					'title_button'=>'Plugin Debug | <font color="red"><b><span class="total_time"></span></b></font>',
					'html_screen'=>view_plugin($plugin,'view.info-query'),
				];

				return $list_screen;
			});
				
		}

	}

});

