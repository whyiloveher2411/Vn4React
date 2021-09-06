<?php

if( $result = Cache::get('google-analytics-dashboard') ){

}else{
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

    $start_date = $r->get('start_date');
    $end_date = $r->get('end_date');
    $start_date2 = $r->get('start_date2');
    $end_date2 = $r->get('end_date2');

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
    foreach($dataGoogle['active_users_1day']['rows'] as $k => $v){
        $result['data_active_user'][] = [
            ['v'=>date("M d, Y", strtotime($v[0])),'f'=>date("l, F d, Y", strtotime($v[0]))],
            $v[1]*1, $dataGoogle['active_users_7day']['rows'][$k][1]*1, $dataGoogle['active_users_30day']['rows'][$k][1]*1
        ];
    }

    $users_by_time_min = 9999999;
    $users_by_time_max = -1;

    foreach ($dataGoogle['users_by_time']['rows'] as $k => $v) {
        $result['users_by_time']['data'][$v[1]*1][$v[0]*1] = $v[2];

        if( $v[2] > $users_by_time_max ) $users_by_time_max = $v[2];
        if( $v[2] < $users_by_time_min ) $users_by_time_min = $v[2];
    }


    $result['users_by_time']['max'] = $users_by_time_max * 1;
    $result['users_by_time']['min'] = $users_by_time_min * 1;

    foreach ($dataGoogle['path_pageview']['rows'] as $k => $v) {
        $path = $v[0];
        if( strlen($path) > 43 ){
            $path = mb_substr($path, 0,20).'...'.mb_substr($path, -20);
        }

        $result['path_pageview'][] = [$path, number_format($v[1]), number_format($v[2],2)];
    }




     $traffic_channel = [];

    foreach ($dataGoogle['traffic_channel']['rows'] as $k => $v) {

        if( !isset($traffic_channel[$v[0]]['dayv']) ){
            $dayv = date("M d, Y", strtotime($v[0]));
            $dayf = date("D d M", strtotime($v[0]));
            $traffic_channel[$v[0]]['dayv'] = $dayv;
            $traffic_channel[$v[0]]['dayf'] = $dayf;
        }
        $traffic_channel[$v[0]]['channel'][$v[1]] = $v[2]*1;
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
    foreach ($dataGoogle['traffic_referrer']['rows'] as $k => $v) {
        if( strpos($v[1], '.') !== false ){
            $domain = parse_url('http://'.$v[1]);

            if( isset($domain['host']) ){

                if( !isset($arg[$domain['host']]) ) $arg[$domain['host']] = 0;
                $arg[$domain['host']] += $v[2];

            }
        }

    }

    arsort($arg);

    $arg = array_slice($arg, 0, 4);
    $arg['Other'] = 0;

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


    $traffic_referrer = ['key'=>$arg,'data'=>$traffic_referrer];
    $result['traffic_referrer'] = $traffic_referrer;


    $traffic_sourcemedium = [];

    $arg = [];

    foreach ($dataGoogle['traffic_sourcemedium']['rows'] as $k => $v) {
        if( !isset($arg[$v[1]]) ) $arg[$v[1]] = 0;
        $arg[$v[1]] += $v[2];
    }
    arsort($arg);
    $arg = array_slice($arg, 0, 4);
    $arg['Other'] = 0;

    foreach ($dataGoogle['traffic_sourcemedium']['rows'] as $k => $v) {

        if( isset($arg[$v[1]]) ){
            $traffic_sourcemedium[$v[0]][$v[1]] = $v[2]*1;
        }else{
            if( !isset($traffic_sourcemedium[$v[0]]['Other']) ) $traffic_sourcemedium[$v[0]]['Other'] = 0;

            $traffic_sourcemedium[$v[0]]['Other'] += $v[2];
        }
    }

    $traffic_sourcemedium = ['key'=>$arg,'data'=>$traffic_sourcemedium];
    $result['traffic_sourcemedium'] = $traffic_sourcemedium;



    foreach ($dataGoogle['sessions_by_device']['rows'] as $k => $v) {
        $result['sessions_by_device'][$v[0]] = [$v[0],$v[1]*1, number_format($v[1] * 100 / $dataGoogle['sessions_by_device']['totalsForAllResults']['ga:sessions'],1), number_format($v[1] * 100 / $dataGoogle['sessions_by_device2']['rows'][$k][1] - 100,1)*1 ];
    }

    $end = count( $dataGoogle['active_users_30day']['rows'] ) - 1;

    $result['data_active_total_user'] = [
        'number30day'=>thousandsCurrencyFormat($dataGoogle['active_users_30day']['rows'][$end][1]),
        'number7day'=>thousandsCurrencyFormat($dataGoogle['active_users_7day']['rows'][$end][1]),
        'number1day'=>thousandsCurrencyFormat($dataGoogle['active_users_1day']['rows'][$end][1]),
    ];
    $expiresAt = now()->addMinutes(60*24);
    Cache::put('google-analytics-dashboard', $result, $expiresAt);
}
return response()->json($result);