<?php

$filter = $r->get('filter',$plugin->getMeta('country'));

$website = $plugin->getMeta('website');

if( isset($website[2]) ){
  $website = $website[2];
}else{
  $website = env('APP_URL');
}

$listAnalyticsWebsite = $plugin->getMeta('listAnalyticsWebsite');

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
      'realtime'=>'https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath,rt:source,rt:keyword,rt:trafficType,rt:browser,rt:deviceCategory,rt:country&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token,
      'pageview30_1'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now1, $start_date_now1,['filters'=>'ga:hour=='.$hour1] ),
      'pageview30_2'=>get_url_google_analytics('https://www.googleapis.com/analytics/v3/data/ga', $webpropertie_id, ['ga:pageviews'],['ga:minute'],$access_token, $start_date_now2, $start_date_now2,['filters'=>'ga:hour=='.$hour2] ),
]);

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
	'count7'=>['title'=>'Country','value'=>[]]];

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


  	if( !isset($arg['count7']['value'][$value[6]]) ){
  		$arg['count7']['value'][$value[6]] = 0;
  	}

  	$arg['count7']['value'][$value[6]] += $value[7];
  }
}
?>

  	<script type="text/javascript">

      var isInIframe = (window.location != window.parent.location) ? true : false;

      if(!isInIframe){
        window.location.href = '{!!route('admin.index')!!}';
      }
    
      google.charts.load('current', {'packages':['table','corechart']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {

        //Active Users right now
          var data = new google.visualization.DataTable();
          data.addColumn('string','mins ago');
          data.addColumn('number','Page Views');
          data.addColumn({type: 'string', role: 'tooltip'});
          data.addColumn({type: 'string', role: 'style'});
          data.addRows([
            <?php 
                $dataPageView30M = array_reverse($dataPageView30M);
               ?>
              @foreach($dataPageView30M as $k => $v)
              ['{!!$k!!}',{!!$v!!},'{!!$k!!}\n{!!$v!!}\nPage Views','stroke-color: #fff;stroke-width: 1; fill-color: rgb(5,141,199); fill-opacity: 0.4'],
              @endforeach
          ]);
          var options = {
            title: "",
            width: '100%',
            height: '230',
            tooltip:{isHtml:true,showColorCode:false},
            bar: {groupWidth: '100%'},
            // hAxis: {title: '',textPosition: 'none',baselineColor: 'none',gridlines: {count:0, color: 'transparent'}},
            vAxis: { textStyle:{fontSize: '11',color:'#979797'},  minValue: 0,baselineColor: 'none',gridlines: {count:5,color: '#e7e7e7'}},
            backgroundColor:'white',
            chartArea:{left:30,right:0,height:220},
            legend: { position: 'none' },
          };

          var chart = new google.visualization.ColumnChart(document.getElementById('chart_30'));
          chart.draw(data, options);


        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Active Page');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count1']['value'];
				arsort($value);
        	 ?>
           <?php 
              $index = 0;
            ?>
        	@foreach($value as $k => $v)
            <?php 
              $index++;
              if( $index > 10 ) break;
             ?>
          	['<a target="_blank" href="{!!$website.$k!!}">{!!$k!!}</a>',  {!!$v!!},  {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_pagePath'));
        table.draw(data, {showRowNumber: true, allowHtml:true, width: '100%'});



        // Traffic Source
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Source');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count2']['value'];
				arsort($value);
        	 ?>
        	@foreach($value as $k => $v)
          	['{!!$k!!}',  {!!$v!!}, {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_source'));
        table.draw(data, {showRowNumber: true, width: '100%'});



        // Keywords
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Keyword');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count3']['value'];
				    arsort($value);
        	 ?>
        	@foreach($value as $k => $v)
          	['{!!$k!!}',  {!!$v!!}, {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_keyword'));
        table.draw(data, {showRowNumber: true, width: '100%'});



        // Traffic Type
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Traffic Type');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count4']['value'];
				arsort($value);
        	 ?>
        	@foreach($value as $k => $v)
          	['{!!$k!!}',  {!!$v!!}, {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_trafficType'));
        table.draw(data, {showRowNumber: true, width: '100%'});


        // Browser
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Browser');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count5']['value'];
				arsort($value);
        	 ?>
        	@foreach($value as $k => $v)
          	['{!!$k!!}',  {!!$v!!}, {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_browser'));
        table.draw(data, {showRowNumber: true, width: '100%'});



       @if( $filter )

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'City');
            data.addColumn('number', '');
            data.addColumn('number', 'Active Users',{'width':'50px'});
            data.addRows([
              @foreach($dataCountry as $k => $v)

                <?php 
                    $v[1] = $v[1] == 'zz' ? '(not set)': $v[1];
                 ?>
                ['{!!$v[1]!!}',  {!!$v[4]!!},  {v: {!!number_format($v[4] * 100 / $total)!!}, f: '{!! number_format($v[4] * 100 / $total,2)!!}%'}],
              @endforeach
            ]);
            var table = new google.visualization.Table(document.getElementById('rt_location'));
            table.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});
          


             var data = new google.visualization.DataTable();
            data.addColumn('number', 'Lat');                                
             data.addColumn('number', 'Long');
             data.addColumn('string', 'City'); 
             data.addColumn('number', 'Active Users'); 
             data.addColumn({type:'string', role:'tooltip',p:{html:true}});                        

            data.addRows([

              @foreach($dataCountry as $k => $v)
                [{!!$v[2],',',$v[3]!!},'{!!$v[1]!!}',{!!$v[4]!!}, '<span style="font-weight: normal;">Active User: {!!$v[4]!!}</span>'],
              @endforeach

            ]);


            var opts = {
              region: '{!!code_to_country($filter,$plugin)!!}',
              displayMode: 'markers',
              backgroundColor: 'rgb(234, 247, 254)',
              defaultColor: 'rgb(227, 123, 51)',
              legend:'none',
              // legend:{textStyle: {color: 'blue', bold:true, fontSize: 16}},
              tooltip: {isHtml: true},
              sizeAxis: {minValue: 0,  maxSize: 22},
              colorAxis: {colors: ['rgb(227, 123, 51)','rgb(227, 123, 51)']}
            };

            var geochart = new google.visualization.GeoChart(document.getElementById('rt_country'));

            google.visualization.events.addListener(geochart, 'ready', function(){

               var body = document.body,
                html = document.documentElement;

                var height = $('.div-warper').height();

                document.body.style.height = height + 'px';

                $('#iframe-google-analytics',window.parent.document).css({'height': height+'px'});
            });

            geochart.draw(data, opts);

        @else

         
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Country');
            data.addColumn('number', '');
            data.addColumn('number', 'Active Users',{'width':'50px'});
            data.addRows([
              <?php 
                $value = $dataCountry['count1']['value'];

            arsort($value);
               ?>
              @foreach($value as $k => $v)
                ['<a href="?filter={!!$k!!}">{!!$k!!}</a>',  {!!$v!!},  {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
              @endforeach
            ]);
            var table = new google.visualization.Table(document.getElementById('rt_location'));
            table.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});

         
            var data = google.visualization.arrayToDataTable([
              ['Country', 'Active Users'],
              <?php 
                $value = $dataCountry['count1']['value'];
                arsort($value);
               ?>
               @foreach($value as $k => $v)
                ['{!!$k!!}',  {!!$v!!}],
              @endforeach
            ]);
            var options = {
              legend:'none',
              backgroundColor: 'rgb(234, 247, 254)',
            };


            function myClickHandler(){
                var selection = chart.getSelection();

                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null && item.column != null) {
                      var str = data.getFormattedValue(item.row, item.column);
                    } else if (item.row != null) {
                      var str = data.getFormattedValue(item.row, 0);
                    } else if (item.column != null) {
                       var str = data.getFormattedValue(0, item.column);
                    }
                }

                window.location.href = '?filter='+str;
                
            }

            var chart = new google.visualization.GeoChart(document.getElementById('rt_country'));
            google.visualization.events.addListener(chart, 'select', myClickHandler);

            google.visualization.events.addListener(chart, 'ready', function(){
                var body = document.body,
                html = document.documentElement;

                var height = $('.div-warper').height();

                document.body.style.height = height + 'px';

                $('#iframe-google-analytics',window.parent.document).css({'height': height+'px'});
            });

            chart.draw(data, options);

        @endif
      }

     $(window).load(function(){
       $('#change_website').change(function(){

            window.parent.show_loading('@__('Change View')');
            $.ajax({
              url: '{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'analytics','method'=>'change-website'])!!}',
              type:'POST',
              dataType:'Json',
              data:{
                _token: '{!!csrf_token()!!}',
                value: $(this).val(),
              },
              success:function(){
                window.location.reload();
              }
            });
        });

       $('.counting').each(function() {
          var $this = $(this),
              countTo = $this.attr('data-count');
          
          $({ countNum: $this.text()}).animate({
            countNum: countTo
          },

          {

            duration: 4000,
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
              //alert('finished');
            }

          });  
          

        });

     });
    </script>
    
      <style type="text/css">
        body{
          padding-top: 30px;
        }
        .card{
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #dddfe2;
        }
        .card h3{
            color: #25405D;
            font-size: 14px;
            margin-bottom: 13px;
            border-bottom: 2px solid #666;
        }
        .card table{
          border-collapse: collapse;
        }
        .card th{
          background: white;
          border-bottom: 1px solid #ddd;
        }
        .card th:focus, .card th:active{
          border: none;
        }
        .card td{
          border: 1px solid #ddd;
          font-size: 13px;
        }
        .card a{
          color: #005c9c;
        }
        .google-visualization-table-table td{
           padding: 0.6em;
           font-size: 12px;
        }
        .icon-refesh{
          top: 5px;
        }
        #change_website{
          position: absolute;
          right: 30px;
          top: 1px;
          display: block;
          padding: 0px 12px;
          font-size: 14px;
          color: #555;
          background-color: #fff;
          background-image: none;
          height: 28px;
        }
        .column-left .card{
          margin-right: 7px;
        }
        .column-right .card{
          margin-left: 7px;
        }
      </style>
    <select id="change_website">
      @foreach($listAnalyticsWebsite as $w)
      <option value="{!!$w[0]!!}" @if($w[0] === $webpropertie_id) selected="selected" @endif > {!!$w[1]!!} </option>
      @endforeach
    </select>
  	<div class="column-left" style="width: 32.999%;text-align: center;display: inline-block;float: left;box-sizing: border-box;padding:0 5px 0 0; ">

      <div class="card">
    		<div style="font-size: 200%;padding-top:20px;">Right now</div>
    		<div class="counting" data-count="{!!$total!!}" style="font-size: 75px;" id="total_">0</div>
    		<div style="font-size: 82%;">active users on site</div>
        
    		<div style="padding-top: 25px">
  	  		<div class="" style="text-align: left;margin-bottom:3px;" >
  	  			<?php 
  	  				$value = $arg['count6']['value'];
  					arsort($value);
  					$argColor = [
  						'DESKTOP'=>'#ed561b',
  						'MOBILE'=>'#50b432',
  						'TABLET'=>'#058dc7',
  					]
  	  			 ?>

  	    

  	  			@foreach($value as $k => $v )
  	  			<div style="color: #005c9c;display: inline-block;text-transform: uppercase;font-size: 11px;font-weight: bold;"><em style="display: inline-block;height: .8em;width: .8em;background-color: {!!$argColor[$k]!!};"></em> {!!$k!!} @if( round ($v * 100 / $total) <= 4 ) [{!! round ($v * 100 / $total) !!}%] @endif</div>&nbsp;&nbsp;
  	  			@endforeach
  	  		</div>
  	  		<div style="height: 21px;border-radius: 4px;">
  	  			@foreach($value as $k => $v )
  	  			<div class="device_item" style="
  	  				color: #fff;
  	  				display: inline-block;
  	  				font-weight: bold; 
  	  				float:left;
  	  				height:21px;
  	  				font-size: 11px;
  	  				text-shadow: #7f7f7f 0 -1px;
  	  				line-height:21px;
  	  				background-color: {!!$argColor[$k]!!};
  	  				-webkit-box-reflect: below 1px -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(0.5,rgba(255,255,255,0)),to(rgba(255,255,255,.3)));
  	  				width:{!! $v * 100 / $total !!}%;">
  	  				@if( round ($v * 100 / $total) > 4 ) {!! round ($v * 100 / $total)!!}% @endif
  	  			</div>
  	  			@endforeach
  	  		</div>
          <br>
          <small style="font-size: 12px;">* Data updates continuously and each pageview</small>
    		</div>
      </div>


      <div class="card">
        <h3 class="title-rl" style="text-align:left;">Top Keywords:</h3>
        <div id="rt_keyword"></div>
      </div>

      <div class="card">
    		<h3 class="title-rl" style="text-align:left;">Traffic Source</h3>
    		<div id="rt_source"></div>
      </div>

      <div class="card">
    		<h3 class="title-rl" style="text-align:left;">Traffic Type:</h3>
    		<div id="rt_trafficType"></div>
      </div>


      <div class="card">
        <h3 class="title-rl" style="text-align:left;">Browser:</h3>
        <div id="rt_browser"></div>
      </div>

      <div class="card">
        <h3 class="title-rl" style="text-align:left;">Location:</h3>
        <div id="rt_location"></div>
      </div>


  	</div>


  	<div class="column-right" style="width: 66.999%;display: inline-block;float: left;">

    

      <div class="card">
        <h3 class="title-rl" >Pageviews</h3>
        <div id="chart_30" style="margin-bottom:5px;"></div>
      </div>


      <div class="card">
    		<h3 class="title-rl" >Top Active Pages:</h3>
    		<div id="rt_pagePath" style="margin-bottom:5px;"></div>
      </div>

      <div class="card" style="padding: 0;">
        @if( $filter )
          <a href="?filter=null" style="cursor:pointer; display: inline-block;width: auto; background: #4d90fe; font-size: 13px; margin: 0 3px 0 0; padding: 7px 10px;-webkit-border-radius: 2px;color: white;background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed); line-height: 1em;white-space: nowrap;position: absolute;z-index: 1;">COUNTRY: {!!$filter!!} <strong style="color:white;">X</strong></a>
        @endif
  		  <div id="rt_country"  style="height: 450px;"></div>
  		</div>

  	</div>

	

      <div style="clear: both;"></div>
