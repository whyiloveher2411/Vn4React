<?php

$filter = $r->get('filter',$plugin->getMeta('country'));

$website = $plugin->getMeta('website');

if( isset($website[2]) ){
  $website = $website[2];
}else{
  $website = env('APP_URL');
}


if( $filter == 'null' ) $filter = false;

if( $filter ){

   function code_to_country( $name, $plugin ){

      $name = str_slug($name);

      $countryList = array(
          'afghanistan'=>'AF',
          'aland-islands'=>'AX',
          'albania'=>'AL',
          'algeria'=>'DZ',
          'american-samoa'=>'AS',
          'andorra'=>'AD',
          'angola'=>'AO',
          'anguilla'=>'AI',
          'antarctica'=>'AQ',
          'antigua-and-barbuda'=>'AG',
          'argentina'=>'AR',
          'armenia'=>'AM',
          'aruba'=>'AW',
          'australia'=>'AU',
          'austria'=>'AT',
          'azerbaijan'=>'AZ',
          'bahamas-the'=>'BS',
          'bahrain'=>'BH',
          'bangladesh'=>'BD',
          'barbados'=>'BB',
          'belarus'=>'BY',
          'belgium'=>'BE',
          'belize'=>'BZ',
          'benin'=>'BJ',
          'bermuda'=>'BM',
          'bhutan'=>'BT',
          'bolivia'=>'BO',
          'bosnia-and-herzegovina'=>'BA',
          'botswana'=>'BW',
          'bouvet-island-bouvetoya'=>'BV',
          'brazil'=>'BR',
          'british-indian-ocean-territory-chagos-archipelago'=>'IO',
          'british-virgin-islands'=>'VG',
          'brunei-darussalam'=>'BN',
          'bulgaria'=>'BG',
          'burkina-faso'=>'BF',
          'burundi'=>'BI',
          'cambodia'=>'KH',
          'cameroon'=>'CM',
          'canada'=>'CA',
          'cape-verde'=>'CV',
          'cayman-islands'=>'KY',
          'central-african-republic'=>'CF',
          'chad'=>'TD',
          'chile'=>'CL',
          'china'=>'CN',
          'christmas-island'=>'CX',
          'cocos-keeling-islands'=>'CC',
          'colombia'=>'CO',
          'comoros-the'=>'KM',
          'congo'=>'CD',
          'congo-the'=>'CG',
          'cook-islands'=>'CK',
          'costa-rica'=>'CR',
          'cote-divoire'=>'CI',
          'croatia'=>'HR',
          'cuba'=>'CU',
          'cyprus'=>'CY',
          'czech-republic'=>'CZ',
          'denmark'=>'DK',
          'djibouti'=>'DJ',
          'dominica'=>'DM',
          'dominican-republic'=>'DO',
          'ecuador'=>'EC',
          'egypt'=>'EG',
          'el-salvador'=>'SV',
          'equatorial-guinea'=>'GQ',
          'eritrea'=>'ER',
          'estonia'=>'EE',
          'ethiopia'=>'ET',
          'faroe-islands'=>'FO',
          'falkland-islands-malvinas'=>'FK',
          'fiji-the-fiji-islands'=>'FJ',
          'finland'=>'FI',
          'france-french-republic'=>'FR',
          'french-guiana'=>'GF',
          'french-polynesia'=>'PF',
          'french-southern-territories'=>'TF',
          'gabon'=>'GA',
          'gambia-the'=>'GM',
          'georgia'=>'GE',
          'germany'=>'DE',
          'ghana'=>'GH',
          'gibraltar'=>'GI',
          'greece'=>'GR',
          'greenland'=>'GL',
          'grenada'=>'GD',
          'guadeloupe'=>'GP',
          'guam'=>'GU',
          'guatemala'=>'GT',
          'guernsey'=>'GG',
          'guinea'=>'GN',
          'guinea-bissau'=>'GW',
          'guyana'=>'GY',
          'haiti'=>'HT',
          'heard-island-and-mcdonald-islands'=>'HM',
          'holy-see-vatican-city-state'=>'VA',
          'honduras'=>'HN',
          'hong-kong'=>'HK',
          'hungary'=>'HU',
          'iceland'=>'IS',
          'india'=>'IN',
          'indonesia'=>'ID',
          'iran'=>'IR',
          'iraq'=>'IQ',
          'ireland'=>'IE',
          'isle-of-man'=>'IM',
          'israel'=>'IL',
          'italy'=>'IT',
          'jamaica'=>'JM',
          'japan'=>'JP',
          'jersey'=>'JE',
          'jordan'=>'JO',
          'kazakhstan'=>'KZ',
          'kenya'=>'KE',
          'kiribati'=>'KI',
          'korea'=>'KP',
          'south-korea'=>'KR',
          'kuwait'=>'KW',
          'kyrgyz-republic'=>'KG',
          'lao'=>'LA',
          'latvia'=>'LV',
          'lebanon'=>'LB',
          'lesotho'=>'LS',
          'liberia'=>'LR',
          'libyan-arab-jamahiriya'=>'LY',
          'liechtenstein'=>'LI',
          'lithuania'=>'LT',
          'luxembourg'=>'LU',
          'macao'=>'MO',
          'macedonia'=>'MK',
          'madagascar'=>'MG',
          'malawi'=>'MW',
          'malaysia'=>'MY',
          'maldives'=>'MV',
          'mali'=>'ML',
          'malta'=>'MT',
          'marshall-islands'=>'MH',
          'martinique'=>'MQ',
          'mauritania'=>'MR',
          'mauritius'=>'MU',
          'mayotte'=>'YT',
          'mexico'=>'MX',
          'micronesia'=>'FM',
          'moldova'=>'MD',
          'monaco'=>'MC',
          'mongolia'=>'MN',
          'montenegro'=>'ME',
          'montserrat'=>'MS',
          'morocco'=>'MA',
          'mozambique'=>'MZ',
          'myanmar'=>'MM',
          'namibia'=>'NA',
          'nauru'=>'NR',
          'nepal'=>'NP',
          'netherlands-antilles'=>'AN',
          'netherlands-the'=>'NL',
          'new-caledonia'=>'NC',
          'new-zealand'=>'NZ',
          'nicaragua'=>'NI',
          'niger'=>'NE',
          'nigeria'=>'NG',
          'niue'=>'NU',
          'norfolk-island'=>'NF',
          'northern-mariana-islands'=>'MP',
          'norway'=>'NO',
          'oman'=>'OM',
          'pakistan'=>'PK',
          'palau'=>'PW',
          'palestinian-territory'=>'PS',
          'panama'=>'PA',
          'papua-new-guinea'=>'PG',
          'paraguay'=>'PY',
          'peru'=>'PE',
          'philippines'=>'PH',
          'pitcairn-islands'=>'PN',
          'poland'=>'PL',
          'portugal-portuguese-republic'=>'PT',
          'puerto-rico'=>'PR',
          'qatar'=>'QA',
          'reunion'=>'RE',
          'romania'=>'RO',
          'russian-federation'=>'RU',
          'rwanda'=>'RW',
          'saint-barthelemy'=>'BL',
          'saint-helena'=>'SH',
          'saint-kitts-and-nevis'=>'KN',
          'saint-lucia'=>'LC',
          'saint-martin'=>'MF',
          'saint-pierre-and-miquelon'=>'PM',
          'saint-vincent-and-the-grenadines'=>'VC',
          'samoa'=>'WS',
          'san-marino'=>'SM',
          'sao-tome-and-principe'=>'ST',
          'saudi-arabia'=>'SA',
          'senegal'=>'SN',
          'serbia'=>'RS',
          'seychelles'=>'SC',
          'sierra-leone'=>'SL',
          'singapore'=>'SG',
          'slovakia-slovak-republic'=>'SK',
          'slovenia'=>'SI',
          'solomon-islands'=>'SB',
          'somalia-somali-republic'=>'SO',
          'south-africa'=>'ZA',
          'south-georgia-and-the-south-sandwich-islands'=>'GS',
          'spain'=>'ES',
          'sri-lanka'=>'LK',
          'sudan'=>'SD',
          'suriname'=>'SR',
          'svalbard-jan-mayen-islands'=>'SJ',
          'swaziland'=>'SZ',
          'sweden'=>'SE',
          'switzerland-swiss-confederation'=>'CH',
          'syrian-arab-republic'=>'SY',
          'taiwan'=>'TW',
          'tajikistan'=>'TJ',
          'tanzania'=>'TZ',
          'thailand'=>'TH',
          'timor-leste'=>'TL',
          'togo'=>'TG',
          'tokelau'=>'TK',
          'tonga'=>'TO',
          'trinidad-and-tobago'=>'TT',
          'tunisia'=>'TN',
          'turkey'=>'TR',
          'turkmenistan'=>'TM',
          'turks-and-caicos-islands'=>'TC',
          'tuvalu'=>'TV',
          'uganda'=>'UG',
          'ukraine'=>'UA',
          'united-arab-emirates'=>'AE',
          'united-kingdom'=>'GB',
          'united-states'=>'US',
          'united-states-of-america'=>'US',
          'united-states-minor-outlying-islands'=>'UM',
          'united-states-virgin-islands'=>'VI',
          'uruguay-eastern-republic-of'=>'UY',
          'uzbekistan'=>'UZ',
          'vanuatu'=>'VU',
          'venezuela'=>'VE',
          'vietnam'=>'VN',
          'wallis-and-futuna'=>'WF',
          'western-sahara'=>'EH',
          'yemen'=>'YE',
          'zambia'=>'ZM',
          'zimbabwe'=>'ZW',
      );

      if( !$countryList[$name] ) return $name;

      else return $countryList[$name];
  }

  $url_country = 'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:country,rt:city,rt:latitude,rt:longitude&metrics=rt:activeUsers&sort=-rt:activeUsers&filters=rt:country%3D~%5E'.urlencode($filter).'&access_token='.$access_token;

}else{

  $url_country = 'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:country&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token;

}

$start_date_now1 = date('Y-m-d');
$hour1 = date('H');
$hour2 =  date('H', strtotime(' -1 hour'));

if( $hour1 > 0 ){
  $start_date_now2 = $start_date_now1;
}else{
  $start_date_now2 = date('Y-m-d', strtotime(' -1 day'));
}

$dataGoogle = multiple_threads_request([
      'country'=>$url_country,
      'realtime'=>'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath,rt:source,rt:keyword,rt:trafficType,rt:browser,rt:deviceCategory,rt:medium&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token,
      'pageview30_1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now1, $start_date_now1,['filters'=>'ga:hour=='.$hour1] ),
      'pageview30_2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now2, $start_date_now2,['filters'=>'ga:hour=='.$hour2] ),
]);


if( isset($dataGoogle['country']['error']['message']) ){
  return response()->json(['error'=>true,'message'=>$dataGoogle['country']['error']['message']]);
}

if( $filter ){
  $arg = ['count1'=>['title'=>'City','value'=>[]]];

  if( isset( $dataGoogle['country']['rows'] ) ){
    $dataCountry = $dataGoogle['country']['rows'];
  }else{
    $dataCountry = [];
  }
}else{
  $dataCountry = ['count1'=>['title'=>'Country','value'=>[]]];
  if( isset( $dataGoogle['country']['rows'] ) ){
  foreach ($dataGoogle['country']['rows'] as $key => $value) {
      if( !isset($dataCountry['count1']['value'][$value[0]]) ){
        $dataCountry['count1']['value'][$value[0]] = 0;
      }
      $dataCountry['count1']['value'][$value[0]] += $value[1];
    }
  }
}

// dd($dataGoogle);
$dataPageView30M = [];
$index = 0;

$minuteNow = date('i')*1;

$minuteLast = 0;
$doSaiLech = 0;

if( isset($dataGoogle['pageview30_1']['rows']) ){

  $pageviewOnminute = [];

  foreach ($dataGoogle['pageview30_1']['rows'] as $v) {
    $pageviewOnminute[$v[0]*1] = $v[1];
  }

  $minuteLast = array_key_last($pageviewOnminute);

  $doSaiLech = $minuteNow - $minuteLast;

  for ($i=$minuteLast; $i >= 0 ; $i--) { 
      if( isset($pageviewOnminute[$i]) ){
        $dataPageView30M[  ( $minuteLast - $i + $doSaiLech ).' mins ago' ] = $pageviewOnminute[$i];
      }else{
        $dataPageView30M[  ( $minuteLast - $i + $doSaiLech ).' mins ago' ] = 0;
      }
      $index ++;
  }

}

if( isset($dataGoogle['pageview30_2']['rows']) ){

  if( $index < 61 ){

    $pageviewOnminute = [];

    foreach ($dataGoogle['pageview30_2']['rows'] as $v) {
      $pageviewOnminute[$v[0]*1] = $v[1];
    }


    if( $minuteLast === 0 ){
      $count = array_key_last($pageviewOnminute);
      $doSaiLech = ( $minuteNow + 59 ) - $count;
    }else{
      $count = 59;
    }

    for ($i=$count; $i >= 0 ; $i--) { 
      if( $index > 60 ){
        break;
      }

      if( isset($pageviewOnminute[$i]) ){
        $dataPageView30M[  ( ($count + $minuteLast) - $i + $doSaiLech ).' mins ago' ] = $pageviewOnminute[$i];
      }else{
        $dataPageView30M[  ( ($count + $minuteLast) - $i + $doSaiLech ).' mins ago' ] = 0;
      }

      $index ++;
    }
  }
}

$data = $dataGoogle['realtime'];

$total = $data['totalsForAllResults']['rt:activeUsers'];
$arg = [
	'count1'=>['title'=>'Top Active Pages','value'=>[]],
	'count2'=>['title'=>'Traffic Source','value'=>[]], 
	'count3'=>['title'=>'Keywords','value'=>[]], 
	'count4'=>['title'=>'Traffic Type','value'=>[]], 
	'count5'=>['title'=>'Browser', 'value'=>[]], 
	'count6'=>['title'=>'Device','value'=>[]], 
  'count8'=>['title'=>'Medium','value'=>[]],
];

if( isset($data['rows']) ){
  foreach ($data['rows'] as $key => $value) {

  	if( !isset($arg['count1']['value'][$value[0]]) ){
  		$arg['count1']['value'][$value[0]] = 0;
  	}

  	$arg['count1']['value'][$value[0]] += $value[7];


  	if( !isset($arg['count2']['value'][$value[1]]) ){
  		$arg['count2']['value'][$value[1]] = 0;
  	}

  	$arg['count2']['value'][$value[1]] += $value[7];


  	if( !isset($arg['count3']['value'][$value[2]]) ){
  		$arg['count3']['value'][$value[2]] = 0;
  	}

  	$arg['count3']['value'][$value[2]] += $value[7];


  	if( !isset($arg['count4']['value'][$value[3]]) ){
  		$arg['count4']['value'][$value[3]] = 0;
  	}

  	$arg['count4']['value'][$value[3]] += $value[7];


    $browser = capital_letters($value[4]);

  	if( !isset($arg['count5']['value'][$browser]) ){
  		$arg['count5']['value'][$browser] = 0;
  	}

  	$arg['count5']['value'][$browser] += $value[7];

  	if( !isset($arg['count6']['value'][$value[5]]) ){
  		$arg['count6']['value'][$value[5]] = 0;
  	}

  	$arg['count6']['value'][$value[5]] += $value[7];

    if( !isset( $arg['count8']['value'][ $value[6].','.$value[1] ] ) ){
      $arg['count8']['value'][ $value[6].','.$value[1] ] = 0;
    }

    $arg['count8']['value'][ $value[6].','.$value[1] ] += $value[7];
  }
}


$result = ['chart_30'=>[],'rt_pagePath'=>[],'rt_source'=>[],'rt_keyword'=>[],'rt_browser'=>[],'rt_location'=>[],'rt_country'=>[],'rt_trafficType'=>['label'=>'','value'=>''],'rt_user'=>['label'=>'','value'=>'']];

$dataPageView30M = array_reverse($dataPageView30M);

foreach($dataPageView30M as $k => $v){
	$result['chart_30'][] = [$k,$v*1,$k."\n".$v."\nPage Views",'stroke-color: #fff;stroke-width: 1; fill-color: rgb(5,141,199); fill-opacity: 0.4'];
}

$value = $arg['count1']['value'];
arsort($value);

$index = 0;
foreach($value as $k => $v){
  	$index++;
  	if( $index > 10 ) break;
	$result['rt_pagePath'][] = ['<a target="_blank" href="'.$website.$k.'">'.$k.'</a>',  $v,  ['v'=> number_format($v * 100 / $total)*1, 'f'=> number_format($v * 100 / $total,2).'%']];
}    

$value = $arg['count8']['value'];
arsort($value);

foreach($value as $k => $v){
	$k = explode(',', $k);
  	$result['rt_source'][] = [ $k[0],$k[1],  $v,  ['v'=> number_format($v * 100 / $total)*1, 'f'=> number_format($v * 100 / $total,2).'%']];
}


$value = $arg['count3']['value'];
arsort($value);
foreach($value as $k => $v){
	$result['rt_keyword'][] = [$k,  $v*1, ['v'=> number_format($v * 100 / $total)*1, 'f'=> number_format($v * 100 / $total,2).'%']];
}


$value = $arg['count5']['value'];
arsort($value);
foreach($value as $k => $v){
	$result['rt_browser'][] = [$k,  $v*1, ['v'=> number_format($v * 100 / $total)*1, 'f'=> number_format($v * 100 / $total,2).'%']];
}

if( $filter ){

	$result['region'] = code_to_country($filter,$plugin);

	foreach($dataCountry as $k => $v){
      	$v[1] = $v[1] == 'zz' ? '(not set)': $v[1];
      	$result['rt_location'][] = [$v[1],  $v[4]*1,  ['v'=> number_format($v[4] * 100 / $total)*1, 'f'=> number_format($v[4] * 100 / $total,2).'%']];
    }

    foreach($dataCountry as $k => $v){
        $result['rt_country'][] = [$v[2]*1,$v[3]*1,$v[1],$v[4]*1, '<span style="font-weight: normal;">Active User: '.$v[4].'</span>'];
    }


}else{

  	$value = $dataCountry['count1']['value'];
  	arsort($value);
    foreach($value as $k => $v){
      $result['rt_location'][] = ['<a href="?filter='.$k.'">'.$k.'</a>',  $v*1,  ['v'=> number_format($v * 100 / $total)*1, 'f'=> number_format($v * 100 / $total,2).'%']];
    }

  	$value = $dataCountry['count1']['value'];
  	arsort($value);
    foreach($value as $k => $v){
        $result['rt_country'][] = [$k,  $v];
    }
    

}



$value = $arg['count6']['value'];
arsort($value);
$argColor = [
	'DESKTOP'=>'#ed561b',
	'MOBILE'=>'#50b432',
	'TABLET'=>'#058dc7',
];

 foreach($value as $k => $v ){
 	$result['rt_user']['label'] .= '<div style="color: #005c9c;display: inline-block;text-transform: uppercase;font-size: 11px;font-weight: bold;"><em style="display: inline-block;height: .8em;width: .8em;background-color: '.$argColor[$k].';"></em> '.$k.' '. ( round ($v * 100 / $total) <= 4 ? '['.round ($v * 100 / $total).'%]': '') .' </div>&nbsp;&nbsp';

 	$result['rt_user']['value'] .= '<div class="device_item" style="background-color: '.$argColor[$k].';width:'.($v*100/$total).'%;">'.(round ($v * 100 / $total) > 4 ? round ($v * 100 / $total).'%' : '' ).'</div>';
}






$rt_trafficType_color = [
'DIRECT'=>'#ed561b',
'ORGANIC'=>'#058dc7',
'SOCIAL'=>'#c85332',
'CAMPAIGN'=>'#24cbe5',
'REFERRAL'=>'#50b432',
'OTHER'=>'#666',
'CUSTOM'=>'#666',
'PAID'=>'#edef00',
];
$rt_trafficType = [];
foreach ($arg['count4']['value'] as $key => $value) {

$tf_type = $key;

if( $key !== '(not set)' && $key === 'CUSTOM' ){
  $tf_type = 'CAMPAIGN';
}

if( !isset($rt_trafficType[$tf_type]) ) $rt_trafficType[$tf_type] = 0;

$rt_trafficType[$tf_type] += $value;

}
arsort($rt_trafficType);

foreach($rt_trafficType as $k => $v ){
	$result['rt_trafficType']['label'] .= '<div style="color: #005c9c;display: inline-block;text-transform: uppercase;font-size: 11px;font-weight: bold;"><em style="display: inline-block;height: .8em;width: .8em;background-color: '.$rt_trafficType_color[$k].';"></em> '.$k.' '.(round ($v * 100 / $total) <= 4 ? '['.round ($v * 100 / $total).'%]':'').'</div>&nbsp;&nbsp';
	
	$result['rt_trafficType']['value'] .= '<div class="device_item" style="background-color: '.$rt_trafficType_color[$k].';width:'.$v * 100 / $total.'%;">'.(round ($v * 100 / $total) > 4 ? round ($v * 100 / $total).'%' : '').'</div>';
}



$result['total'] = $total;

return response()->json($result);


?>
