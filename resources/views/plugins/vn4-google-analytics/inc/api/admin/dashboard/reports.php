<?php 
// Icon: fa-pie-chart

$r = request();
$step = json_decode($r->getContent(),true);


function thousandsCurrencyFormat($num) {
  if($num>1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
  }
  return $num;
}



$start_date = $r->get('start-date',date('Y-m-d', strtotime(' -7 day')));
$end_date = $r->get('end-date',date('Y-m-d', strtotime(' -1 day')));
$start_date2 = $r->get('start-date',date('Y-m-d', strtotime(' -14 day')));
$end_date2 = $r->get('end-date',date('Y-m-d', strtotime(' -8 day')));
$start_date_now1 = date('Y-m-d');
include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/function-helper.php');

$plugin = plugin('vn4-google-analytics');

$access_code = $plugin->getMeta('access_token_first');

$webpropertie_id = $access_code['webpropertie_id'];

$access_token = get_access_token($plugin);


if( $step['step'] === 'getDataRealtime' ){

    $hour1 = date('H');
    $hour2 =  date('H', strtotime(' -1 hour'));
	if( $hour1 > 0 ){
	  $start_date_now2 = $start_date_now1;
	}else{
	  $start_date_now2 = date('Y-m-d', strtotime(' -1 day'));
	}

    $dataGoogle = multiple_threads_request([
        'realtime'=>'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath&metrics=rt:activeUsers&sort=-rt:activeUsers&order=-rt:activeUsers&max-results=5&access_token='.$access_token,
        'pageview30_1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now1, $start_date_now1,['filters'=>'ga:hour=='.$hour1] ),
    	'pageview30_2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now2, $start_date_now2,['filters'=>'ga:hour=='.$hour2] ),
    	'sessions_by_device'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id,'ga:sessions',
            ['ga:deviceCategory'],
            $access_token,
            $start_date,
            $end_date,
            ['sort'=>'-ga:deviceCategory','max-results'=>10]
            ),
        'sessions_by_device2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id,'ga:sessions',
            ['ga:deviceCategory'],
            $access_token,
            $start_date2,
            $end_date2,
            ['sort'=>'-ga:deviceCategory','max-results'=>10]
            ),
    ]);

    $dataPageView30M = [];
    $index = 0;

    $minume = date('i');

    if( isset($dataGoogle['pageview30_1']['rows']) ){
	    $count = count($dataGoogle['pageview30_1']['rows']) - 1;
	    for ($i=$count; $i >= 0 ; $i--) { 
	    	
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[($minume - $dataGoogle['pageview30_1']['rows'][$i][0]*1)] =  $dataGoogle['pageview30_1']['rows'][$i][1];
	    	$index ++;
	    }
    }
    if( $index < 31 && isset($dataGoogle['pageview30_2']['rows'][0]) ){
	    $count = count($dataGoogle['pageview30_2']['rows']) - 1;
		for ($i=$count; $i >= 0 ; $i--) { 
	    	 
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[($minume + 60 ) - $dataGoogle['pageview30_2']['rows'][$i][0]*1] =  $dataGoogle['pageview30_2']['rows'][$i][1];
	    	$index ++;
	    }
    }

    $result = [
    	 'general'=>$dataGoogle,
        'dataPageView30M'=>$dataPageView30M,
    ];

    if( isset($dataGoogle['sessions_by_device']['rows'][0]) ){

        $deviceView = [];

        foreach ($dataGoogle['sessions_by_device']['rows'] as $k => $v){
           if( !isset($deviceView[ $v[0] ]) )  $deviceView[ $v[0] ] = [];
           $deviceView[ $v[0] ][0] = $v[1];
        }

        foreach ($dataGoogle['sessions_by_device2']['rows'] as $k => $v){
            if( !isset($deviceView[ $v[0] ]) )  $deviceView[ $v[0] ] = [];
            $deviceView[ $v[0] ][1] = $v[1];
        }

        foreach( $deviceView as $device => $value ){

            $result['sessions_by_device'][ $device ] = [
                $device,
                intval( $value[0] ?? 0 ), 
                round(intval( $value[0] ?? 0 ) * 100 / ($dataGoogle['sessions_by_device']['totalsForAllResults']['ga:sessions'] ?? 1),1), 
                round( intval( $value[0] ?? 0 ) * 100 / (  $value[1] ?? 1 ) - 100, 1 ) 
            ];

        }
        
    }

    $dataPageView30M = array_reverse($dataPageView30M);

    return $result;

}

if( $step['step'] === 'updateRealtime' ){
    $hour1 = date('H');
    $hour2 =  date('H', strtotime(' -1 hour'));
	if( $hour1 > 0 ){
	  $start_date_now2 = $start_date_now1;
	}else{
	  $start_date_now2 = date('Y-m-d', strtotime(' -1 day'));
	}

    $dataGoogle = multiple_threads_request([
        'realtime'=>'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath&metrics=rt:activeUsers&sort=-rt:activeUsers&order=-rt:activeUsers&max-results=5&access_token='.$access_token,
        'pageview30_1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now1, $start_date_now1,['filters'=>'ga:hour=='.$hour1] ),
    	'pageview30_2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now2, $start_date_now2,['filters'=>'ga:hour=='.$hour2] ),
    ]);

    $dataPageView30M = [];
    $index = 0;

    $minume = date('i');

    if( isset($dataGoogle['pageview30_1']['rows']) ){
	    $count = count($dataGoogle['pageview30_1']['rows']) - 1;
	    for ($i=$count; $i >= 0 ; $i--) { 
	    	
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[($minume - $dataGoogle['pageview30_1']['rows'][$i][0]*1)] =  $dataGoogle['pageview30_1']['rows'][$i][1];
	    	$index ++;
	    }
    }
    if( $index < 31 && isset($dataGoogle['pageview30_2']['rows'][0]) ){
	    $count = count($dataGoogle['pageview30_2']['rows']) - 1;
		for ($i=$count; $i >= 0 ; $i--) { 
	    	 
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[($minume + 60 ) - $dataGoogle['pageview30_2']['rows'][$i][0]*1] =  $dataGoogle['pageview30_2']['rows'][$i][1];
	    	$index ++;
	    }
    }

    $result = [
        'general'=>$dataGoogle,
        'dataPageView30M'=>$dataPageView30M,
    ];

    $dataPageView30M = array_reverse($dataPageView30M);

    return $result;
}


if( $step['step'] === 'getData1' ){

    function list_colours($start, $end, $steps = 6)
    {
        $return = array();

        $start_r = hexdec(substr($start, 1, 2));
        $start_g = hexdec(substr($start, 3, 2));
        $start_b = hexdec(substr($start, 5, 2));

        $end_r = hexdec(substr($end, 1, 2));
        $end_g = hexdec(substr($end, 3, 2));
        $end_b = hexdec(substr($end, 5, 2));

        $shift_r = ($end_r - $start_r) / $steps;
        $shift_g = ($end_g - $start_g) / $steps;
        $shift_b = ($end_b - $start_b) / $steps;

        for ($i = 0; $i < $steps; $i++)
        {
            $color = array();
            $color[] = dechex($start_r + ($i * $shift_r));
            $color[] = dechex($start_g + ($i * $shift_g));
            $color[] = dechex($start_b + ($i * $shift_b));

            // Pad with zeros.
            $color = array_map(function ($item) {
                    return str_pad($item, 2, "0", STR_PAD_LEFT);
                },
                $color
            );

            $return[] = '#' . implode($color);
        }

        return $return;
    }

    $listColours = list_colours('#93d5ed','#2f5ec4',50);



    $hour1 = date('H');
    $hour2 =  date('H', strtotime(' -1 hour'));
	if( $hour1 > 0 ){
	  $start_date_now2 = $start_date_now1;
	}else{
	  $start_date_now2 = date('Y-m-d', strtotime(' -1 day'));
	}

    $dataGoogle = multiple_threads_request([
    	
    	'card1_total'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
    		$webpropertie_id, ['ga:users,ga:sessions,ga:bounceRate,ga:avgSessionDuration'],
    		[],
    		$access_token, $start_date, $end_date
    		),
    	'card2_total'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
    		$webpropertie_id, ['ga:users,ga:sessions,ga:bounceRate,ga:avgSessionDuration'],
    		[],
    		$access_token, $start_date2, $end_date2
    		),
    	'card1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
    		$webpropertie_id, ['ga:users,ga:sessions,ga:bounceRate,ga:avgSessionDuration'],
    		['ga:date'],
    		$access_token, $start_date, $end_date
    		),
    	'card2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
    		$webpropertie_id, ['ga:users,ga:sessions,ga:bounceRate,ga:avgSessionDuration'],
    		['ga:date'],
    		$access_token, $start_date2, $end_date2
    		),
    	'realtime'=>'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath&metrics=rt:activeUsers&sort=-rt:activeUsers&order=-rt:activeUsers&max-results=5&access_token='.$access_token,
    	'pageview30_1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now1, $start_date_now1,['filters'=>'ga:hour=='.$hour1] ),
    	'pageview30_2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now2, $start_date_now2,['filters'=>'ga:hour=='.$hour2] ),
    	'session_country'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
    		$webpropertie_id, ['ga:sessions'],
    		['ga:country'],
    		$access_token, $start_date, $end_date,['sort'=>'-ga:sessions']
    		),
    	'userVisitor'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
	        $webpropertie_id,
	        'ga:users',
	        ['ga:userType'],
	        $access_token,
	        $start_date,
	        $end_date,
	        ['sort'=>'ga:userType']
        )
    ]);

    foreach ($dataGoogle as $key => $value) {
    	if( !isset($value['rows']) ){
    		$dataGoogle[$key]['rows'] = [];
    	}
    }
	
    $dataPageView30M = [];
    $index = 0;
    if( isset($dataGoogle['pageview30_1']['rows']) ){
	    $count = count($dataGoogle['pageview30_1']['rows']) - 1;
	    for ($i=$count; $i >= 0 ; $i--) { 
	    	
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[$index.' mins ago'] = $dataGoogle['pageview30_1']['rows'][$i][1];
	    	$index ++;
	    }
    }
    if( $index < 31 ){
	    $count = count($dataGoogle['pageview30_2']['rows']) - 1;
		for ($i=$count; $i >= 0 ; $i--) { 
	    	
	    	if( $index > 29 ){
	    		break;
	    	}
	    	$dataPageView30M[$index.' mins ago'] = $dataGoogle['pageview30_2']['rows'][$i][1];
	    	$index ++;
	    }
    }

    $dataPageView30M = array_reverse($dataPageView30M);

    if( !isset($dataGoogle['card1_total']['totalsForAllResults']) ){
        return [
            'code'=>201,
            'error'=>true,
            'message'=>apiMessage('Server Error, Not Found Data.', 'error')
        ];
            
    }

    $time = number_format($dataGoogle['card1_total']['totalsForAllResults']['ga:avgSessionDuration']);
    $time = intval(str_replace(",","",$time));
    $hours = floor($time / 3600);
    $mins = floor($time / 60 % 60);
    $secs = floor($time % 60);
    $timeFormat = sprintf('%02dm %02ds',$mins, $secs);

    
    $dataAudience = [
        'ga:users'=>[
            'title'=>'Users',
            'data'=>[],
            'total'=>thousandsCurrencyFormat($dataGoogle['card1_total']['totalsForAllResults']['ga:users']),
 			'present'=>-(100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:users'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:users'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:users'] : 1))

        ],
        'ga:sessions'=>[
            'title'=>'Sessions',
            'data'=>[],
            'total'=>thousandsCurrencyFormat($dataGoogle['card1_total']['totalsForAllResults']['ga:sessions']),
 			'present'=>-(100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:sessions'] * 100 / ( $dataGoogle['card2_total']['totalsForAllResults']['ga:sessions'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:sessions'] : 1))
        ],
        'ga:bounceRate'=>[
            'title'=>'Bounce Rate',
            'data'=>[],
            'total'=>number_format($dataGoogle['card1_total']['totalsForAllResults']['ga:bounceRate'],2).'%',
 			'present'=>-(100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:bounceRate'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:bounceRate'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:bounceRate'] : 1))
        ],
        'ga:avgSessionDuration'=>[
            'title'=>'Avg. Session Duration',
            'data'=>[],
            'total'=>$timeFormat,
 			'present'=>-(100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:avgSessionDuration'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:avgSessionDuration'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:avgSessionDuration'] :  1))
        ]
    ];

    foreach ($dataGoogle['card1']['rows'] as $k => $v) {
        
        // USER
        $present = number_format(abs( 100 - $v[1] * 100 / ($dataGoogle['card2']['rows'][$k][1] != 0 ? $dataGoogle['card2']['rows'][$k][1] : 1) ),1).'%<span>';

        if( $v[1] > $dataGoogle['card2']['rows'][$k][1] ){
            $icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
        }else{
            $icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
        }

        $dataAudience['ga:users']['data'][] = [
            [
                'f'=>'',
                'v'=>date("M d, Y", strtotime($v[0]))
            ],
            $v[1],
            date("D d M", strtotime($v[0])).' vs '.date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0])),
            $dataGoogle['card2']['rows'][$k][1],
            '<strong>'.number_format($v[1]).'</strong>&nbsp;&nbsp;'.$icon.$present
        ];



        // SESSION
			$present = number_format(abs( 100 - $v[2] * 100 / ($dataGoogle['card2']['rows'][$k][2] != 0 ? $dataGoogle['card2']['rows'][$k][2]: 1) ),1).'%<span>';
			 if( $v[2] > $dataGoogle['card2']['rows'][$k][2] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
             }
             
             $dataAudience['ga:sessions']['data'][] = [
                [
                    'f'=>'',
                    'v'=>date("M d, Y", strtotime($v[0]))
                ],
                $v[2],
                date("D d M", strtotime($v[0])).' vs '.date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0])),
                $dataGoogle['card2']['rows'][$k][2],
                '<strong>'.number_format($v[2]).'</strong>&nbsp;&nbsp;'.$icon.$present
            ];


            // BOUNCE-RATE
			$present = number_format(abs( 100 - $v[3] * 100 / ($dataGoogle['card2']['rows'][$k][3] != 0 ? $dataGoogle['card2']['rows'][$k][3] : 1) ),1).'%<span>';
			 if( $v[3] > $dataGoogle['card2']['rows'][$k][3] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
             }
             
             $dataAudience['ga:bounceRate']['data'][] = [
                [
                    'f'=>'',
                    'v'=>date("M d, Y", strtotime($v[0]))
                ],
                number_format($v[3],2),
                date("D d M", strtotime($v[0])).' vs '.date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0])),
                $dataGoogle['card2']['rows'][$k][3],
                '<strong>'.number_format($v[3],2).'</strong>&nbsp;&nbsp;'.$icon.$present
            ];


            //avgSessionDuration
			$present = number_format(abs( 100 - $v[4] * 100 / ($dataGoogle['card2']['rows'][$k][4] != 0 ? $dataGoogle['card2']['rows'][$k][4] : 1) ),1).'%<span>';
			 if( $v[4] > $dataGoogle['card2']['rows'][$k][4] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
			 }

			 $time = $v[4];
			$hours = floor($time / 3600);
			$mins = floor($time / 60 % 60);
			$secs = floor($time % 60);
			$timeFormat = sprintf('%02dm %02ds',$mins, $secs);

            $dataAudience['ga:avgSessionDuration']['data'][] = [
                [
                    'f'=>'',
                    'v'=>date("M d, Y", strtotime($v[0]))
                ],
                $v[4],
                date("D d M", strtotime($v[0])).' vs '.date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0])),
                $dataGoogle['card2']['rows'][$k][4],
                '<strong>'.$timeFormat.'</strong>&nbsp;&nbsp;'.$icon.$present
            ];
        
    }

    return [
        'general'=>$dataGoogle,
        'listColours'=>$listColours,
        'dataAudience'=>$dataAudience,
        'dataPageView30M'=>$dataPageView30M,
        'success'=>true,
    ];

}

if( $result = Cache::get('google-analytics-dashboard-'.$webpropertie_id) ){

}else{
    $dataGoogle = multiple_threads_request([
        'active_users_1day'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id, ['ga:1dayUsers'],
            ['ga:date'],
            $access_token, $start_date, $end_date,[]
            ),
        'active_users_7day'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id, ['ga:7dayUsers'],
            ['ga:date'],
            $access_token, $start_date, $end_date,[]
            ),
        'active_users_30day'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id, ['ga:30dayUsers'],
            ['ga:date'],
            $access_token, $start_date, $end_date,[]
            ),
        'sessions_by_device'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id,'ga:sessions',
            ['ga:deviceCategory'],
            $access_token,
            $start_date,
            $end_date,
            ['sort'=>'-ga:deviceCategory','max-results'=>10]
            ),
        'sessions_by_device2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id,'ga:sessions',
            ['ga:deviceCategory'],
            $access_token,
            $start_date2,
            $end_date2,
            ['sort'=>'-ga:deviceCategory','max-results'=>10]
            ),
        'users_by_time'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
            $webpropertie_id,'ga:users',
            ['ga:dayOfWeek,ga:hour'],
            $access_token,
            $start_date,
            $end_date,
            ['sort'=>'ga:dayOfWeek','max-results'=>1000]
            ),
        'path_pageview'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
                $webpropertie_id, ['ga:pageviews,ga:pageValue'],
                ['ga:landingPagePath'],
                $access_token, $start_date, $end_date,['sort'=>'-ga:pageviews','max-results'=>10]
                ),
        'traffic_channel'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
                $webpropertie_id, ['ga:sessions'],
                ['ga:date,ga:channelGrouping'],
                $access_token, $start_date, $end_date
                ),
        'traffic_sourcemedium'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
                $webpropertie_id, ['ga:sessions'],
                ['ga:date,ga:sourceMedium'],
                $access_token, $start_date, $end_date
                ),
        'traffic_referrer'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga',
                $webpropertie_id, ['ga:sessions'],
                ['ga:date,ga:fullReferrer'],
                $access_token, $start_date, $end_date
                ),
    ]);
    
    $result = ['data_active_user'=>[]];
    
    if( isset($dataGoogle['active_users_1day']['rows']) ){
        foreach($dataGoogle['active_users_1day']['rows'] as $k => $v){
            $result['data_active_user'][] = [
                ['v'=>date("M d, Y", strtotime($v[0])),'f'=>date("l, F d, Y", strtotime($v[0]))],
                $v[1]*1, ( isset($dataGoogle['active_users_7day']['rows'][$k][1]) ? $dataGoogle['active_users_7day']['rows'][$k][1]*1 : 0), ( isset($dataGoogle['active_users_30day']['rows'][$k][1]) ? $dataGoogle['active_users_30day']['rows'][$k][1]*1 : 0)
            ];
        }
    }

    $users_by_time_min = 9999999;
    $users_by_time_max = -1;

    if( isset($dataGoogle['users_by_time']['rows']) ){
        foreach ($dataGoogle['users_by_time']['rows'] as $k => $v) {
            $result['users_by_time']['data'][$v[1]*1][$v[0]*1] = $v[2];

            if( $v[2] > $users_by_time_max ) $users_by_time_max = $v[2];
            if( $v[2] < $users_by_time_min ) $users_by_time_min = $v[2];
        }
    }


    $result['users_by_time']['max'] = $users_by_time_max * 1;
    $result['users_by_time']['min'] = $users_by_time_min * 1;

    if( isset($dataGoogle['path_pageview']['rows']) ){
        foreach ($dataGoogle['path_pageview']['rows'] as $k => $v) {
            $path = $v[0];
            if( strlen($path) > 43 ){
                $path = mb_substr($path, 0,20).'...'.mb_substr($path, -20);
            }

            $result['path_pageview'][] = [$path, number_format($v[1]), number_format($v[2],2)];
        }
    }

     $traffic_channel = [];

    if( isset($dataGoogle['traffic_channel']['rows']) ){
        foreach ($dataGoogle['traffic_channel']['rows'] as $k => $v) {

            if( !isset($traffic_channel[$v[0]]['dayv']) ){
                $dayv = date("M d, Y", strtotime($v[0]));
                $dayf = date("D d M", strtotime($v[0]));
                $traffic_channel[$v[0]]['dayv'] = $dayv;
                $traffic_channel[$v[0]]['dayf'] = $dayf;
            }
            $traffic_channel[$v[0]]['channel'][$v[1]] = $v[2]*1;
        }
    }

    foreach ($traffic_channel as $k => $v) {
        if( !isset($v['channel']['Organic Search']) ) $traffic_channel[$k]['channel']['Organic Search'] = 0;
        if( !isset($v['channel']['Direct']) ) $traffic_channel[$k]['channel']['Direct'] = 'null';
        if( !isset($v['channel']['Paid Search']) ) $traffic_channel[$k]['channel']['Paid Search'] = 0;
        if( !isset($v['channel']['Referral']) ) $traffic_channel[$k]['channel']['Referral'] = 0;
        if( !isset($v['channel']['Social']) ) $traffic_channel[$k]['channel']['Social'] = 0;
        if( !isset($v['channel']['Display']) ) $traffic_channel[$k]['channel']['Display'] = 0;
        if( !isset($v['channel']['(Other)']) ) $traffic_channel[$k]['channel']['(Other)'] = 0;
         $traffic_channel[$k]['channel']['(Other)'] += $traffic_channel[$k]['channel']['Display'] + $traffic_channel[$k]['channel']['Social'];
    }
    $result['traffic_channel'] = $traffic_channel;


    $traffic_referrer = [];


    $arg = [];

    if( isset($dataGoogle['traffic_referrer']['rows']) ){
        foreach ($dataGoogle['traffic_referrer']['rows'] as $k => $v) {
            if( strpos($v[1], '.') !== false ){
                $domain = parse_url('http://'.$v[1]);

                if( isset($domain['host']) ){

                    if( !isset($arg[$domain['host']]) ) $arg[$domain['host']] = 0;
                    $arg[$domain['host']] += $v[2];

                }
            }
        }
    }

    arsort($arg);

    $arg = array_slice($arg, 0, 4);
    $arg['Other'] = 0;

    if( isset($dataGoogle['traffic_referrer']['rows']) ){
        foreach ($dataGoogle['traffic_referrer']['rows'] as $k => $v) {

            $domain = parse_url('http://'.$v[1]);

            if( strpos($v[1], '.') !== false && isset($domain['host']) ){

                if( isset($arg[$domain['host']]) ){

                    if( !isset($traffic_referrer[$v[0]][$domain['host']]) ) $traffic_referrer[$v[0]][$domain['host']] = 0;
                    $traffic_referrer[$v[0]][$domain['host']] += $v[2];

                }else{
                    if( !isset($traffic_referrer[$v[0]]['Other']) ) $traffic_referrer[$v[0]]['Other'] = 0;
                    $traffic_referrer[$v[0]]['Other'] += $v[2];
                }

            }
        }
    }

    $traffic_referrer = ['key'=>$arg,'data'=>$traffic_referrer];
    $result['traffic_referrer'] = $traffic_referrer;


    $traffic_sourcemedium = [];

    $arg = [];

    if( isset($dataGoogle['traffic_sourcemedium']['rows'][0]) ){
        foreach ($dataGoogle['traffic_sourcemedium']['rows'] as $k => $v) {
            if( !isset($arg[$v[1]]) ) $arg[$v[1]] = 0;
            $arg[$v[1]] += $v[2];
        }
    }
    arsort($arg);
    $arg = array_slice($arg, 0, 4);
    $arg['Other'] = 0;

    if( isset($dataGoogle['traffic_sourcemedium']['rows'][0]) ){

        foreach ($dataGoogle['traffic_sourcemedium']['rows'] as $k => $v) {

            if( isset($arg[$v[1]]) ){
                $traffic_sourcemedium[$v[0]][$v[1]] = $v[2]*1;
            }else{
                if( !isset($traffic_sourcemedium[$v[0]]['Other']) ) $traffic_sourcemedium[$v[0]]['Other'] = 0;

                $traffic_sourcemedium[$v[0]]['Other'] += $v[2];
            }
        }
    }

    $traffic_sourcemedium = ['key'=>$arg,'data'=>$traffic_sourcemedium];
    $result['traffic_sourcemedium'] = $traffic_sourcemedium;

    $deviceView = [];
    
    if( isset($dataGoogle['sessions_by_device']['rows'][0]) ){
        
        foreach ($dataGoogle['sessions_by_device']['rows'] as $k => $v){
            if( !isset($deviceView[ $v[0] ]) )  $deviceView[ $v[0] ] = [];
            $deviceView[ $v[0] ][0] = $v[1];
        }

        foreach ($dataGoogle['sessions_by_device2']['rows'] as $k => $v){
            if( !isset($deviceView[ $v[0] ]) )  $deviceView[ $v[0] ] = [];
            $deviceView[ $v[0] ][1] = $v[1];
        }

        foreach( $deviceView as $device => $value ){
            $result['sessions_by_device'][ $device ] = [
                $device,
                intval( $value[0] ?? 0 ), 
                round(intval( $value[0] ?? 0 ) * 100 / ($dataGoogle['sessions_by_device']['totalsForAllResults']['ga:sessions'] ?? 1),1), 
                round( intval( $value[0] ?? 0 ) * 100 / (  $value[1] ?? 1 ) - 100, 1 ),
            ];
        }
    }   


    // foreach ($dataGoogle['sessions_by_device']['rows'] as $k => $v) {
    //     $result['sessions_by_device'][$v[0]] = [
    //         $v[0],
    //         $v[1]*1, 
    //         round(intval($v[1]) * 100 / $dataGoogle['sessions_by_device']['totalsForAllResults']['ga:sessions'],1), 
    //         round(intval($v[1]) * 100 / $dataGoogle['sessions_by_device2']['rows'][$k][1] - 100,1) 
    //     ];
    // }

    $end = count( $dataGoogle['active_users_30day']['rows'] ) - 1;

    $result['data_active_total_user'] = [
        'number30day'=>thousandsCurrencyFormat( isset($dataGoogle['active_users_30day']['rows'][$end][1]) ? $dataGoogle['active_users_30day']['rows'][$end][1] : 0),
        'number7day'=>thousandsCurrencyFormat( isset($dataGoogle['active_users_7day']['rows'][$end][1]) ? $dataGoogle['active_users_7day']['rows'][$end][1] : 0),
        'number1day'=>thousandsCurrencyFormat( isset($dataGoogle['active_users_1day']['rows'][$end][1]) ? $dataGoogle['active_users_1day']['rows'][$end][1] : 0 ),
    ];
    $expiresAt = now()->addMinutes(60*24);
    $result['success'] = true;

    Cache::put('google-analytics-dashboard-'.$webpropertie_id, $result, $expiresAt);

}
return response()->json($result);



