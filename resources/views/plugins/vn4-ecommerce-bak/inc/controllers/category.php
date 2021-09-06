<?php

return [
	'filters'=>function($r, $plugin){
		
		$ids = $r->get('ids');

		$result = [];

		return view_plugin($plugin, 'views.category.filter_value',['ids'=>$ids, 'filter_value'=>Request::get('filter_value')]);
		
	}
];