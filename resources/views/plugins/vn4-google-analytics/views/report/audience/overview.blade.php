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
$dataGoogle = multiple_threads_request(
	[
		'dataTotal'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users,ga:newUsers,ga:sessions,ga:bounceRate,ga:avgSessionDuration,ga:pageviews,ga:pageviewsPerSession,ga:sessionsPerUser',
		[],
		$access_token,
		$start_date,
		$end_date
		),
		'dataDetail'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users,ga:newUsers,ga:sessions,ga:bounceRate,ga:avgSessionDuration,ga:pageviews,ga:pageviewsPerSession,ga:sessionsPerUser',
		$dimensions,
		$access_token,
		$start_date,
		$end_date,
		['max-results'=>'10000']
		),
		'userVisitor'=>get_url_google_analytics(
		'https://www.googleapis.com/analytics/v3/data/ga',
		$webpropertie_id,
		'ga:users',
		['ga:userType'],
		$access_token,
		$start_date,
		$end_date
		)
	]
);
$data = $dataGoogle['dataTotal'];

$data_total = [];

foreach ($data['rows'][0] as $k => $v) {
	if( !isset($data_total[$data['columnHeaders'][$k]['name']]) ) $data_total[$data['columnHeaders'][$k]['name']] = 0;
	$data_total[$data['columnHeaders'][$k]['name']] += $v;
}

$data = $dataGoogle['dataDetail'];

$max_length = count($data['rows']) - 1;

$data_returning_visitor = $dataGoogle['userVisitor'];

?>


<style>
	
</style>

<div class="modeSelector">
  <a href="javascript:void(0)" data-key="ga:month">Month</a>
  <a href="javascript:void(0)" data-key="ga:week">Week</a>
  <a href="javascript:void(0)" data-key="ga:date">Day</a>
  <a href="javascript:void(0)" data-key="ga:hour">Hourly</a>
</div>

<div id="chart_current" class="chart_area" style="width:100%;"></div>
<div id="chart_current_temp" class="chart_area" style="width:100%;visibility: hidden;position: absolute;"></div>

	<table style="width:100%">
		<tr>
			<td>
				<div class="metrics_frame" onClick="change_chart(this,'ga:users')">
					<div class="metrics_title">Users</div>
					<div class="metrics_total">{!!number_format($data_total['ga:users'])!!}</div>
					<div class="chart_area" id="ga_users"></div>
				</div>

				<div class="metrics_frame" onClick="change_chart(this,'ga:newUsers')">
					<div class="metrics_title">New Users</div>
					<div class="metrics_total">{!!number_format($data_total['ga:newUsers'])!!}</div>
					<div class="chart_area" id="ga_new_users"></div>
				</div>
				
				<div class="metrics_frame" onClick="change_chart(this,'ga:sessions')">
					<div class="metrics_title">Sessions</div>
					<div class="metrics_total">{!!number_format($data_total['ga:sessions'])!!}</div>
					<div class="chart_area" id="ga_sessions"></div>
				</div>
				
				

				<div class="metrics_frame" onClick="change_chart(this,'ga:sessionsPerUser')">
					<div class="metrics_title">Number of Sessions per User</div>
					<div class="metrics_total">{!!number_format($data_total['ga:sessionsPerUser'],2)!!}</div>
					<div class="chart_area" id="ga_number_of_sessions"></div>
				</div>

				<div class="metrics_frame" onClick="change_chart(this,'ga:pageviews')">
					<div class="metrics_title">Pageviews</div>
					<div class="metrics_total">{!!number_format($data_total['ga:pageviews'])!!}</div>
					<div class="chart_area" id="ga_pageviews"></div>
				</div>

				<div class="metrics_frame" onClick="change_chart(this,'ga:pageviewsPerSession')">
					<div class="metrics_title">Pages / Session</div>
					<div class="metrics_total">{!!number_format($data_total['ga:pageviewsPerSession'],2)!!}</div>
					<div class="chart_area" id="ga_pages_session"></div>
				</div>
				
				<?php 
					$time = number_format($data_total['ga:avgSessionDuration']);
					$hours = floor($time / 3600);
					$mins = floor($time / 60 % 60);
					$secs = floor($time % 60);

					$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
				 ?>
				<div class="metrics_frame" onClick="change_chart(this,'ga:avgSessionDuration')">
					<div class="metrics_title">Avg. Session Duration</div>
					<div class="metrics_total">{!!$timeFormat!!}</div>
					<div class="chart_area" id="ga_avg_session"></div>
				</div>

				<div class="metrics_frame" onClick="change_chart(this,'ga:bounceRate')">
					<div class="metrics_title">Bounce Rate</div>
					<div class="metrics_total">{!!number_format($data_total['ga:bounceRate'],2)!!}%</div>
					<div class="chart_area" id="ga_bounce_rate"></div>
				</div>
			</td>
			<td>
				<div id="ga_userType" style="width:365px;height:300px;">
					

				</div>
			</td>
		</tr>
	</table>
			
	<div class="dimension_summary">
		
		<div class="dimension_type" style="width: 30%;float: left;display: inline-block;">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<th class="">Demographics</th>
					</tr>
					<tr>
						<td>
							<ul>
								<li data-key="ga:language">Language</li>
								<li data-key="ga:country">Country</li>
								<li data-key="ga:city">City</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th class="">System</th>
					</tr>
					<tr>
						<td>
							<ul>
								<li data-key="ga:browser">Browser</li>
								<li data-key="ga:operatingSystem">Operating System</li>
								<li data-key="ga:networkLocation">Service Provider</li>
							</ul>
						</td>
					</tr>

					<tr>
						<th class="">Mobile</th>
					</tr>
					<tr>
						<td>
							<ul>
								<li data-device="mobile" data-key="ga:operatingSystem">Operating System</li>
								<li data-device="mobile" data-key="ga:networkLocation">Service Provider</li>
								<li data-device="mobile" data-key="ga:screenResolution">Screen Resolution</li>
							</ul>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<div id="dimension_result"  style="width: 69.999%;height: 360px;display: inline-block;padding: 0 20px;">
			
		</div>
		<div style="clear: both;"></div>

	</div>

 <script type="text/javascript">


  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  window.data_chuan = [];
  window.options_chuan = [];

  function drawChart() {

	@php
	 $add_aera_chart = function($title, $data,$index, $id_frame_img, $id_chart,$mode, $param = null) use ($end_date,$start_date, $__env,$max_length){ 
	 @endphp

	    var data = google.visualization.arrayToDataTable([
	      ['Date', '{!!$title!!}'],
	      @foreach($data['rows'] as $k => $v)
	      [{v:'',f:''},  {!!$v[$index]!!}],
	      @endforeach
	    ]);

	    var options = {
	      title: '',
	      colors:['rgb(5, 141, 199)'],
		  chartArea:{left:15,right:15},
		  tooltip:{showColorCode:true},
		  focusTarget:'category',
		  pointsVisible:false,
	      hAxis: {title: '', format:'MMMM dd, yyyy', gridlines: {count:4, color: 'transparent'}},
	      vAxis: {textPosition: 'out',  minValue: 0,gridlines: {count:2,color: 'transparent'}},
	    };

		var chart{!!$index!!} = new google.visualization.AreaChart(document.getElementById('{!!$id_chart!!}'));
	    chart{!!$index!!}.draw(data, options);

	    var node = document.createElement("img");
	    node.src = chart{!!$index!!}.getImageURI();
		document.getElementById("{!!$id_frame_img!!}").appendChild(node);

		options.title = '{!!$title!!}';
		options.pointSize = 8;
		options.lineWidth = 3;
		options.vAxis.gridlines.color = '#f1f1f1';
		options.vAxis.textPosition = 'in';
		@if( $max_length <= 53 )
		options.pointsVisible = true;
		@endif

		@if( isset($param['options']) )
		<?php $param['options'](); ?>
		@endif



	      @if( $mode === 'ga:hour' )
	      	options.hAxis.format = 'MMM dd yyyy, H:00';
			 window.data_chuan['{!!$id_frame_img!!}'] = google.visualization.arrayToDataTable([
	      		[{type: 'datetime', label: 'Date'}, '{!!$title!!}'],
				@if( isset($param['customData']) )
				  @foreach($data['rows'] as $k => $v)
  		   			[{v:new Date({!!date("Y,m - 1, d, G, i, s", strtotime($v[0].$v[1].'0000'))!!}),f:'{!!date("l, F d, Y H:00", strtotime($v[0].$v[1].'0000'))!!}'},  {!!$param['customData']($v[$index])!!}],
				  @endforeach
				@else
				   @foreach($data['rows'] as $k => $v)
			  		   [{v:new Date({!!date("Y,m - 1, d, G, i, s", strtotime($v[0].$v[1].'0000'))!!}),f:'{!!date("l, F d, Y H:00", strtotime($v[0].$v[1].'0000'))!!}'},  {!!$v[$index]!!}],
				   @endforeach
				@endif
	    	]);
	      @elseif( $mode === 'ga:date' )

	      	options.hAxis.gridlines.count = {!! $max_length !!};

			 window.data_chuan['{!!$id_frame_img!!}'] = google.visualization.arrayToDataTable([
	      		[{type: 'date', label: 'Date'}, '{!!$title!!}'],
		      @if( isset($param['customData']) )
			      @foreach($data['rows'] as $k => $v)
			      	[{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:'{!!date("l, F d, Y", strtotime($v[0]))!!}'},  {!!$param['customData']($v[$index])!!}],
			      @endforeach
		      @else
			      @foreach($data['rows'] as $k => $v)
			      [{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:'{!!date("l, F d, Y", strtotime($v[0]))!!}'},  {!!$v[$index]!!}],
			      @endforeach
		      @endif
	    	]);
	      @elseif( $mode === 'ga:week' )
	      	options.hAxis.format = '0';
			 window.data_chuan['{!!$id_frame_img!!}'] = google.visualization.arrayToDataTable([
      		['Date', '{!!$title!!}'],
      		  @if( isset($param['customData']) )
			      @foreach($data['rows'] as $k => $v)
			      	[{v:'{!!date("M d, Y", strtotime($v[0]))!!}',f:'{!!$v[0],' - Week ',$v[1]!!}'},  {!!$param['customData']($v[$index])!!}],
			      @endforeach
		      @else
			      @foreach($data['rows'] as $k => $v)
			      [{v:'{!!date("M d, Y", strtotime($v[0]))!!}',f:'{!!$v[0],' - Week ',$v[1]!!}'},  {!!$v[$index]!!}],
			      @endforeach
		      @endif
	    	]);
	      @else
			 window.data_chuan['{!!$id_frame_img!!}'] = google.visualization.arrayToDataTable([
      		['Date', '{!!$title!!}'],
	      	<?php 
	      		$count = count($data['rows']) - 1;
	      		$start_date = strtotime($start_date);
				$end_date = strtotime($end_date);
	      	 ?>
			@if( isset($param['customData']) )
				@foreach($data['rows'] as $k => $v)
					<?php 
						$first_day = strtotime($v[0].$v[1].'01');
						$last_day = strtotime("last day of this month",$first_day);

						if( $first_day < $start_date ) $first_day = $start_date;
						if( $last_day > $end_date ) $last_day = $end_date;
					 ?>
					[{v:'{!!date("M d, Y", strtotime($v[0]))!!}',f:'{!! date('M d, Y',$first_day),' - ', date('M d, Y',$last_day) !!}'},  {!!$param['customData']($v[$index])!!}],
				@endforeach
			@else
				@foreach($data['rows'] as $k => $v)
				<?php 
					$first_day = strtotime($v[0].$v[1].'01');
					$last_day = strtotime("last day of this month",$first_day);

					if( $first_day < $start_date ) $first_day = $start_date;
					if( $last_day > $end_date ) $last_day = $end_date;
				 ?>
				[{v:'{!!date("M d, Y", strtotime($v[0]))!!}',f:'{!! date('M d, Y',$first_day),' - ', date('M d, Y',$last_day) !!}'},  {!!$v[$index]!!}],
				@endforeach
			@endif
	    	]);
	      @endif


		options_chuan['{!!$id_frame_img!!}'] = options;

	    chart{!!$index!!}.draw(data_chuan['{!!$id_frame_img!!}'], options_chuan['{!!$id_frame_img!!}']);

    <?php
  		};

  		$data_chat_info = [
  			'ga:users'=>['Users',1,'ga_users',null],
  			'ga:newUsers'=>['New Users',2,'ga_new_users',null],
  			'ga:sessions'=>['Sessions',3,'ga_sessions',null],
  			'ga:sessionsPerUser'=>['Number of Sessions per User',8,'ga_number_of_sessions',null],
  			'ga:pageviews'=>['Pageviews',6,'ga_pageviews',null],
  			'ga:pageviewsPerSession'=>['Pages / Session',7,'ga_pages_session',null],
  			'ga:avgSessionDuration'=>['Avg. Session Duration',5,'ga_avg_session',['customData'=>function($data ){
  					$time = number_format($data);
					$hours = floor($time / 3600);
					$mins = floor($time / 60 % 60);
					$secs = floor($time % 60);
					$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
		      		return '{v:'.$data.',f:"'.$timeFormat.'"}';
  			}]],
  			'ga:bounceRate'=>['Bounce Rate',4,'ga_bounce_rate',[
  				'customData'=>function($data){
		      		return '{v:'.$data.',f:"'.number_format($data,2).'%"}';
  				},
  				
  			]],
  		];	

  		$active_chart = $r->get('chart');

  		if( !isset($data_chat_info[$active_chart]) ){
  			$active_chart = key($data_chat_info);
  		}

  		$index = [];

  		foreach ($data['columnHeaders'] as $k => $v) {
  			$index[$v['name']] = $k;
  		}

  		foreach ($data_chat_info as $key => $value) {

  			if( $active_chart === $key ){
	  			$add_aera_chart($value[0],$data,$index[$key],$value[2],'chart_current',$mode,$value[3]);
  			}else{
	  			$add_aera_chart($value[0],$data,$index[$key],$value[2],'chart_current_temp',$mode,$value[3]);
  			}
  		}

  	 ?>

  }


  function change_chart($this, active_chart){

      window.history.pushState("object or string", "Page",  replaceUrlParam(window.location.href, 'chart',active_chart));

  	var title = $this.querySelectorAll('.metrics_title')[0].innerText;
  	var key = $this.querySelectorAll('.chart_area')[0].getAttribute('id');

  	var chart = new google.visualization.AreaChart(document.getElementById('chart_current'));
	    chart.draw(data_chuan[key], options_chuan[key]);
  }

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChartuserType);

  function drawChartuserType() {

    var data = google.visualization.arrayToDataTable([
      ['User Type', 'User'],
      @foreach( $data_returning_visitor['rows'] as $k => $v )
      ['{!!$v[0]!!}',  {!!$v[1]!!} ],
      @endforeach
    ]);

    var options = {
      title: '',
      pieHole:1,
      slices: {
        0: { color: '#058dc7' },
        1: { color: '#50b432' }
      },
      tooltip: {textStyle: {fontSize: 10}},
      legend:{
      		position: 'top',

      	}
    };

    var chart = new google.visualization.PieChart(document.getElementById('ga_userType'));

    chart.draw(data, options);


     
  }
  window.data_detail = [];
	function change_chart_detail( $this ){

		if( data_detail[$this.data('key')+$this.data('device')] ){
			google.charts.load('current', {'packages':['table']});
			google.charts.setOnLoadCallback(function_change);
			$('.dimension_type li').removeClass('active');
			$this.addClass('active');

		 	function function_change(){

				var data = new google.visualization.DataTable();
			    data.addColumn('string', $this.text() );
			    data.addColumn('number', 'Users');
			    data.addColumn('number', '% Users');

			    data.addRows(data_detail[$this.data('key')+$this.data('device')]);

			    var table = new google.visualization.Table(document.getElementById('dimension_result'));
			    table.draw(data, {showRowNumber: true, allowHtml:true, width: '100%',maxHeight:'360px'});


	  			if( isInIframe ){
		          parent.hide_loading();
		        }
			        
			};
		}else{
			$.ajax({
	  			type:"POST",
	  			dataType:'Json',
	  			data:{
	  				start_date: '{!!$start_date!!}',
	  				end_date: '{!!$end_date!!}',
	  				_token:'{!!csrf_token()!!}',
	  				type:$this.data('key'),
	  				device_filter: $this.data('device'),
	  			},
	  			success:function(dataAjax){

	  				google.charts.load('current', {'packages':['table']});
					google.charts.setOnLoadCallback(function_change);
					$('.dimension_type li').removeClass('active');
					$this.addClass('active');

				 	function function_change(){

						var data = new google.visualization.DataTable();
					    data.addColumn('string', $this.text() );
					    data.addColumn('number', 'Users');
					    data.addColumn('number', '% Users');

					    data_detail[$this.data('key')+$this.data('device')] = dataAjax;

					    data.addRows(dataAjax);

					    var table = new google.visualization.Table(document.getElementById('dimension_result'));
					    table.draw(data, {showRowNumber: true, allowHtml:true, width: '100%',maxHeight:'360px'});


			  			if( isInIframe ){
				          parent.hide_loading();
				        }
					        
					};


	  			},
	  		});
		}
	}

  	$(window).load(function(){


  		$(document).on('click','.dimension_type li',function(){

  			if( isInIframe ){
  				parent.show_loading();
	        }

	        var url =   replaceUrlParam(window.location.href, 'chart_detail',$(this).data('key'));

	        if( $(this).data('device') ){
	         url =   replaceUrlParam(url, 'device',$(this).data('device'));
	        }else{
	         url =   replaceUrlParam(url, 'device','');
	        }

	        window.history.pushState("object or string", "Page",  url );

  			change_chart_detail($(this));

	  	});

  		<?php 
  			$chart_detail = $r->get('chart_detail');
  			$chart_detail_device = $r->get('device');
  		 ?>

  		 var chart_detail = '{!!$chart_detail!!}';
  		 var chart_detail_device = '{!!$chart_detail_device!!}';

  		 if( chart_detail && chart_detail_device &&  $('.dimension_type li[data-key="'+chart_detail+'"][data-device="'+chart_detail_device+'"]').length ){
  		 	$('.dimension_type li[data-key="'+chart_detail+'"][data-device="'+chart_detail_device+'"]').addClass('active');
  		 }else if( chart_detail  && $('.dimension_type li[data-key="'+chart_detail+'"]').length ){
  		 	$('.dimension_type li[data-key="'+chart_detail+'"]:eq(0)').addClass('active');
  		 }else{
 			$('.dimension_type li:eq(0)').addClass('active');
  		 }

	  	if( $('.dimension_type li.active').length ){
		  	setTimeout(function() {
		  		change_chart_detail($('.dimension_type li.active'));
			}, 10);  
	  	}



        $(document).on('click','.modeSelector a',function(){
              window.location.href = replaceUrlParam(window.location.href,'mode',$(this).data('key'));
        });

        $('.modeSelector a[data-key="{!!$mode!!}"]').addClass('active');

  	});

		


</script>