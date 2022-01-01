<?php 
// Icon: fa-pie-chart

$r = request();
$inpnut = json_decode($r->getContent(),true);

$plugin = plugin('vn4seo');

require_once __DIR__.'/../../../function-helper.php';



$settings = setting('seo/analytics/google_search_console');

if( !$settings ){
	return [
		'error'=>true,
		'rows'=>[],
		'message'=> apiMessage('Not finished install google console api.', 'error')
	];
}

if( isset($settings['anylticWebsite']) && $settings['anylticWebsite'] ){

	if( $inpnut['step'] === 'getDataOverview' ){

		$query = http_build_query([
			'startDate'=> $inpnut['date'][1],
			'endDate'=> $inpnut['date'][0],
			'rowLimit'=>1000,
			'searchType'=>'WEB',
			'dimensions'=>'date'
		]);

		$access_token = searchConsoleGetAccessToken($plugin);

		$result = json_decode(file_post_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($settings['anylticWebsite']).'/searchAnalytics/query?access_token='.$access_token.'&'.$query),true);

		if( isset($result['rows']) ){
			return $result;
		}

		return [
			'error'=>true,
			'rows'=>[],
			'message'=>apiMessage('No data available.', 'warning')
		];
		
		
	}

	if( $inpnut['step'] === 'getDataDetail' ){

		$query = http_build_query([
			'startDate'=> $inpnut['date'][1],
			'endDate'=> $inpnut['date'][0],
			'rowLimit'=>1000,
			'searchType'=>'WEB',
			'dimensions'=>$inpnut['dimensions']
		]);

		$access_token = searchConsoleGetAccessToken($plugin);

		$result = json_decode(file_post_contents_curl('https://www.googleapis.com/webmasters/v3/sites/'.urlencode($settings['anylticWebsite']).'/searchAnalytics/query?access_token='.$access_token.'&'.$query),true);

		if( isset($result['rows']) ){
			return $result;
		}

		return [
			'error'=>true,
			'rows'=>[],
			'message'=> apiMessage('No data available.', 'warning')
		];

	}

}
