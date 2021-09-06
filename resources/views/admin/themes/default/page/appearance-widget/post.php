<?php

$data = $r->get('list_sidebar_widget');

if( env('EXPERIENCE_MODE') ){
	return experience_mode();
}

$result = [];

foreach ($data as $sidebar) {


	$sidebarKey = key($sidebar);
	$sidebarValue = $sidebar[$sidebarKey];

	$sidebarValueResult = [];

	if( is_array($sidebarValue) ){
		foreach ($sidebarValue as $sidebarValueItem) {


			$type = $sidebarValueItem['type'];
			$valuteItem = [];

			foreach ($sidebarValueItem['data'] as $sidebarValueItemInput) {

				parse_str($sidebarValueItemInput, $output);
				$valuteItem = array_merge($valuteItem,$output);
				
			}

			$sidebarValueResult[] = ['type'=>$type,'data'=>$valuteItem];
		}
	}

	$result[$sidebarKey] = $sidebarValueResult;

}



$list_widgets = use_module('widget');

foreach ($result as $keySidebar => $valueSidebar) {

	$html = [];


	foreach ($valueSidebar as $widget) {

		$key = $widget['type'];

		if( isset($list_widgets[$key]) ){

			$widgetDetail = $list_widgets[$key];
			$widgetDetail['data'] = $widget['data'];

			$widgetObject = new Vn4Widget($key, $widgetDetail['title'], $widgetDetail );

	    	$html[] = ['title'=> $widgetObject->get_data('title','') ,'html'=>''];

		}

      	
  	}

	$sidebar = Vn4Model::firstOrAddnew(vn4_tbpf().'widget',['sidebar_id'=>$keySidebar,'theme'=>theme_name()]);
    $sidebar->content = json_encode($valueSidebar);
    $sidebar->html = json_encode($html);
    $sidebar->save();

}

cache_tag('sidebar',null, 'clear');

return 'widget end';
