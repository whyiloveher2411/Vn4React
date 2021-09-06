
<?php

$data = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:medium,rt:source,rt:campaign,rt:trafficType&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token),true);


$total = $data['totalsForAllResults']['rt:activeUsers'];

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
foreach ($data['rows'] as $key => $value) {

  $tf_type = $value[3];

  if( $value[2] !== '(not set)' && $value[3] === 'CUSTOM' ){
    $tf_type = 'CAMPAIGN';
  }

  if( !isset($rt_trafficType[$tf_type]) ) $rt_trafficType[$tf_type] = 0;

  $rt_trafficType[$tf_type] += $value[4];

}

arsort($rt_trafficType);


?>

<script type="text/javascript">
  google.charts.load('current', {'packages':['table']});
  google.charts.setOnLoadCallback(drawTable);

  function drawTable() {
    
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Medium');
    data.addColumn('string', 'Source');
    data.addColumn('number', '');
    data.addColumn('number', 'Active Users');
    data.addRows([
      @foreach($data['rows'] as $k => $v)
        ['{!!$v['0']!!}','{!!$v['1']!!}',  {!!$v[4]!!},  {v: {!!number_format($v[4] * 100 / $total)!!}, f: '{!! number_format($v[4] * 100 / $total,2)!!}%'}],
      @endforeach
    ]);
    var table = new google.visualization.Table(document.getElementById('rt_sources'));
    table.draw(data, {showRowNumber: true, width: '100%'});


    var body = document.body,
    html = document.documentElement;

    var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );

    document.body.style.height = height + 'px';
  }
</script>


<!--Div that will hold the pie chart-->
<div id="chart_div"></div>

<div style="width: 32.999%;text-align: center;display: inline-block;float: left;box-sizing: border-box;padding:0 5px 0 0; ">
	<div style="font-size: 200%;padding-top:20px;">Right now</div>
	<div style="font-size: 75px;" id="total_">{!!$total!!}</div>
	<div style="font-size: 82%;">active users on site</div>
  
	<div style="padding: 25px 15px;">
		<div class="" style="text-align: left;margin-bottom:3px;" >
  

			@foreach($rt_trafficType as $k => $v )
			<div style="color: #005c9c;display: inline-block;text-transform: uppercase;font-size: 11px;font-weight: bold;"><em style="display: inline-block;height: .8em;width: .8em;background-color: {!!$rt_trafficType_color[$k]!!};"></em> {!!$k!!} @if( round ($v * 100 / $total) <= 4 ) [{!! round ($v * 100 / $total) !!}%] @endif</div>&nbsp;&nbsp;
			@endforeach
		</div>
		<div style="height: 21px;border-radius: 4px;">
			@foreach($rt_trafficType as $k => $v )
			<div class="device_item" style="
				color: #fff;
				display: inline-block;
				font-weight: bold; 
				float:left;
				height:21px;
				font-size: 11px;
				text-shadow: #7f7f7f 0 -1px;
				line-height:21px;
				background-color: {!!$rt_trafficType_color[$k]!!};
				-webkit-box-reflect: below 1px -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(0.5,rgba(255,255,255,0)),to(rgba(255,255,255,.3)));
				width:{!! $v * 100 / $total !!}%;">
				@if( round ($v * 100 / $total) > 4 ) {!! round ($v * 100 / $total)!!}% @endif
			</div>
			@endforeach
		</div>
	</div>

</div>


<div style="width: 66.999%;display: inline-block;float: left;">
  <h3 class="title-rl" style="text-align:left;">Top Medium</h3>
  <div id="rt_sources"></div>
</div>

<div style="clear: both;"></div>

