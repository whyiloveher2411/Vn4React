<?php 
$mode = $r->get('mode','ga:date');
$modeArg = [
	'ga:hour'=>1,
	'ga:date'=>1,
	'ga:week'=>1,
	'ga:month'=>1,
];
if( !isset($modeArg[$mode]) ) $mode = 'ga:date';
if( $mode === 'ga:hour' ){
	$dimensions = ['ga:date','ga:hour'];
}elseif( $mode === 'ga:date' ){
	$dimensions = ['ga:date'];
}elseif( $mode === 'ga:week' ){
	$dimensions = ['ga:year','ga:week'];
}else{
	$dimensions = ['ga:year','ga:month'];
}
// dd()
$dataGoogle = multiple_threads_request(
	[
		'data_detail'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users',
		['ga:date'],
		$access_token,
		$start_date,
		$end_date
		),
		'data_browser_total'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users,ga:newUsers,ga:sessions,ga:bounceRate,ga:pageviewsPerSession,ga:avgSessionDuration,ga:goal1ConversionRate,ga:goal1Completions,ga:goal1Value',
		['ga:browser'],
		$access_token,
		$start_date,
		$end_date,
		['sort'=>'-ga:users','max-results'=>10]
		),
		'data_total'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users,ga:newUsers,ga:sessions,ga:bounceRate,ga:pageviewsPerSession,ga:avgSessionDuration,ga:goal1ConversionRate,ga:goal1Completions,ga:goal1Value',
		[],
		$access_token,
		$start_date,
		$end_date
		)
	]
);

$data_browser_total = [];
$totalsForAllResults = $dataGoogle['data_browser_total']['totalsForAllResults'];
$totalsForAllResults2 = $dataGoogle['data_total']['totalsForAllResults'];
foreach ($dataGoogle['data_browser_total']['rows'] as $k => $v) {
	foreach ($dataGoogle['data_browser_total']['columnHeaders'] as $k2 => $v2) {
		$data_browser_total[$v2['name']][$k] = $v[$k2];
	}
}

?>
<style>
	.table_chart{
    	padding: 10px;
	}
	.table_chart table{
	}
	.table_chart thead{
	    background-color: #e9e9e9;
	}
	.table_chart th{
	    border: solid 1px #ccc;
	    padding: 16px 15px 16px 10px;
	    vertical-align: middle;
	    font-weight: bold;
	    font-size: 11px;
	}
	.table_chart .row1{
	    font-size: 18px;
   		color: #333;
	}
	.table_chart .row1 span{
	    color: #898989;
	    display: block;
	    font-size: 11px;
	    margin: 0;
	    padding: 0;
    	font-weight: normal;
	}
	.table_chart .row1 td{
	    border: solid 1px #ccc;
	    padding: 8px 15px 8px 6px;
	    vertical-align: top;
	    font-size: 12px;
       	text-align: right;
	    font-weight: bold;
	    font-size: 20px;
	    color: #333;
	}
	.table_chart td{
	    border: solid 1px #ccc;
	    padding: 8px 15px 8px 6px;
	    vertical-align: middle;
	    font-size: 12px;
	    color: #333;
	}
	.table_chart tr td:not(:first-child){
		text-align: right;
	}
	.table_chart span{
	    font-weight: normal;
		font-size: 11px;
		margin-left: 5px;
		color: #898989;
	    min-width: 50px;
		display: inline-block;
	}
	.thtr1 th{
		text-align: center;
	}
</style>

<div id="chart_current" class="chart_area" style="width:100%;"></div>
<div style="clear: both;"></div>
<div class="table_chart">
	<table style="width: 100%;" >
		<thead>
			<tr class="thtr2">
				<th rowspan="2" style="min-width: 160px;">Age</th>
				<th colspan="3">Acquisition</th>
				<th colspan="3">Behavior</th>
				<th colspan="3">Conversions</th>
			</tr>
			<tr class="thtr1">
				<th>Users</th>
				<th>New Users</th>
				<th>Sessions</th>
				<th>Bounce Rate</th>
				<th>Pages / Session</th>
				<th>Avg. Session Duration</th>
				<th>Contact Page (Goal 1 Conversion Rate)</th>
				<th>Contact Page (Goal 1 Completions)</th>
				<th>Contact Page (Goal 1 Value)</th>
			</tr>
		</thead>
		<tbody>
			<tr class="row1">
				<td></td>
				<td>
					{!!number_format($totalsForAllResults['ga:users'])!!}
					<span>% of Total: {!!number_format($totalsForAllResults['ga:users'] * 100 / $totalsForAllResults2['ga:users'],2)!!}%  ({!!number_format($totalsForAllResults2['ga:users'])!!})</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:newUsers'])!!}
					<span>% of Total: {!!number_format($totalsForAllResults['ga:newUsers'] * 100 / $totalsForAllResults2['ga:newUsers'],2)!!}%  ({!!number_format($totalsForAllResults2['ga:newUsers'])!!})</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:sessions'])!!}
					<span>% of Total: {!!number_format($totalsForAllResults['ga:sessions'] * 100 / $totalsForAllResults2['ga:sessions'],2)!!}%  ({!!number_format($totalsForAllResults2['ga:sessions'])!!})</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:bounceRate'],2)!!}%
					<span>Avg for View: {!!number_format($totalsForAllResults2['ga:bounceRate'],2)!!}%  ({!!number_format($totalsForAllResults['ga:bounceRate'] * 100 / $totalsForAllResults2['ga:bounceRate'] - 100 ,2)!!}%)</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:pageviewsPerSession'],2)!!}
					<span>Avg for View: {!!number_format($totalsForAllResults2['ga:pageviewsPerSession'],2)!!}  ({!!number_format($totalsForAllResults['ga:pageviewsPerSession'] * 100 / $totalsForAllResults2['ga:pageviewsPerSession'] - 100,2)!!}%)</span>
				</td>
				<td>
					<?php 
						$time = number_format($totalsForAllResults['ga:avgSessionDuration']);
						$hours = floor($time / 3600);
						$mins = floor($time / 60 % 60);
						$secs = floor($time % 60);
						$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
						$time = number_format($totalsForAllResults2['ga:avgSessionDuration']);
						$hours = floor($time / 3600);
						$mins = floor($time / 60 % 60);
						$secs = floor($time % 60);
						$timeFormat2 = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
					 ?>
					{!!$timeFormat!!}
					<span>Avg for View: {!!$timeFormat2!!}  ({!!number_format($totalsForAllResults['ga:avgSessionDuration'] * 100 / $totalsForAllResults2['ga:avgSessionDuration'] - 100,2)!!}%)</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:goal1ConversionRate'],2)!!}%
					<span>% of Total:  {!!number_format($totalsForAllResults2['ga:goal1ConversionRate'],2)!!}%  ({!!number_format($totalsForAllResults['ga:goal1ConversionRate'] * 100 / $totalsForAllResults2['ga:goal1ConversionRate'] - 100,2)!!}%)</span>
				</td>
				<td>
					{!!number_format($totalsForAllResults['ga:goal1Completions'])!!}
					<span>% of Total:  {!!number_format($totalsForAllResults['ga:goal1Completions'] * 100 / $totalsForAllResults2['ga:goal1Completions'],2)!!}%  ({!!number_format($totalsForAllResults2['ga:goal1Completions'])!!})</span>
				</td>
				<td>
					${!!number_format($totalsForAllResults['ga:goal1Value'],2)!!}
					<span>% of Total: @if( $totalsForAllResults2['ga:goal1Value'] != 0) {!!number_format($totalsForAllResults['ga:goal1Value'] * 100 / $totalsForAllResults2['ga:goal1Value'],2)!!}% @else 0.00% @endif   <span>(${!!$totalsForAllResults2['ga:goal1Value']*1 ?number_format($totalsForAllResults2['ga:goal1Value'],2):'0.00'!!})</span></span>
				</td>
			</tr>
			@foreach($data_browser_total['ga:browser'] as $k => $v)
			<tr>
				<td>{!!$v!!}</td>
				<td>{!!number_format($data_browser_total['ga:users'][$k])!!} <span>@if( $totalsForAllResults['ga:users'] != 0) ({!!number_format($data_browser_total['ga:users'][$k] * 100 / $totalsForAllResults['ga:users'],2)!!}%) @endif</span></td>
				<td>{!!number_format($data_browser_total['ga:newUsers'][$k])!!} <span>@if( $totalsForAllResults['ga:newUsers'] != 0) ({!!number_format($data_browser_total['ga:newUsers'][$k] * 100 / $totalsForAllResults['ga:newUsers'],2)!!}%) @endif</span></td>
				<td>{!!number_format($data_browser_total['ga:sessions'][$k])!!} <span>@if( $totalsForAllResults['ga:sessions'] != 0) ({!!number_format($data_browser_total['ga:sessions'][$k] * 100 / $totalsForAllResults['ga:sessions'],2)!!}%) @endif</span></td>
				<td>{!!number_format($data_browser_total['ga:bounceRate'][$k],2)!!}%</td>
				<td>{!!number_format($data_browser_total['ga:pageviewsPerSession'][$k],2)!!}</td>
				<?php 
					$time = number_format($data_browser_total['ga:avgSessionDuration'][$k]);
					$hours = floor($time / 3600);
					$mins = floor($time / 60 % 60);
					$secs = floor($time % 60);
					$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
				 ?>
				<td>{!!$timeFormat!!}</td>
				<td>{!!number_format($data_browser_total['ga:goal1ConversionRate'][$k],2)!!}%</td>
				<td>{!!number_format($data_browser_total['ga:goal1Completions'][$k])!!} <span>@if( $totalsForAllResults['ga:goal1Completions'] != 0) ({!!number_format($data_browser_total['ga:goal1Completions'][$k] * 100 / $totalsForAllResults['ga:goal1Completions'],2)!!}%) @endif</span></td>
				<td>${!!number_format($data_browser_total['ga:goal1Value'][$k],2)!!} @if( $totalsForAllResults['ga:goal1Value'] != 0) <span>({!!number_format($data_browser_total['ga:goal1Value'][$k] * 100 / $totalsForAllResults['ga:goal1Value'],2)!!}%)</span> @else <span>(0.00%)</span> @endif</td>
			</tr>
			@endforeach
		</tbody>
	 </table>
</div>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
  	google.charts.setOnLoadCallback(drawChart);
  	function drawChart(){
	  	var data = google.visualization.arrayToDataTable([
	      [{type: 'datetime', label: 'Date'},'User'],
	      @foreach($dataGoogle['data_detail']['rows'] as $k => $v)
	      	[{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:'{!!date("l, F d, Y", strtotime($v[0]))!!}'},  {!!$v[1]!!}],
	      @endforeach
	    ]);
	    var options = {
	      title: '',
	      colors:['#058DC7'],
		  chartArea:{left:15,right:15,height:350},
		  tooltip:{showColorCode:true},
		  focusTarget:'category',
		  pointSize: 8,
		  lineWidth: 3,
		  areaOpacity:0.2,
	      hAxis: {title: '', format:'MMMM dd, yyyy', gridlines: {count:4, color: '#f1f1f1'}},
	      vAxis: {textPosition: 'in',  minValue: 0,gridlines: {count:4,color: '#f1f1f1'}},
	      legend: {position: 'top'},
	    };
	    var chart = new google.visualization.AreaChart(document.getElementById('chart_current'));
	    chart.draw(data, options);
	}
</script>