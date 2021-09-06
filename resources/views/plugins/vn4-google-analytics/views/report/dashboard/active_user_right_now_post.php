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
    ]);


    $users_by_time_min = 9999999;
    $users_by_time_max = -1;

    foreach ($dataGoogle['users_by_time']['rows'] as $k => $v) {
        $result['users_by_time']['data'][$v[1]*1][$v[0]*1] = $v[2];

        if( $v[2] > $users_by_time_max ) $users_by_time_max = $v[2];
        if( $v[2] < $users_by_time_min ) $users_by_time_min = $v[2];
    }


    $result['users_by_time']['max'] = $users_by_time_max * 1;
    $result['users_by_time']['min'] = $users_by_time_min * 1;


    foreach ($dataGoogle['sessions_by_device']['rows'] as $k => $v) {
        $result['sessions_by_device'][$v[0]] = [$v[0],$v[1]*1, number_format($v[1] * 100 / $dataGoogle['sessions_by_device']['totalsForAllResults']['ga:sessions'],1), number_format($v[1] * 100 / $dataGoogle['sessions_by_device2']['rows'][$k][1] - 100,1)*1 ];
    }


    $expiresAt = now()->addMinutes(60*24);
    Cache::put('google-analytics-dashboard-home', $result, $expiresAt);
}
return response()->json($result);