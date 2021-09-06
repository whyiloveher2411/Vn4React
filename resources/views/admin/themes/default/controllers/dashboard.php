<?php

function get_data_dashboard(){
	// Cache::forget('widgets-admin-dashboard');

	$templateWidget = Cache::rememberForever('widgets-admin-dashboard', function(){

		$file_page = glob(cms_path('resource').'views/admin/themes/'.$GLOBALS['backend_theme'].'/dashboard/*.blade.php');
		
		$plugins = plugins();

		foreach ($plugins as $plugin) {
			$file_page = array_merge($file_page, glob(cms_path('resource').'views/plugins/'.$plugin->key_word.'/dashboard/*.blade.php'));
		}

		$file_page = array_merge($file_page, glob(cms_path('resource').'views/themes/'.theme_name().'/dashboard/*.blade.php'));

		sort($file_page);

		foreach ($file_page as $page) {
			$v = basename($page,'.blade.php');

			$view = substr($page, strpos($page, 'views') + 6, -10);
			$view = preg_replace('/[\/]/', '.', $view);

          	$name = capital_letters($v);
          	$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
          	$file_get_contents = file_get_contents( $page );
          	preg_match( '|Template Name:(.*)$|mi', $file_get_contents, $header );
          	if( isset($header[1]) ){
              	$name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
          	}

			$icon = 'fa-life-ring';
			preg_match( '|Icon:(.*)$|mi', $file_get_contents, $header );
          	if( isset($header[1]) ){
              	$icon = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
          	}
          	$templateWidget[$v] = [
				'title'=>$name,
				'icon'=>$icon,
				'view'=>$view,
          	];

		}
		$templateWidget = apply_filter('widgets-admin-dashboard',$templateWidget);

		return $templateWidget;

	});

	return $templateWidget;
}

return [

	'posttype'=>function($r){

		return vn4_view(backend_theme('particle.dashboard-posttype'));

	},



	'index'=>function($r){

		return vn4_view(backend_theme('particle.dashboard.index'));

	},

	'add-widget'=>function($r){

		if( env('EXPERIENCE_MODE') ){
	        return experience_mode();
	    }

		$widgetsConfig = Cache::get('widgets-admin-dashboard');

		$dashboard_widgets = json_decode( setting('admin-dashboard-widgets'), true );


		if( !is_array($dashboard_widgets) || !isset($dashboard_widgets['position']) ){

			$dashboard_widgets = [ 'data'=>[],'position'=>[] ];

		}



		foreach ($dashboard_widgets['data'] as $key => $value) {

			if( isset($value['type']) && !$value['type'] ){

				unset($dashboard_widgets['data'][$key]);

			}

		}

		$type = $r->get('type');

		if( !isset($widgetsConfig[$type]) ) return response()->json(['error'=>'Error 1']);

		$indexWidgetRandom = str_random(10);

		while ( isset($dashboard_widgets['data'][$indexWidgetRandom]) ) {
			$indexWidgetRandom = str_random(10);
		}

		$dashboard_widgets['data'][$indexWidgetRandom] = $widget = [
			'type'=> $type
		];

		setting_save('admin-dashboard-widgets', $dashboard_widgets);

		$column = 1;
		$row = 1;
		$style = '';

		$fileName = cms_path('resource').'views/'.str_replace('.', '/', $widgetsConfig[$type]['view']).'.blade.php';

      	$file_get_contents = file_get_contents( $fileName );
		
      	$name = capital_letters($widgetsConfig[$type]['title']);

      	$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));

      	preg_match( '|Template Name:(.*)$|mi', $file_get_contents, $header );
      	if( isset($header[1]) ){
          	$name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
      	}

		$setting = '<div class="widget-heading"><h2>'.$name.' Settings</h2></div><div class="body"><div class="form-group" style="line-height: 38px;"><label>Column</label>

			<select name="data[column]" class="form-control" style="width:auto;display: inline;">
				<option '.($column == 1 ? 'selected="selected"':'').' value="1">1</option>	
				<option '.($column == 2 ? 'selected="selected"':'').' value="2">2</option>	
				<option '.($column == 3 ? 'selected="selected"':'').' value="3">3</option>	
				<option '.($column == 4 ? 'selected="selected"':'').' value="4">4</option>	
				<option '.($column == 5 ? 'selected="selected"':'').' value="5">5</option>	
				<option '.($column == 6 ? 'selected="selected"':'').' value="6">6</option>	
				<option '.($column == 7 ? 'selected="selected"':'').' value="7">7</option>	
				<option '.($column == 8 ? 'selected="selected"':'').' value="8">8</option>	
				<option '.($column == 9 ? 'selected="selected"':'').' value="9">9</option>	
				<option '.($column == 10 ? 'selected="selected"':'').' value="10">10</option>	
				<option '.($column == 11 ? 'selected="selected"':'').' value="11">11</option>	
				<option '.($column == 12 ? 'selected="selected"':'').' value="12">12</option>	
			</select>&nbsp;&nbsp;

			<label>Row</label>

			<select name="data[row]" class="form-control" style="width:auto;display: inline;">
				<option '.($row == 1 ? 'selected="selected"':'').' value="1">1</option>	
				<option '.($row == 2 ? 'selected="selected"':'').' value="2">2</option>	
				<option '.($row == 3 ? 'selected="selected"':'').' value="3">3</option>	
				<option '.($row == 4 ? 'selected="selected"':'').' value="4">4</option>	
				<option '.($row == 5 ? 'selected="selected"':'').' value="5">5</option>	
			</select>

		</div><div class="form-group"><label>Style (CSS)</label><textarea class="form-control" name="data[style]">'.$style.'</textarea></div>';



		return response()->json([
			'column'=>$column,
			'row'=>$row,
			'index'=>$indexWidgetRandom,
			'type'=>$type,
			'content'=>'<form class="from-setting"><div class="setting-warper">'.$setting.vn4_view($widgetsConfig[$type]['view'],['requset'=>$r,'setting'=>true, 'widget'=>$widget ]).'</div><div><button type="submit" class="vn4-btn vn4-btn-blue" name="action" value="save">Save</button> <button class="vn4-btn" name="action" type="submit" value="cancel">Cancel</button></div></div></form>'

		]);



		// if( isset($list_widget_default[$type]) ){



		// 	if( isset($list_widget_default[$type]['setting']) ){

		// 		$result = [

		// 			'title'=>$list_widget_default[$type]['setting']['title']($r),

		// 			'body'=>$list_widget_default[$type]['setting']['body']($r)

		// 		];

		// 	}elseif( isset($list_widget_default[$type]['dashborad']) ){

		// 		$result = [

		// 			'title'=>$list_widget_default[$type]['dashborad']['title']($r),

		// 			'body'=>$list_widget_default[$type]['dashborad']['body']($r)

		// 		];

		// 	}



		// 	$dashboard_widgets[] = $result;



		// 	setting_save('admin-dashboard-widgets', $dashboard_widgets);



		// 	return response()->json($result);



		// }



	},



	'edit-widget'=>function($r){

	    
		$widgetsConfig = Cache::get('widgets-admin-dashboard');

		$dashboard_widgets = json_decode( setting('admin-dashboard-widgets'), true );

		if( !is_array($dashboard_widgets) || !isset($dashboard_widgets['position']) ){

			$dashboard_widgets = [ 'data'=>[],'position'=>[] ];

		}

		// dd($dashboard_widgets);

		$index = $r->get('index');



		$action = $r->get('action');

		$widget = $dashboard_widgets['data'][$index];

		$column = isset($widget['data']['column']) && $widget['data']['column']? $widget['data']['column'] :1;
		$row = isset($widget['data']['row']) && $widget['data']['row']? $widget['data']['row'] :1;
		$style = isset($widget['data']['style']) && $widget['data']['style']? $widget['data']['style'] :'';

		if( $action === 'save'){

			if( env('EXPERIENCE_MODE') ){
		        return experience_mode();
		    }
		    
			$dashboard_widgets['data'][$index]['data'] = $r->get('data');
			$widget = $dashboard_widgets['data'][$index];
			
			$column = isset($widget['data']['column']) && $widget['data']['column']? $widget['data']['column'] :1;
			$row = isset($widget['data']['row']) && $widget['data']['row']? $widget['data']['row'] :1;
			$style = isset($widget['data']['style']) && $widget['data']['style']? $widget['data']['style'] :'';
			
			setting_save('admin-dashboard-widgets', $dashboard_widgets);
			
			return response()->json([
				'action'=>'save',
				'column'=>$column,
				'row'=>$row,
				'content'=>vn4_view($widgetsConfig[ $dashboard_widgets['data'][$index]['type'] ]['view'],['requset'=>$r,'setting'=>false, 'widget'=>$dashboard_widgets['data'][$index]])
			]);

		}elseif( $action === 'cancel' ){

			return response()->json([
				'action'=>'save',
				'column'=>$column,
				'row'=>$row,
				'content'=>vn4_view($widgetsConfig[ $dashboard_widgets['data'][$index]['type'] ]['view'],['requset'=>$r,'setting'=>false, 'widget'=>$dashboard_widgets['data'][$index]])
			]);

		}else{

			$fileName = cms_path('resource').'views/'.str_replace('.', '/', $widgetsConfig[ $dashboard_widgets['data'][$index]['type'] ]['view'] ).'.blade.php';

	      	$file_get_contents = file_get_contents( $fileName );
			
			$v = basename($fileName,'.blade.php');

      		$name = capital_letters($widgetsConfig[ $dashboard_widgets['data'][$index]['type'] ]['title']);

	      	$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));

	      	preg_match( '|Template Name:(.*)$|mi', $file_get_contents, $header );
	      	if( isset($header[1]) ){
	          	$name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
	      	}


			$setting = '<div class="widget-heading"><h2>'.$name.' Settings</h2></div><div class="body"><div class="form-group" style="line-height: 38px;"><label>Column</label>

				<select name="data[column]" class="form-control" style="width:auto;display: inline;">
					<option '.($column == 1 ? 'selected="selected"':'').' value="1">1</option>	
					<option '.($column == 2 ? 'selected="selected"':'').' value="2">2</option>	
					<option '.($column == 3 ? 'selected="selected"':'').' value="3">3</option>	
					<option '.($column == 4 ? 'selected="selected"':'').' value="4">4</option>	
					<option '.($column == 5 ? 'selected="selected"':'').' value="5">5</option>	
					<option '.($column == 6 ? 'selected="selected"':'').' value="6">6</option>	
					<option '.($column == 7 ? 'selected="selected"':'').' value="7">7</option>	
					<option '.($column == 8 ? 'selected="selected"':'').' value="8">8</option>	
					<option '.($column == 9 ? 'selected="selected"':'').' value="9">9</option>	
					<option '.($column == 10 ? 'selected="selected"':'').' value="10">10</option>	
					<option '.($column == 11 ? 'selected="selected"':'').' value="11">11</option>	
					<option '.($column == 12 ? 'selected="selected"':'').' value="12">12</option>	
				</select>&nbsp;&nbsp;
				<label>Row</label>
				<select name="data[row]" class="form-control" style="width:auto;display: inline;">
					<option '.($row == 1 ? 'selected="selected"':'').' value="1">1</option>	
					<option '.($row == 2 ? 'selected="selected"':'').' value="2">2</option>	
					<option '.($row == 3 ? 'selected="selected"':'').' value="3">3</option>	
					<option '.($row == 4 ? 'selected="selected"':'').' value="4">4</option>	
					<option '.($row == 5 ? 'selected="selected"':'').' value="5">5</option>	
				</select>
			</div><div class="form-group"><label>Style (CSS)</label><textarea class="form-control" name="data[style]">'.$style.'</textarea></div>';

			return response()->json([
				'column'=>$column,
				'row'=>$row,
				'action'=>'setting',
				'content'=>'<form class="from-setting"><div class="setting-warper">'.$setting.vn4_view($widgetsConfig[ $dashboard_widgets['data'][$index]['type'] ]['view'],['requset'=>$r,'setting'=>true, 'widget'=>$widget ]).'</div><div><button type="submit" name="action" value="save" class="vn4-btn vn4-btn-blue">Save</button> <button class="vn4-btn" name="action" type="submit" value="cancel">Cancel</button></div></div></form>'

			]);

		}



	},



	'update-position-widget'=>function($r){

		if( env('EXPERIENCE_MODE') ){
	        return experience_mode();
	    }

		$dashboard_widgets = json_decode( setting('admin-dashboard-widgets'), true );



		if( !is_array($dashboard_widgets) || !isset($dashboard_widgets['position']) ){

			$dashboard_widgets = [ 'data'=>[],'position'=>[] ];

		}



		$dashboard_widgets['position'] = $r->get('position');



		setting_save('admin-dashboard-widgets', $dashboard_widgets);



		return response()->json(['success'=>true]);



	},



	'remove-widget'=>function($r){

		if( env('EXPERIENCE_MODE') ){
	        return experience_mode();
	    }
		

		$index = $r->get('index');



		$dashboard_widgets = json_decode( setting('admin-dashboard-widgets'), true );



		if( !is_array($dashboard_widgets) || !isset($dashboard_widgets['position']) ){

			$dashboard_widgets = [ 'data'=>[],'position'=>[] ];

		}



		unset($dashboard_widgets['data'][$index]);



		foreach ($dashboard_widgets['position'] as $key => $value) {

			if( $value == $index ){

				unset($dashboard_widgets['position'][$key]);

				break;

			}

		}



		setting_save('admin-dashboard-widgets', $dashboard_widgets);



		return response()->json(['success'=>true]);

	},


	'update-view-open'=>function($r){


		$key = $r->get('view');

		$dashborads = get_data_dashboard();

		if( isset($dashborads[$key]) ){

			$user = Auth::user();
			$user->updateMeta('dashboard-view',$key);
			return response()->json(['success'=>true,'reload'=>true]);

		}

	}
];