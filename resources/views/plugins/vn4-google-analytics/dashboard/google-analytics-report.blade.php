<div class="div-warper">
<?php 
// Icon: fa-pie-chart
$r = request();

$plugin = plugin('vn4-google-analytics');

$access_code = $plugin->getMeta('access_token_first');

$webpropertie_id = $access_code['webpropertie_id'];

$access_token = get_access_token($plugin);

include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/function-helper.php');
// include __DIR__.'/function/'

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
 ?>
<style type="text/css">
	*{
		margin: 0;
		padding: 0;
		text-decoration: none;
		outline: none;
		box-sizing: border-box;
		font-family: 'Roboto',sans-serif;
	}
	body{
	}
	.section-card{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
	}
	.card{
		color: rgba(0,0,0,0.87);
	    border-radius: 2px;
	    flex-direction: column;
	    margin: 0 8px;
	}
	.card .outer-title{
		height: 18px;
	    margin: 20px 0 20px 8px;
	    color: #4a4a4a;
		font-family: 'Roboto',sans-serif;
	    letter-spacing: 0;
	}
	.inter-title{
		color: rgba(0,0,0,0.54);
	}
	.tab-group{
		height: 120px;
	}
	.tab-item{
	    min-width: 94px;
	    padding: 20px 24px 16px;
	    display: inline-block;
	    float: left;
		border-top: 4px solid white;
		cursor: pointer;
	}
	.tab-item .title{
	    color: rgba(0,0,0,0.54);
		font-family: 'Roboto',sans-serif;
	    letter-spacing: 0;
	    margin-bottom: 18px;
	    font-size: 13px;
		display: block;
	}
	.uppercase{
		text-transform: uppercase;
	}
	.tab-item .number{
	    color: rgba(0,0,0,0.87);
		font-family: 'Roboto',sans-serif;
	    letter-spacing: 0;
	    margin-bottom: 10px;
	    display: block;
	    font-weight: normal;
	}
	.tab-item .present{
		font-size: 12px;
	}
	.tab-item .title span{
		color: rgba(0,0,0,0.54);
	}
	.tab-item.active .title span{
		opacity: 0;
	}
	.tab-item.active .title:before{
		position: absolute;
		font-weight: bold;
		content: attr(data-text);
	}
	.tab-item.active{
		border-top: 4px solid  #4285f4;
	}
	.tab-item .present svg{
		width: 10px;
    	height: 9px;
	}
	.card .card-content{
		height: 500px;
	    box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
	    background: white;
	}
	.card-content.realtime{
		background-color: #4285f4;
		padding: 24px 24px 0;
	}
	.card-656{
		width: 656px;
	}
	.card-488{
		width: 488px;
	}
	.card-320{
		width: 320px;
	}
	
	.tab-users .decrease, .tab-sessions .decrease, .tab-time .decrease, .tab-bounceRate .increase, .chart-users .google-visualization-tooltip-item .present.decrease, .chart-sessions .google-visualization-tooltip-item .present.decrease, .chart-time .google-visualization-tooltip-item .present.decrease, .chart-bounceRate .google-visualization-tooltip-item .present.increase {
	    color: #db4437 !important; 
	}
	.tab-users .increase, .tab-sessions .increase, .tab-time .increase, .tab-bounceRate .decrease, .chart-users .google-visualization-tooltip-item .present.increase, .chart-sessions .google-visualization-tooltip-item .present.increase, .chart-time .google-visualization-tooltip-item .present.increase, .chart-bounceRate .google-visualization-tooltip-item .present.decrease {
	    color: #0f9d58 !important;
	}
	.tab-users .decrease svg, .tab-sessions .decrease svg, .tab-time .decrease svg, .tab-bounceRate .increase svg, .chart-users .google-visualization-tooltip-item .present.decrease svg, .chart-sessions .google-visualization-tooltip-item .present.decrease svg, .chart-time .google-visualization-tooltip-item .present.decrease svg, .chart-bounceRate .google-visualization-tooltip-item .present.increase svg{
	    color: #db4437 !important; 
	    fill: #db4437 !important;
	}
	.tab-users .increase svg, .tab-sessions .increase svg, .tab-time .increase svg, .tab-bounceRate .decrease svg, .chart-users .google-visualization-tooltip-item .present.increase svg, .chart-sessions .google-visualization-tooltip-item .present.increase svg, .chart-time .google-visualization-tooltip-item .present.increase svg, .chart-bounceRate .google-visualization-tooltip-item .present.decrease svg{
	    color: #0f9d58 !important;
	    fill: #0f9d58 !important;
	}
	table.table-chart{
		width: 100%;
		margin-top: 20px;
	}
	table.table-chart td{
    	white-space: pre;
	}
	table.table-chart thead td{
		padding: 5px;
		font-size: 12px;
	}
	table.table-chart.color-white thead td{
		color: rgba(255,255,255,0.8);
	}
	table.table-chart.color-white td{
		color: white;
	}
	table.table-chart td{
		padding: 5px;
		color: rgba(0, 0, 0, 0.87);
		font-size: 13px;
		height: 29px;
		border-bottom: 1px solid rgba(0,0,0,0.08);
	}
	table.table-chart td:nth-child(2), table.table-chart td:nth-child(3){
		text-align: right;
	}
	.google-visualization-tooltip .google-visualization-tooltip-item{
		white-space: nowrap;
		margin: 3px 0;
	}
	.google-visualization-tooltip .google-visualization-tooltip-item:first-child, .google-visualization-tooltip .google-visualization-tooltip-item:last-child{
		margin: 3px 0;
	}
	#chart_30 .google-visualization-tooltip .google-visualization-tooltip-item span{
		font-size: 12px !important;
		color: #545454 !important;
	}
	#chart_30 .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) span{
		font-size: 18px !important;
	}
	#chart_30 .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2){
		margin: 10px 0px !important;
	}
	
	#char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2), #char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) strong, #char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) .present{
		font-size: 12px !important;
	}
	#char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) span{
		font-weight: normal !important;
	}
	#char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2), #char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) strong, #char_audience .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) .present{
		font-weight: bold !important;
	}
	#char_audience .google-visualization-tooltip-item svg{
		width: 10px;
    	height: 9px;
	}
	#chart_location{
	}

	#chart_location svg>g>g>g:nth-child(3) rect{
		display: none;
	}
	#char_acquisition svg>g>g>g>rect[fill="#3367d6"]{
	    stroke: #3367d6;
		stroke-width: 2px;
	}
	#char_acquisition svg>g>g>g>rect[fill="#4285f4"]{
	    stroke: #4285f4;
		stroke-width: 2px;
	}
	#char_acquisition svg>g>g>g>rect[fill="#72a4f7"]{
	    stroke: #72a4f7;
		stroke-width: 2px;
	}
	#char_acquisition svg>g>g>g>rect[fill="#d0e0fc"]{
	    stroke: #d0e0fc;
		stroke-width: 2px;
	}
	#char_acquisition svg>g>g>g>rect[fill="#a0c2f9"]{
	    stroke: #a0c2f9;
		stroke-width: 2px;
	}
	.item-h{
		border-radius: 5px;
		padding: 10px;
	}
	.item-h:hover{
		cursor: pointer;
		background: #f1f3f4;
	}

	#table_chart_users_by_time td{
	    text-align: center;
	    height: 11px;
	    margin: 0.7px 1.2px;
        display: inline-block;
   		width: 30.14px;
		color: rgba(0,0,0,0.54);
	}

	#table_chart_users_by_time td:not(.not-hover):hover{
	    background: #2f5ec4 !important;
	}

	#table_chart_users_by_time td.hour{
		width: 37px;
		text-align: center;
	}
	#char_acquisition_legend{
		margin-top: 15px;
	}
	.acquisition_item{
	    display: inline;
	    font-size: 12px;
	    color: rgba(0,0,0,0.54);
	    margin: 20px 15px 0 0;
	}
	.acquisition_item span{
		display: inline-block;
	    width: 6px;
	    height: 6px;
	    border-radius: 50%;
	    margin-bottom: 1px;
	    margin-right: 2px;
	}
	.disable_pc{
		display: none;
	}
	@media (max-width: 1336px){
		.disable_pc{
			display: block;
		}
	}
	
</style>
<meta name="url_load_more_js" content="{!!route('admin.controller',['controller'=>'javascript','method'=>'load-more'])!!}">
<section class="section-card">
 	
 	<div class="card card-656 card-audience">
 		<div class="outer-title">
      		Google Analytics Home
 		</div>
 		<div class="card-content">
 			<div class="tab-group" >
	 			<div class="tab-item tab-users active" data-key="ga:users" data-chart="chart-users">
	 				<span class="title" data-text="Users"><span>Users</span></span>
	 				<span class="number uppercase">{!!thousandsCurrencyFormat($dataGoogle['card1_total']['totalsForAllResults']['ga:users'])!!}</span>
	 				<?php 
 						$present = 100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:users'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:users'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:users'] : 1);
 					 ?>
	 					 @if( $dataGoogle['card1_total']['totalsForAllResults']['ga:users'] > $dataGoogle['card2_total']['totalsForAllResults']['ga:users'] )
	 					 <span class="present increase">
							<svg id="metric-table-increase-delta-arrow_cache67" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(-2, -3)">
							      <polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon>
							    </g>
						  </svg>
	 					 @else
	 					<span class="present decrease">
							<svg id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(3, 4.5)">
							      <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon>
							    </g>
						  	</svg>
	 					 @endif
	 					
						  {!!number_format(abs($present),1)!!}%
	 				</span>
	 			</div>
	 			<div class="tab-item tab-sessions" data-key="ga:sessions" data-chart="chart-sessions">
	 				<span class="title" data-text="Sessions"><span>Sessions</span></span>
	 				<span class="number uppercase">{!!thousandsCurrencyFormat($dataGoogle['card1_total']['totalsForAllResults']['ga:sessions'])!!}</span>
	 				<?php 
 						$present = 100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:sessions'] * 100 / ( $dataGoogle['card2_total']['totalsForAllResults']['ga:sessions'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:sessions'] : 1);
 					 ?>
	 					 @if( $dataGoogle['card1_total']['totalsForAllResults']['ga:sessions'] > $dataGoogle['card2_total']['totalsForAllResults']['ga:sessions'] )
	 					<span class="present increase">
							<svg id="metric-table-increase-delta-arrow_cache67" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(-2, -3)">
							      <polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon>
							    </g>
						  </svg>
	 					 @else
	 					<span class="present decrease">
							<svg id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(3, 4.5)">
							      <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon>
							    </g>
						  	</svg>
	 					 @endif
	 					
						  {!!number_format(abs($present),1)!!}%
	 				</span>
	 			</div>
	 			<div class="tab-item tab-bounceRate" data-key="ga:bounceRate" data-chart="chart-bounceRate">
	 				<span class="title" data-text="Bounce Rate"><span>Bounce Rate</span></span>
	 				<span class="number">{!!number_format($dataGoogle['card1_total']['totalsForAllResults']['ga:bounceRate'],2)!!}%</span>
	 				<?php 
 						$present = 100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:bounceRate'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:bounceRate'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:bounceRate'] : 1);
 					 ?>
	 					 @if( $dataGoogle['card1_total']['totalsForAllResults']['ga:bounceRate'] > $dataGoogle['card2_total']['totalsForAllResults']['ga:bounceRate'] )
	 					<span class="present increase">
							<svg id="metric-table-increase-delta-arrow_cache67" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(-2, -3)">
							      <polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon>
							    </g>
						  </svg>
	 					 @else
	 					<span class="present decrease">
							<svg id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(3, 4.5)">
							      <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon>
							    </g>
						  	</svg>
	 					 @endif
	 					
						  {!!number_format(abs($present),1)!!}%
	 				</span>
	 			</div>
	 			<div class="tab-item tab-time" data-key="ga:avgSessionDuration" data-chart="chart-time">
	 				<?php 
						$time = number_format($dataGoogle['card1_total']['totalsForAllResults']['ga:avgSessionDuration']);

						$time = intval(str_replace(",","",$time));

						$hours = floor($time / 3600);
						$mins = floor($time / 60 % 60);
						$secs = floor($time % 60);
						$timeFormat = sprintf('%02dm %02ds',$mins, $secs);
					 ?>
	 				<span class="title" data-text="Session Duration"><span>Session Duration</span></span>
	 				<span class="number">{!!$timeFormat!!}</span>
	 				<?php 
 						$present = 100 - $dataGoogle['card1_total']['totalsForAllResults']['ga:avgSessionDuration'] * 100 / ($dataGoogle['card2_total']['totalsForAllResults']['ga:avgSessionDuration'] != 0 ? $dataGoogle['card2_total']['totalsForAllResults']['ga:avgSessionDuration'] :  1);
 					 ?>
	 					 @if( $dataGoogle['card1_total']['totalsForAllResults']['ga:avgSessionDuration'] > $dataGoogle['card2_total']['totalsForAllResults']['ga:avgSessionDuration'] )
	 					<span class="present increase">
							<svg id="metric-table-increase-delta-arrow_cache67" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(-2, -3)">
							      <polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon>
							    </g>
						  </svg>
	 					 @else
	 					<span class="present decrease">
							<svg id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
							    <g transform="translate(3, 4.5)">
							      <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon>
							    </g>
						  	</svg>
	 					 @endif
	 					
						  {!!number_format(abs($present),1)!!}%
	 				</span>
	 			</div>
	 		</div>	
	 		<div style="padding: 0 24px;">
	 			<div id="char_audience" class="chart-users">
		 			
		 		</div>
	 		</div>
	 		
 		</div>
 	</div>
 	<div class="card card-320">
 		<div class="outer-title"></div>
 		<div class="card-content realtime">
 			<div class="realtime-1" style="color: #fff; font: 400 14px/10px 'Roboto',sans-serif; letter-spacing: 0;">Active Users right now</div>
 			<div class="realtime-2" style="color: #fff;font: 300 50px 'Roboto',sans-serif;letter-spacing: 0;margin-top: 13px;">{!!$dataGoogle['realtime']['totalsForAllResults']['rt:activeUsers']!!}</div>
 			<div class="realtime-3" style="border-bottom: 1px solid rgba(255,255,255,0.18);padding-bottom: 4px;  color: rgba(255,255,255,0.8);font: 400 12px 'Roboto',sans-serif;letter-spacing: -0.06px;">Page views per minute</div>
 			<div id="chart_30">
	 			
	 		</div>
	 		<table class="table-chart color-white">
	 			<thead>
	 				<tr>
	 					<td>Top Active Pages</td>
	 					<td style="width: 78px;">Active Users</td>
	 				</tr>
	 			</thead>
	 			<tbody>
	 				@foreach($dataGoogle['realtime']['rows'] as $v)
	 				<?php 
	 					$path = $v[0];
						if( strlen($path) > 31 ){
							$path = mb_substr($path, 0,10).'...'.mb_substr($path, -14);
						}
	 				 ?>
					<tr>
						<td>{!!$path!!}</td>
						<td>{!!$v[1]!!}</td>
					</tr>
	 				@endforeach
	 			</tbody>
	 		</table>
 		</div>
 	</div>

 	<div class="card card-320">
 		<div class="outer-title">What are your top devices?</div>
 		<div class="card-content" style="padding: 24px 24px 0;">
 			<dir class="inter-title">Sessions by device</dir>
 			<div id="chart_sessions_by_device" style="display: inline-block;height: 250px;width:100%;">
			 			
	 		</div>

	 		<div style="margin-top: 20px;">
	 			<div class="item-h" style="display: inline-block;width: 33%;text-align: center;float:left;">
	 				<img src="{!!plugin_asset($plugin->key_word,'img/mobile.PNG')!!}" style="margin-bottom: 5px;">
		 			<div style="color: rgba(0,0,0,0.54);font-size: 12px;">Mobile</div>
		 			<div style="color: rgba(0,0,0,0.87);font-size: 17px;margin: 4px 0;" id="mobile">--</div>

		 			<div id="mobile_precent">
		 				
		 			</div>
		 		</div>


		 		<div class="item-h" style="display: inline-block;width: 33%;text-align: center;float:left;">
	 				<img src="{!!plugin_asset($plugin->key_word,'img/desktop.PNG')!!}" style="margin-bottom: 5px;">
		 			<div style="color: rgba(0,0,0,0.54);font-size: 12px;">Desktop</div>
		 			<div style="color: rgba(0,0,0,0.87);font-size: 17px;margin: 4px 0;" id="desktop">--</div>

		 			<div id="desktop_precent">
		 				
		 			</div>
		 			
		 		</div>


		 		<div class="item-h" style="display: inline-block;width: 33%;text-align: center;float:left;">
	 				<img src="{!!plugin_asset($plugin->key_word,'img/tablet.PNG')!!}" style="margin-bottom: 5px;">
		 			<div style="color: rgba(0,0,0,0.54);font-size: 12px;">Tablet</div>
		 			<div style="color: rgba(0,0,0,0.87);font-size: 17px;margin: 4px 0;" id="tablet">--</div>
		 			<div id="tablet_precent">
		 				
		 			</div>
		 		</div>

	 			

	 		</div>
	 		
 		</div>
 	</div>


 	<div class="card card-656 card-traffic">
 		<div class="outer-title">
      		How do you acquire users?
 		</div>
 		<div class="card-content">
 			<div class="tab-group" >
	 			<div class="tab-item active" data-key="channel">
	 				<span class="title">Traffic Channel</span>
	 			</div>
	 			<div class="tab-item" data-key="sourceMedium">
	 				<span class="title">Source / Medium</span>
	 			</div>
	 			<div class="tab-item" data-key="referrals">
	 				<span class="title">Referrals</span>
	 			</div>
	 		</div>	
	 		<div style="padding: 0 24px;">
	 			<div id="char_acquisition" style="height: 310px;width: 100%;">
		 			
		 		</div>
		 		<div id="char_acquisition_legend">
		 			
		 		</div>
	 		</div>
	 		
 		</div>
 	</div>
 	<div class="card card-320">
 		<div class="outer-title">Where are your users?</div>
 		<div class="card-content" style="padding: 24px;">
 			<dir class="inter-title">Sessions by country</dir>
 			<div id="chart_country" style="height: 206px;width: 100%;">
		 			
	 		</div>
	 		<div id="chart_location" style="height: 179px;width: 100%;">
		 			
	 		</div>
 		</div>
 	</div>
 	<div class="card card-320">
 		<div class="outer-title">When do your users visit?</div>
 		<div class="card-content">
 			<div style="padding: 24px 24px 0;">
 				<dir class="inter-title">Users by time of day</dir>
 				<div id="chart_users_by_time" style="height: 400px;width: 100%;">
			 		<table id="table_chart_users_by_time" style="width: 100%;font-size: 12px;margin-top: 15px;">
			 			
			 		</table>
			 		<div id="range_colors" style="margin-top: 15px;"></div>
		 		</div>
 			</div>
 			
 		</div>
 	</div>
 	<div class="card card-320 disable_pc">
 		<div class="outer-title"></div>
 		<div class="card-content" style="padding: 24px;">
 			<dir class="inter-title"></dir>
 			
 		</div>
 	</div>
 	<div class="card card-488">
 		<div class="outer-title">What pages do your users visit?</div>
 		<div class="card-content" style="padding: 24px 3px;height:390px;box-sizing: border-box;">
 			<table class="table-chart" id="path_pageview" style="margin:0;">
	 			
	 		</table>
 		</div>
 	</div>
 	<div class="card card-488">
 		<div class="outer-title">How are your active users trending over time?</div>
 		<div class="card-content" style="height:390px;padding: 24px 24px 0;">
 			<dir class="inter-title">Active Users</dir>

 			<div style="display: flex;align-items: center;">
 				<div id="chart_active_user" style="display: inline-block;height: 280px;width: 353px;">
			 			
		 		</div>
				<div style="width: 88px;text-align: center;">
		 			<div class="item-h"> 
		 				<div style="color: rgba(0,0,0,0.54);font-size: 12px;letter-spacing: 0;align-items: center;margin-bottom: 12px;"><span style="display: inline-block;width: 6px;height: 6px;background: #4285f4;border-radius: 50%;"></span>  &nbsp;30 Days</div>
		 				<div style="color: rgba(0,0,0,0.87);font-size:16px;letter-spacing: 0;" id="number30day">--</div>
		 			</div>

		 			<div class="item-h" style="margin: 10px 0;"> 
		 				<div style="color: rgba(0,0,0,0.54);font-size: 12px;letter-spacing: 0;align-items: center;margin-bottom: 12px;"><span style="display: inline-block;width: 6px;height: 6px;background: #45a5f5;border-radius: 50%;"></span>  &nbsp;7 Days</div>
		 				<div style="color: rgba(0,0,0,0.87);font-size:16px;letter-spacing: 0;" id="number7day">--</div>
		 			</div>

		 			<div class="item-h"> 
		 				<div style="color: rgba(0,0,0,0.54);font-size: 12px;letter-spacing: 0;align-items: center;margin-bottom: 12px;"><span style="display: inline-block;width: 6px;height: 6px;background: #93d5ed;border-radius: 50%;"></span>  &nbsp;1 Day</div>
		 				<div style="color: rgba(0,0,0,0.87);font-size:16px;letter-spacing: 0;" id="number1day">--</div>
		 			</div>
		 		</div>
 			</div>
 			
	 		
 		</div>
 	</div>
 	
	
 	<div class="card card-320">

 		<div class="outer-title"></div>
 		<div class="card-content" style="padding: 24px;height:390px;">
 			<dir class="inter-title">New Users vs. Returning Users</dir>
 			<div id="chart_userVisitor" style="width: 100%;">
		 			
	 		</div>
 		</div>
 	</div>

 	<div style="clear: both;padding:10px;width: 100%;"></div>
 </section>

</div>
<style type="text/css">
  *{
    font-family: Roboto, sans-serif;
    margin: 0;
    padding: 0;
    color: #222;
    text-decoration: none;
  }
  .icon-refesh{
    position: absolute;
    right: 0;
    top: 0;
    z-index: 999;
    height: 20px;
  }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

	$ = window.parent.$;

	var isInIframe = (window.location != window.parent.location) ? true : false;

	if (!isInIframe) {
	    window.location.href = '{!!route('admin.index')!!}';
	}

	$(window).load(function(){
		console.error = function(){};

		window.listColours = {!!json_encode($listColours)!!};

		window.data_audience = {'ga:users':{title:'Users',data:[]},'ga:sessions':{title:'Sessions',data:[]},'ga:bounceRate':{title:'Bounce Rate',data:[]},'ga:avgSessionDuration':{title:'Avg. Session Duration',data:[]}};
		@foreach($dataGoogle['card1']['rows'] as $k => $v)
		<?php 
			$present = number_format(abs( 100 - $v[1] * 100 / ($dataGoogle['card2']['rows'][$k][1] != 0 ? $dataGoogle['card2']['rows'][$k][1] : 1) ),1).'%<span>';
			 if( $v[1] > $dataGoogle['card2']['rows'][$k][1] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
			 }
	     ?>
	    	data_audience['ga:users'].data.push([{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:''},  {!!$v[1]!!}, '{!!date("D d M", strtotime($v[0])),' vs ',date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0]))!!}' ,{!!$dataGoogle['card2']['rows'][$k][1]!!}, 
			    '<strong>{!!number_format($v[1]),'\<\/strong>&nbsp;&nbsp;',$icon,$present!!}']);
	    <?php 
			$present = number_format(abs( 100 - $v[2] * 100 / ($dataGoogle['card2']['rows'][$k][2] != 0 ? $dataGoogle['card2']['rows'][$k][2]: 1) ),1).'%<span>';
			 if( $v[2] > $dataGoogle['card2']['rows'][$k][2] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
			 }
	     ?>
	    	data_audience['ga:sessions'].data.push([{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:''},  {!!$v[2]!!}, '{!!date("D d M", strtotime($v[0])),' vs ',date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0]))!!}' ,{!!$dataGoogle['card2']['rows'][$k][2]!!}, 
			    '<strong>{!!number_format($v[2]),'\<\/strong>&nbsp;&nbsp;',$icon,$present!!}']);
	    <?php 
			$present = number_format(abs( 100 - $v[3] * 100 / ($dataGoogle['card2']['rows'][$k][3] != 0 ? $dataGoogle['card2']['rows'][$k][3] : 1) ),1).'%<span>';
			 if( $v[3] > $dataGoogle['card2']['rows'][$k][3] ){
			 	$icon = '<span class="present increase"><svg id="metric-table-increase-delta-arrow_cache67" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon> </g></svg> ';
			 }else{
			 	$icon = '<span class="present decrease"><svg id="metric-table-decrease-delta-arrow_cache64" class="" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"> <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg>&nbsp;';
			 }
	     ?>
	    	data_audience['ga:bounceRate'].data.push([{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:''},  {!!number_format($v[3],2)!!}, '{!!date("D d M", strtotime($v[0])),' vs ',date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0]))!!}' ,{!!$dataGoogle['card2']['rows'][$k][3]!!}, 
			    '<strong>{!!number_format($v[3],2),'\<\/strong>%&nbsp;&nbsp;',$icon,$present!!}']);
	    <?php 
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

	     ?>
	    	data_audience['ga:avgSessionDuration'].data.push([{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:''},  {!!$v[4]!!}, '{!!date("D d M", strtotime($v[0])),' vs ',date("D d M", strtotime($dataGoogle['card2']['rows'][$k][0]))!!}' ,{!!$dataGoogle['card2']['rows'][$k][4]!!}, 
			    '<strong>{!!$timeFormat,'\<\/strong>&nbsp;&nbsp;',$icon,$present!!}']);
	    @endforeach
	    window.data_audience_current = 'ga:users';
		google.charts.load('current', {'packages':['corechart','geochart'], callback: function () {
	        drawChart();
      	}});

		  function drawChart(change_audien) {
		  	var data = new google.visualization.DataTable();
		  	 	data.addColumn('date','Date');
			    data.addColumn('number', '');
			    data.addColumn({type: 'string', role: 'tooltip'});
			    data.addColumn('number', data_audience[data_audience_current].title);
			    data.addColumn({type: 'string', role: 'tooltip', p: {html: true}});
			    data.addRows( data_audience[data_audience_current].data);
		    var options = {
		      title: '',
		      colors:['rgb(66, 133, 244)','rgb(101, 152, 239)'],
			  chartArea:{left:0,right:4},
			  tooltip:{isHtml:true,showColorCode:false},
			  pointSize:4,
			  lineWidth:2,
			  height:300,
			  series: {
				1: { lineDashStyle: [4, 2]},
			  },
			  crosshair: {orientation: 'vertical', trigger: 'focus' , color: '#f1f1f1'},
			  focusTarget:'category',
			  pointsVisible:false,
		      hAxis: {title: '', format:'MMM d',textStyle:{fontSize:12}, baselineColor: 'none',gridlines: {count:4, color: 'transparent'}},
		      vAxis: { textPosition: 'in',format:'short', textStyle: { fontName: 'arial',fontSize:12}, minValue: 0,baselineColor: 'none',gridlines: {count:3,color: '#f1f1f1'}},
		    };
			var chart = new google.visualization.LineChart(document.getElementById('char_audience'));
		    chart.draw(data, options);

		    if( change_audien ) return true;

	    	 var data = new google.visualization.DataTable();
		  	 	data.addColumn('string','mins ago');
		  	 	data.addColumn('number','Page Views');
		  	 	data.addColumn({type: 'string', role: 'tooltip'});
			    data.addRows([
			    	<?php 
			        	$dataPageView30M = array_reverse($dataPageView30M);
			         ?>
			        @foreach($dataPageView30M as $k => $v)
			        ['{!!$k!!}',{!!$v!!},'{!!$k!!}\n{!!$v!!}\nPage Views'],
			        @endforeach
			    ]);
		      var options = {
		        title: "",
		        colors: ['#8eb6f9'],
		        width: '100%',
		        height: '100',
				tooltip:{isHtml:true,showColorCode:false},
		        bar: {groupWidth: '8'},
		        hAxis: {title: '',textPosition: 'none',baselineColor: 'none',gridlines: {count:0, color: 'transparent'}},
		      	vAxis: { textPosition: 'none',  minValue: 0,baselineColor: 'none',gridlines: {count:0,color: 'transparent'}},
		      	backgroundColor:'#4285f4',
		        chartArea:{left:1,right:-1,height:100},
		        legend: { position: 'none' },
		      };

		      var chart = new google.visualization.ColumnChart(document.getElementById('chart_30'));
		      chart.draw(data, options);

		      <?php 
		      	$argType = ['rgb(66, 133, 244)','rgb(219, 68, 55)'];
		       ?>
		      var data = google.visualization.arrayToDataTable([
		        ['Type', 'Users',{ role: 'style' }],
		        @foreach($dataGoogle['userVisitor']['rows'] as $k => $v)
		        ['{!!$v[0]!!}',{!!$v[1]!!},'{!!$argType[$k]!!}'],
		        @endforeach
		      ]);
		      var options = {
		        title: "",
		        width: '100%',
		        height: '310',
		        isStacked: true,
			  	focusTarget:'category',
				tooltip:{isHtml:true,showColorCode:false},
		        bar: {groupWidth: '60%'},
		        chartArea:{left:30,right:-1,height:250},
		      	vAxis: { textPosition: 'out',format:'short', textStyle: { fontName: 'arial',fontSize:12}, minValue: 0,baselineColor: 'none',gridlines: {count:2,color: '#f1f1f1'}},
		      };

		      var chart = new google.visualization.ColumnChart(document.getElementById('chart_userVisitor'));
		      chart.draw(data, options);


		      var data = google.visualization.arrayToDataTable([
		          ['Country', 'Sessions'],
		           @foreach($dataGoogle['session_country']['rows'] as $k => $v)
				    ['{!!$v[0]!!}',  {!!$v[1]!!}],
			      	@endforeach
		        ]);
		        var options = {
		        	colorAxis: {minValue:0, colors: ['rgb(207, 225, 241)', 'rgb(47, 94, 196)'] },
		          	legend:'none',
			        height: '100%',
		          	magnifyingGlass: {enable: true, zoomFactor: 5.0},
		        };
		        var chart = new google.visualization.GeoChart(document.getElementById('chart_country'));
		        chart.draw(data, options);


			      var data = google.visualization.arrayToDataTable([
			        ['Country', 'Sessions',{role:'tooltip'}],
		         	@foreach($dataGoogle['session_country']['rows'] as $k => $v)
		         	@if( $k > 5) @break @endif
				    ['{!!$v[0]!!}',{!!number_format($v[1] * 100 / ($dataGoogle['session_country']['totalsForAllResults']['ga:sessions'] != 0 ? $dataGoogle['session_country']['totalsForAllResults']['ga:sessions'] : 1),2)!!}, "SESSIONS\n{!!$v[0],' ',number_format($v[1] * 100 / ( $dataGoogle['session_country']['totalsForAllResults']['ga:sessions'] != 0 ? $dataGoogle['session_country']['totalsForAllResults']['ga:sessions'] : 1 ) ,2)!!}%"],
			      	@endforeach
			      ]);
			      var formatter = new google.visualization.NumberFormat({pattern: '#%'});
					formatter.format(data, 1);
			      var options = {
			        title: "",
			        width: '100%',
			        height: '100%',
				    bars: 'horizontal',
		        	chartArea:{right:15,top:0,bottom:15},
			        colors:['rgb(66, 133, 244)'],
		        	bar: {groupWidth: '65%'},
	          		hAxis: {minValue: 0,format:"#'%'",gridlines:{count:4,color:'#ebebeb'}},
	          		vAxis:{gridlines:{color:'#ebebeb'},textStyle:{fontSize:13,color:'#9e9e9e'}},
			        legend: { position: 'none' },
			      };
			      var chart = new google.visualization.BarChart(document.getElementById('chart_location'));
			      chart.draw(data, options);

			$.ajax({
				url: '{!!route('google-analytics.report-item',['folder'=>'dashboard','view'=>'index'])!!}',
				type:'POST',
				method:'POST',
				dataType:'Json',
				data:{
					_token:'{!!csrf_token()!!}',
					start_date:'{!!$start_date!!}',
					end_date:'{!!$end_date!!}',
					start_date2:'{!!$start_date2!!}',
					end_date2:'{!!$end_date2!!}',
				},
				success:function(dataAjax){

	 				var str = '<thead><tr style="padding: 12px 5px;"><td style="color:rgba(0,0,0,0.54);font-size:14px;">Page</td><td style="width: 77px;color:rgba(0,0,0,0.54);font-size:14px;">Pageviews</td><td style="width: 83px;color:rgba(0,0,0,0.54);font-size:14px;">Page Value</td></tr></thead><tbody></tbody>';

	 				for (var i = 0; i < dataAjax.path_pageview.length; i++) {

	 					str += '<tr><td>'+dataAjax.path_pageview[i][0]+'</td><td>'+dataAjax.path_pageview[i][1]+'</td><td>$'+dataAjax.path_pageview[i][2]+'</td></tr>';
	 					
	 				};

	 				$('#path_pageview').html(str);

					Object.keys(dataAjax.data_active_total_user).forEach(function (key) {
					   $('#'+key).text(dataAjax.data_active_total_user[key]);
					});

					for (var i = 0; i < dataAjax.data_active_total_user.length; i++) {
						dataAjax.data_active_total_user[i]
					};
					var d = [
						[{type: 'date', label: 'Date'}, {type:'number',label:'Daily'}, {type:'number',label:'Weekly'}, {type:'number',label:'Monthly'}]
					];

					for (var i = 0; i < dataAjax.data_active_user.length; i++) {
						d.push([{v:new Date(dataAjax.data_active_user[i][0].v),f:dataAjax.data_active_user[i][0].f},dataAjax.data_active_user[i][1], dataAjax.data_active_user[i][2], dataAjax.data_active_user[i][3]]);
					};

					var data = google.visualization.arrayToDataTable(d);

				    options = {
				      title: '',
				      colors:['#93d5ed','#45a5f5','#4285f4'],
					  chartArea:{left:30,right:15},
					  tooltip:{showColorCode:true},
					  pointSize:6,
					  lineWidth:2,
					  pointsVisible:false,
					  height:300,
					  focusTarget:'category',
						series: {
				          0: {
				              areaOpacity: 0
				          }
				        },
				        crosshair: {orientation: 'vertical', trigger: 'focus' , color: '#f1f1f1'},
				      hAxis: {title: '', format:'MMM dd, yyyy', gridlines: {count:3, color: 'transparent'}},
				      vAxis: { textPosition: 'out', format:'short', gridlines: {count:3,color: '#f1f1f1'}},
				    };

					var chart = new google.visualization.LineChart(document.getElementById('chart_active_user'));
				    chart.draw(data, options);


				    var d = [
				    	['Device', 'Sessions'],
				    	['mobile',dataAjax.sessions_by_device.mobile[1]||0],
				    	['desktop',dataAjax.sessions_by_device.desktop[1]||0],
				    	['tablet',(dataAjax.sessions_by_device.tablet && dataAjax.sessions_by_device.tablet[1])||0],
				    ];

			    	Object.keys(dataAjax.sessions_by_device).forEach(function (key) {

			    		$('#'+key).text(dataAjax.sessions_by_device[key][2]+'%');

			    		if( dataAjax.sessions_by_device[key][3] > 0 ){
			    			$('#'+key+'_precent').html(
			    				'<svg style="height: 9px;width: 11px;display: inline;" fill="#0f9d58" id="metric-table-increase-delta-arrow_cache65" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon></g></svg><div style="display: inline;color: #0f9d58;font-size: 12px;"> '+dataAjax.sessions_by_device[key][3]+'%</div>'
			    			);
			    		}else{
			    			$('#'+key+'_precent').html(
			    				'<svg style="height: 9px;width: 11px;display: inline;" fill="#db4437" id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"><polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg><div style="display: inline;color: #db4437;font-size: 12px;"> '+(-dataAjax.sessions_by_device[key][3])+'%</div>'
			    			);
			    			
			    		}

					});

				 
					var data = google.visualization.arrayToDataTable(d);

			        var options = {
			          title: '',
			          colors:['#4285f4','#45a5f5','#93d5ed'],
			          pieHole: 0.7,
			          pieSliceText: "none",
					  chartArea:{width:300, height:200},
			          legend:'none',
			        };

			        var chart = new google.visualization.PieChart(document.getElementById('chart_sessions_by_device'));
			        chart.draw(data, options);

			        var range = Math.floor( ( dataAjax.users_by_time.max - dataAjax.users_by_time.min ) / 4 ) ;

			        var space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

			         $('#range_colors').html('<div><span style="display:inline-block;width: 55px;height:10px;background:#93d5ed;"></span> '
			        	+'<span style="display:inline-block;width: 55px;height:10px;background:#45a5f5;"></span> '
			        	+'<span style="display:inline-block;width: 55px;height:10px;background:#4285f4;"></span> '
			        	+'<span style="display:inline-block;width: 55px;height:10px;background:#2f5ec4;"></span> </div><div style="font-size: 11px;color: rgba(0,0,0,0.54);">'
			        	+ kFormatter(dataAjax.users_by_time.min) + space + kFormatter(dataAjax.users_by_time.min + range) + space + kFormatter(dataAjax.users_by_time.min + range*2) + space + kFormatter(dataAjax.users_by_time.min + range*3) +  space + kFormatter(dataAjax.users_by_time.max) + '</div>');

			         var range_colors = [
			         	[dataAjax.users_by_time.min, dataAjax.users_by_time.min + range, '#93d5ed'] ,
			         	[dataAjax.users_by_time.min + range + 1, dataAjax.users_by_time.min + range*2, '#45a5f5'] ,
			         	[dataAjax.users_by_time.min + range*2 + 1, dataAjax.users_by_time.min + range*3, '#4285f4'] ,
			         	[dataAjax.users_by_time.min + range*3 + 1, dataAjax.users_by_time.max, '#2f5ec4'] 
			         ];

			         let range2 =  50 / ( dataAjax.users_by_time.max - dataAjax.users_by_time.min ), min = dataAjax.users_by_time.min;

			        var str = '';
			        for (var i = 0; i < dataAjax.users_by_time.data.length; i++) {
			        	str += '<tr>';
			        	for (var j = 0; j < dataAjax.users_by_time.data[i].length; j++) {

			        		let indexColor = Math.round( ( dataAjax.users_by_time.data[i][j] - min ) * range2 - 1 ) ;

			        		if( indexColor < 0 ) indexColor = 0;

			        		str += '<td data-index="'+indexColor+'" style="background:'+listColours[ indexColor ]+'" title="'+kFormatter(dataAjax.users_by_time.data[i][j])+'"></td>';
			        	}

			        	if( i % 2 == 0){
			        		if( i == 0){
			        			str += '<td class="hour not-hover"> 12am</td>';
			        		}else if( i < 12 ){
			        			str += '<td class="hour not-hover"> '+i+'am</td>';
				        	}else if( i == 12 ){
			        			str += '<td class="hour not-hover"> 12pm</td>';
				        	}else{
			        			str += '<td class="hour not-hover"> '+(i - 12) +'pm</td>';
				        	}
			        	}
			        	str += '</tr>';
			        }

			        str += '<tr class="day_of_week"><td class="not-hover">Sun</td><td class="not-hover">Mon</td><td class="not-hover">Tue</td><td class="not-hover">Wed</td><td class="not-hover">Thu</td><td class="not-hover">Fri</td><td class="not-hover">Sat</td><td></td></tr>';

			        $('#table_chart_users_by_time').html(str);

			        window.data_acquire_users = {
			        	options:{
			        		title: "",
					        colors: ['#3367d6','#4285f4','#72a4f7','#a0c2f9','#d0e0fc'],
					        width: '100%',
					        height: '310',
					        isStacked: true,
						  	focusTarget:'category',
							tooltip:{isHtml:true,showColorCode:false},
					        bar: {groupWidth: '93%'},
					        chartArea:{left:1,right:-1,height:250},
					        hAxis: {gridlines: {color: 'transparent'}},
					      	vAxis: { textPosition: 'none',  minValue: 0,baselineColor: 'none',gridlines: {count:0,color: 'transparent'}},
					        legend: { position: 'none' },
			        	},
				      	channel:{
				      		legend: ['Organic Search','Direct','Paid Search','Referral','Other'],
				      		colors: ['#3367d6','#4285f4','#72a4f7','#a0c2f9','#d0e0fc'],
				      		data: [
						        [{type:'date',label:'Genre'}, 'Organic Search', 'Direct', 'Paid Search', 'Referral','Other'],
						        
					      	]
				      	},
				      	sourceMedium:{
				      		legend:[],
				      		colors: ['#3367d6','#4285f4','#72a4f7','#a0c2f9','#d0e0fc'],
				      		data: [
						        [{type:'date',label:'Genre'}],
						        
					      	]
				      	},
				      	referrals:{
				      		legend:[],
				      		colors: ['#3367d6','#4285f4','#72a4f7','#a0c2f9','#d0e0fc'],
				      		data: [
						        [{type:'date',label:'Genre'}],
						        
					      	]
				      	}

				      	
				      };

			      	Object.keys(dataAjax.traffic_channel).forEach(function (key) {
				      	data_acquire_users.channel.data.push(
				      		[{v:new Date(dataAjax.traffic_channel[key].dayv),f:dataAjax.traffic_channel[key].dayf}, dataAjax.traffic_channel[key].channel['Organic Search'], dataAjax.traffic_channel[key].channel['Direct'], dataAjax.traffic_channel[key].channel['Paid Search'], dataAjax.traffic_channel[key].channel['Referral'],dataAjax.traffic_channel[key].channel['(Other)']]
			      		);
					});

			      	Object.keys(dataAjax.traffic_sourcemedium.key).forEach(function (key) {
			      		data_acquire_users.sourceMedium.legend.push(key);
			      		data_acquire_users.sourceMedium.data[0].push(key);
			      	});

					Object.keys(dataAjax.traffic_channel).forEach(function (key) {

						var data = [{v:new Date(dataAjax.traffic_channel[key].dayv),f:dataAjax.traffic_channel[key].dayf}];

						for (var i = 0; i < data_acquire_users.sourceMedium.legend.length; i++) {
							if( dataAjax.traffic_sourcemedium.data[key] && dataAjax.traffic_sourcemedium.data[key][ data_acquire_users.sourceMedium.legend[i] ] ){
								data.push(dataAjax.traffic_sourcemedium.data[key][ data_acquire_users.sourceMedium.legend[i] ]);
							}else{
								data.push(null);
							}
						};

				      	data_acquire_users.sourceMedium.data.push(data);
					});


					Object.keys(dataAjax.traffic_referrer.key).forEach(function (key) {
			      		data_acquire_users.referrals.legend.push(key);
			      		data_acquire_users.referrals.data[0].push(key);
			      	});

					Object.keys(dataAjax.traffic_channel).forEach(function (key) {

						var data = [{v:new Date(dataAjax.traffic_channel[key].dayv),f:dataAjax.traffic_channel[key].dayf}];

						for (var i = 0; i < data_acquire_users.referrals.legend.length; i++) {
							if( dataAjax.traffic_referrer.data[key] && dataAjax.traffic_referrer.data[key][ data_acquire_users.referrals.legend[i] ] ){
								data.push(dataAjax.traffic_referrer.data[key][ data_acquire_users.referrals.legend[i] ]);
							}else{
								data.push(0);
							}
						};

				      	data_acquire_users.referrals.data.push(data);
					});

		      		var str = '';

				      for (var i = 0; i < data_acquire_users.channel.legend.length; i++) {
				      	str += '<div class="acquisition_item"><span style="background:'+data_acquire_users.channel.colors[i]+'"></span> '+data_acquire_users.channel.legend[i]+'</div>'
				      };

				      $('#char_acquisition_legend').html(str);

				      var data = google.visualization.arrayToDataTable(data_acquire_users.channel.data);
				      

				      var chart = new google.visualization.ColumnChart(document.getElementById('char_acquisition'));
				      chart.draw(data, data_acquire_users.options);

				}

			});
	  	}
	  	
	  	function kFormatter(num) {
		    return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
		}
	    

		$(document).on('click','.card-traffic .tab-item',function(){

			if( !$(this).hasClass('active') ){
	  			$('.card-traffic .tab-item').removeClass('active');
	  			$(this).addClass('active');
	  			

	  			var str = '', key = $(this).data('key');

		      for (var i = 0; i < data_acquire_users[key].legend.length; i++) {
		      	str += '<div class="acquisition_item"><span style="background:'+data_acquire_users[key].colors[i]+'"></span> '+data_acquire_users[key].legend[i]+'</div>'
		      };

		      $('#char_acquisition_legend').html(str);

		      var data = google.visualization.arrayToDataTable(data_acquire_users[key].data);
		      

		      var chart = new google.visualization.ColumnChart(document.getElementById('char_acquisition'));
		      chart.draw(data, data_acquire_users.options);


	  		}

		});

	  	$(document).on('click','.card-audience .tab-item',function(){
	  		if( !$(this).hasClass('active') ){
	  			$('#char_audience').attr('class',$(this).data('chart'));
	  			$('.card-audience .tab-item').removeClass('active');
	  			$(this).addClass('active');
	    		window.data_audience_current = $(this).data('key');

	    		drawChart(true);
	  		}
	  	});
  	});
</script>