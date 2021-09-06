<?php
$type = $r->get('type');


$start_date = $r->get('start_date');
$end_date = $r->get('end_date');

$parameter = ['sort'=>'-ga:users', 'max-results'=>10];

if( $r->get('device_filter') === 'mobile' ){
	$parameter['filters'] = 'ga:deviceCategory!=desktop';
}


$data_detail = multiple_threads_request ([ 

	'data'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users',
		[$r->get('type')],
		$access_token,
		$start_date,
		$end_date,
		$parameter
		)
	]
);


$data = [];

foreach ($data_detail['data']['rows'] as $k => $v) {
	$percent = $v[1]*100/$data_detail['data']['totalsForAllResults']['ga:users'];
	$data[] = [$v[0], $v[1]*1, ["v"=> $percent, "f"=>'<div class="percent_user" style="width:'.($percent<60?$percent:60).'%;"></div>'.number_format($percent,2).'%' ] ];
}


return response()->json($data);
