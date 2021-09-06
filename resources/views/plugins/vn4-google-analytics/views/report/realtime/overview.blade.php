
<?php

$data = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:pagePath,rt:source,rt:keyword,rt:trafficType,rt:browser,rt:deviceCategory,rt:country&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token),true);


$total = $data['totalsForAllResults']['rt:activeUsers'];
$arg = [
	'count1'=>['title'=>'Top Active Pages','value'=>[]],
	'count2'=>['title'=>'Traffic Source','value'=>[]], 
	'count3'=>['title'=>'Keywords','value'=>[]], 
	'count4'=>['title'=>'Traffic Type','value'=>[]], 
	'count5'=>['title'=>'Browser', 'value'=>[]], 
	'count6'=>['title'=>'Device','value'=>[]], 
	'count7'=>['title'=>'Country','value'=>[]]];

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


	if( !isset($arg['count5']['value'][$value[4]]) ){
		$arg['count5']['value'][$value[4]] = 0;
	}

	$arg['count5']['value'][$value[4]] += $value[7];

	if( !isset($arg['count6']['value'][$value[5]]) ){
		$arg['count6']['value'][$value[5]] = 0;
	}

	$arg['count6']['value'][$value[5]] += $value[7];


	if( !isset($arg['count7']['value'][$value[6]]) ){
		$arg['count7']['value'][$value[6]] = 0;
	}

	$arg['count7']['value'][$value[6]] += $value[7];
}
?>

  	<script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Active Page');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows([
        	<?php 
        		$value = $arg['count1']['value'];
				arsort($value);
        	 ?>
        	@foreach($value as $k => $v)
          	['{!!$k!!}',  {!!$v!!},  {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
         	@endforeach
        ]);
        var table = new google.visualization.Table(document.getElementById('rt_pagePath'));
        table.draw(data, {showRowNumber: true, width: '100%',height:'300px'});



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


      }




      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([

          ['Country', 'Active Users'],
          <?php 
            $value = $arg['count7']['value'];
            arsort($value);
           ?>
           @foreach($value as $k => $v)
            ['{!!$k!!}',  {!!$v!!}],
          @endforeach
        ]);

        var options = {

          backgroundColor: 'rgb(234, 247, 254)',
          legend:'none',
        };

        var chart = new google.visualization.GeoChart(document.getElementById('rt_country'));

        google.visualization.events.addListener(chart, 'ready', function(){

            var body = document.body,
            html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );

            document.body.style.height = height + 'px';

            window.parent.$('#iframe-realtime-overview',window.parent.document).css({'height': height+'px'});

        });

        chart.draw(data, options);

      }
    </script>

  	<div style="width: 32.999%;text-align: center;display: inline-block;float: left;box-sizing: border-box;padding:0 5px 0 0; ">
  		<div style="font-size: 200%;padding-top:20px;">Right now</div>
  		<div style="font-size: 75px;" id="total_">{!!$total!!}</div>
  		<div style="font-size: 82%;">active users on site</div>
      
  		<div style="padding: 25px 15px;">
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
  		</div>

      <br>
      <h3 class="title-rl" style="text-align:left;">Top Keywords:</h3>
      <div id="rt_keyword"></div>


		  <br>
  		<h3 class="title-rl" style="text-align:left;">Traffic Source</h3>
  		<div id="rt_source"></div>

  		<br>
  		<h3 class="title-rl" style="text-align:left;">Traffic Type:</h3>
  		<div id="rt_trafficType"></div>


  		<br>
  		<h3 class="title-rl" style="text-align:left;">Browser:</h3>
  		<div id="rt_browser"></div>

      <div style="clear: both;"></div>


  	</div>


  	<div style="width: 66.999%;display: inline-block;float: left;">
  		<h3 class="title-rl" >Top Active Pages:</h3>
  		<div id="rt_pagePath" style="margin-bottom:5px;"></div>

  		<div id="rt_country">
  			
  		</div>
  		
  	</div>

	

      <div style="clear: both;"></div>
