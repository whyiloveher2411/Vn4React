<?php

return [
	'load-more'=>function($r){

		$shortcuts = json_decode(setting('shortcuts'),true)?:[];

		$listShortcutkey = [];

		foreach ($shortcuts as $k) {
		  if( !$k['delete'] ){

		  	if( $k['link_route']['route_name'] ){

		  		$route_parameter = [];

		  		if( isset($k['link_route']['route_parameter']) ){
			  		foreach ($k['link_route']['route_parameter'] as $i) {
			  			$route_parameter[$i['key']] = $i['value'];
			  		}
		  		}

		  		$k['link'] = route($k['link_route']['route_name'], $route_parameter);
		  	}
	  		unset($k['link_route']);

		  	$listShortcutkey[$k['keyCode']] = $k;

		  }
		}

		header('cache-control: max-age=31536000');
		header('Content-Type: application/javascript');
		die( 'window.listShortcutkey = '.json_encode($listShortcutkey).';' );
		return;
	}
];