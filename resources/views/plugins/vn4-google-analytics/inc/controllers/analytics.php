<?php

return [
	'index'=>function($r,$plugin){

		if( check_permission('plugin_google_analytics_view_dashboard') ){
			return view_plugin($plugin,'views.analytics',['plugin'=>$plugin]);
		}

		vn4_create_session_message('Permission','You do not have permission to view google analytics reports!','warning');

		return redirect()->back();

	},
	'change-website'=>function($r, $plugin){


		$access_code = $plugin->getMeta('access_token_first');

		// $webpropertie_id = json_decode($r->get('webpropertie_id'));

		$listAnalyticsWebsite = $plugin->getMeta('listAnalyticsWebsite');

		$webChange =  $r->get('value');

		if( isset($listAnalyticsWebsite[$webChange]) ){
			$webid = $listAnalyticsWebsite[$webChange];
			$access_code['webpropertie_id'] = $webid[0];
			$dataMeta['website'] = $webid;
		}
		$dataMeta['access_token_first'] = $access_code;
		$plugin->updateMeta($dataMeta);

		return response()->json(['success'=>true]);

	}
];