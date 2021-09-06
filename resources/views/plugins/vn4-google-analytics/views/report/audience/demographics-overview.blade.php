<?php 
$metric = $r->get('metric','ga:users');

$argMetric = [
  'ga:users'=>'users',
  'ga:sessions'=>'sessions',
  'ga:pageviews'=>'pageviews',
  'ga:sessionDuration'=>'session duration',
  'ga:bounces'=>'bounces',
  'ga:newUsers'=>'new users',
];

if( !isset($argMetric[$metric]) ){
  $metric = 'ga:users';
}

$dataGoogle = multiple_threads_request([
    'dataTotal'=>get_url_google_analytics(
    'https://www.googleapis.com/analytics/v3/data/ga',
    $webpropertie_id,
    $metric,
    [],
    $access_token,
    $start_date,
    $end_date
    ),

	'age' => get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		$metric,
		['ga:userAgeBracket'],
		$access_token,
		$start_date,
		$end_date,
		['max-results'=>'10000']
	),
	'gender' => get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		$metric,
		['ga:userGender'],
		$access_token,
		$start_date,
		$end_date,
		['max-results'=>'10000','sort'=>'-ga:userGender']
	),
	
]);

$total = $dataGoogle['dataTotal']['rows'][0][0];
$total_user_age = 0;

foreach ($dataGoogle['age']['rows'] as $key => $value) {
  $total_user_age += $value[1];
}


$total_user_gender = 0;

foreach ($dataGoogle['gender']['rows'] as $key => $value) {
  $total_user_gender += $value[1];
}

?>
<style>
	.chart_area{
    border:  1px solid #dbdbdb;

  }
  .char_title{
    color: #005c9c;
    font-size: 15px;
    text-align: left;
    display: inline-block;
    width: auto;
    float: left;
    margin: 10px 22px 10px 10px;
  }
  .char_precent{
    color: #666;
    float: right;
    font-size: 90%;
    padding-right: 10px;
    margin-top: 10px;
  }
</style>

<p style="text-align: left;">
<label style="margin: 10px;display: inline-block;">Key Metric:  

  <select name="metric" id="key_metric" style=" text-transform: capitalize;height: 30px;font-size: 13px;color: rgb(68, 68, 68);">

    @foreach($argMetric as $k => $v)
    <option value="{!!$k!!}" @if( $k === $metric) selected="selected" @endif >{!!$v!!}</option>
    @endforeach
  </select>


</label>
</p>
  <div style="clear:both;"></div>

<div class="chart_area" style="width:49.9%;float:left;margin:5px 0 0;">
  <div class="char_title">Age</div>
  <div class="char_precent">{!!number_format($total_user_age * 100 / $total,2)!!}% of total {!!$argMetric[$metric]!!}</div>
  <div style="clear:both;"></div>
  <div id="chart_age" style="height:400px;">
    
  </div>
</div>
<div class="chart_area" style="width:49.9%;float:left;margin: 5px 0 0;border-left: 0;">
  <div class="char_title">Gender</div>

  <div class="char_precent">{!!number_format($total_user_gender * 100 / $total,2)!!}% of total {!!$argMetric[$metric]!!}</div>
  <div style="clear:both;"></div>
  <div id="chart_gender" style="height:400px;">
    
  </div>
</div>

<div style="clear: both;"></div>

<script type="text/javascript">
	
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    <?php 
    	$style = ['rgb(135, 206, 234)', 'rgb(5, 141, 199)','rgb(135, 206, 234)','rgb(144, 210, 236)','rgb(155, 215, 239)','rgb(155, 215, 239)','rgb(155, 215, 239)'];
     ?>
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Age', 'Users', { role: 'style' }],

        @foreach($dataGoogle['age']['rows'] as $k => $v)
        ['{!!$v[0]!!}',{v:{!!number_format($v[1] * 100 / $total_user_age,2)!!},f: '{!!number_format($v[1] * 100 / $total_user_age,2)!!}%' }, '{!!$style[$k]!!}'],
        @endforeach
      ]);
      var options = {
        title: "",
        width: '100%',
        height: '100%',
        bar: {groupWidth: '95%'},
        chartArea:{left:50,right:20,height:350},
        legend: { position: 'none' },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_age'));
      chart.draw(data, options);
  	}

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart2() {

        var data = google.visualization.arrayToDataTable([
          ['Gender', 'Users'],
          @foreach($dataGoogle['gender']['rows'] as $k => $v)
	        ['{!!$v[0]!!}', {!!$v[1]!!}],
          @endforeach
        ]);

        var options = {
          title: '',
          colors:['#046B97','#058DC7'],
          legend:{position: 'top',alignment:'center'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_gender'));

        chart.draw(data, options);
      }
    
    $(document).on('change','#key_metric',function(){
         window.location.href = replaceUrlParam(window.location.href, 'metric',$(this).val());
    });
</script>