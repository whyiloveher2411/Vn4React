
<?php

$filter = $r->get('filter');

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


  $data = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:country,rt:city,rt:latitude,rt:longitude&metrics=rt:activeUsers&sort=-rt:activeUsers&filters=rt:country%3D~%5E'.urlencode($filter).'&access_token='.$access_token),true);

  $arg = ['count1'=>['title'=>'City','value'=>[]]];

  if( isset( $data['rows'] ) ){
    $dataRow = $data['rows'];
  }else{
    $dataRow = [];
  }

  // $city = [];
  // $long_lat = [];

  // foreach ($data['rows'] as $key => $value) {

  //   if( !isset($city[$value[1]]) ) $city[$value[1]] = 0;
  //   $city[$value[1]] += $value[4];

  //   if( !isset($long_lat[$value[2].','.$value[3]]) ) $long_lat[$value[2].','.$value[3]] = 0;
  //   $long_lat[$value[2].','.$value[3]] = 0;



  //   if( !isset($arg['count1']['value'][$value[1]]) ){
  //     $arg['count1']['value'][$value[1]] = 0;
  //   }
  //   $arg['count1']['value'][$value[1]] += $value[4];
  // }
}else{

  $data = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:country&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token),true);
  $arg = ['count1'=>['title'=>'Country','value'=>[]]];
  foreach ($data['rows'] as $key => $value) {
    if( !isset($arg['count1']['value'][$value[0]]) ){
      $arg['count1']['value'][$value[0]] = 0;
    }
    $arg['count1']['value'][$value[0]] += $value[1];
  }
}

$total = $data['totalsForAllResults']['rt:activeUsers'];

$dk_total = true;
if( $total == 0 ){
  $dk_total = false; 
  $total = 1;
}


?>

<script type="text/javascript">


  


 @if( $filter )

     google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);
    function drawTable() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'City');
      data.addColumn('number', '');
      data.addColumn('number', 'Active Users',{'width':'50px'});
      data.addRows([
        @foreach($dataRow as $k => $v)

          <?php 
              $v[1] = $v[1] == 'zz' ? '(not set)': $v[1];
           ?>
          ['{!!$v[1]!!}',  {!!$v[4]!!},  {v: {!!number_format($v[4] * 100 / $total)!!}, f: '{!! number_format($v[4] * 100 / $total,2)!!}%'}],
        @endforeach
      ]);
      var table = new google.visualization.Table(document.getElementById('rt_country'));
      table.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});
    }

    
    google.charts.load('current', {
      'packages':['geochart'],
      // Note: you will need to get a mapsApiKey for your project.
      // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    });

    // google.load('visualization','1', {
    //   'packages': ['geochart']
    // });

    google.setOnLoadCallback(drawMarkersMap);
    function drawMarkersMap() {

       var data = new google.visualization.DataTable();
      data.addColumn('number', 'Lat');                                
       data.addColumn('number', 'Long');
       data.addColumn('string', 'City'); 
       data.addColumn('number', 'Active Users'); 
       data.addColumn({type:'string', role:'tooltip',p:{html:true}});                        

      data.addRows([

        @foreach($dataRow as $k => $v)
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

      var geochart = new google.visualization.GeoChart(document.getElementById('rt_country_map'));
      geochart.draw(data, opts);
    };

  @else

    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);
    function drawTable() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Country');
      data.addColumn('number', '');
      data.addColumn('number', 'Active Users',{'width':'50px'});
      data.addRows([
        <?php 
          $value = $arg['count1']['value'];
      arsort($value);
         ?>
        @foreach($value as $k => $v)
          ['<a href="?filter={!!$k!!}">{!!$k!!}</a>',  {!!$v!!},  {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
        @endforeach
      ]);
      var table = new google.visualization.Table(document.getElementById('rt_country'));
      table.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});
    }

    google.charts.load('current', {
      'packages':['geochart'],
    });
    google.charts.setOnLoadCallback(drawRegionsMap);
    function drawRegionsMap() {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'Active Users'],
        <?php 
          $value = $arg['count1']['value'];
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

      var chart = new google.visualization.GeoChart(document.getElementById('rt_country_map'));
      google.visualization.events.addListener(chart, 'select', myClickHandler);
      chart.draw(data, options);

      var body = document.body,
      html = document.documentElement;
      var height = Math.max( body.scrollHeight, body.offsetHeight,  html.clientHeight, html.scrollHeight, html.offsetHeight );
      document.body.style.height = height + 'px';
    }
  @endif
</script>

<style type="text/css">
  .icon-refesh{
    display: none;
  }
  *{
    margin: 0;
    padding: 0;
  }
  body{
    overflow:hidden;
  }
</style>
<a href="?filter=null" style="cursor:pointer; display: inline-block;width: auto; background: #4d90fe; font-size: 13px; margin: 0 3px 0 0; padding: 7px 10px;-webkit-border-radius: 2px;color: white;background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed); line-height: 1em;white-space: nowrap;position: absolute;z-index: 1;">COUNTRY: {!!$filter!!} <strong style="color:white;">X</strong></a>

  <div id="rt_country_map" style="width:100%;height: 450px;"></div>
