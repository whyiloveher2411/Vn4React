<?php 



$dataGoogle = multiple_threads_request([



	'1day' => get_url_google_analytics(

		'https://www.googleapis.com/analytics/v3/data/ga',

		$webpropertie_id,

		'ga:1dayUsers',

		['ga:date'],

		$access_token,

		$start_date,

		$end_date,

		['max-results'=>'10000']

	),







	'7day' => get_url_google_analytics(

		'https://www.googleapis.com/analytics/v3/data/ga',

		$webpropertie_id,

		'ga:7dayUsers',

		['ga:date'],

		$access_token,

		$start_date,

		$end_date,

		['max-results'=>'10000']

	),



	'14day' => get_url_google_analytics(

		'https://www.googleapis.com/analytics/v3/data/ga',

		$webpropertie_id,

		'ga:14dayUsers',

		['ga:date'],

		$access_token,

		$start_date,

		$end_date,

		['max-results'=>'10000']

	),



	'28day' => get_url_google_analytics(

		'https://www.googleapis.com/analytics/v3/data/ga',

		$webpropertie_id,

		'ga:28dayUsers',

		['ga:date'],

		$access_token,

		$start_date,

		$end_date,

		['max-results'=>'10000']

	),





]);



$max_length = count($dataGoogle['1day']['rows']) - 1;



?>





<style>

	.day_item{

		text-align: left;

	}

	.day_item .check_box{

		display: inline-block;

	    height: 35px;

	    line-height: 27px;

	    margin: 10px;

	    background: #f0f0f0;

	    padding: 5px;

	    box-sizing: border-box;

	    border-radius: 5px 5px 0 0;

	}

	.day_item span{

		position: relative;

	    width: 13px;

	    height: 13px;

	    display: inline-block;

	    border: 1px solid #c6c6c6;

	    margin: 5px 3px -2px 5px;

	}

	.day_item .check_box.active span:after{



		background-color: transparent;

	    content: url("{!!plugin_asset($plugin->key_word)!!}/img/checkmark.png");

	    display: inherit;

	    position: absolute;

	    z-index: 111;

	    width: 13px;

	    height: 13px;

	    display: inline-block;

        left: -5px;

		top: -5px;

	}

	.total_active{



	}

	.total_active .total_item{

	    display: inline-block;

	    float: left;

	    width: 25%;

	    text-align: left;

	    padding: 20px;

	    border-right: 1px solid #ddd;

	}

	.total_item p{

		font-size: 12px;

	    color: rgb(34, 34, 34);

	}

	.total_item h2{

		font-size: 24px;

		margin:  10px 0 5px 0;

		color: rgb(34, 34, 34);

	}

	.total_item span{

		font-size: 11px;

		color: rgb(137, 137, 137);

	}



</style>



<div class="day_item">

	<a class="check_box active" data-index=0 style="border-bottom: 3px solid #046B97;" href="#"><span></span> 1 Day Active Users</a>

	<a class="check_box" data-index=1 style="border-bottom: 3px solid #058DC7;" href="#"><span></span> 7 Day Active Users</a>

	<a class="check_box" data-index=2 style="border-bottom: 3px solid #69BBDD;" href="#"><span></span> 14 Day Active Users</a>

	<a class="check_box" data-index=3 style="border-bottom: 3px solid #C0E2F1;" href="#"><span></span> 28 Day Active Users</a>



</div>

<div id="chart_current" class="chart_area" style="width:100%;"></div>

<div style="clear: both;"></div>

<div class="total_active">

	<div class="total_item">

		<p>1 Day Active Users</p>

		<h2>{!!number_format($dataGoogle['1day']['rows'][$max_length][1])!!}</h2>

		<span>% of Total: 100.00% ({!!number_format($dataGoogle['1day']['rows'][$max_length][1])!!})</span>

	</div>

	<div class="total_item">

		<p>7 Day Active Users</p>

		<h2>{!!number_format($dataGoogle['7day']['rows'][$max_length][1])!!}</h2>

		<span>% of Total: 100.00% ({!!number_format($dataGoogle['7day']['rows'][$max_length][1])!!})</span>

	</div>

	<div class="total_item">

		<p>14 Day Active Users</p>

		<h2>{!!number_format($dataGoogle['14day']['rows'][$max_length][1])!!}</h2>

		<span>% of Total: 100.00% ({!!number_format($dataGoogle['14day']['rows'][$max_length][1])!!})</span>

	</div>

	<div class="total_item" style="border-right: none;">

		<p>28 Day Active Users</p>

		<h2>{!!number_format($dataGoogle['28day']['rows'][$max_length][1])!!}</h2>

		<span>% of Total: 100.00% ({!!number_format($dataGoogle['28day']['rows'][$max_length][1])!!})</span>

	</div>
	<div style="clear: both;"></div>
</div>



<script type="text/javascript">



	google.charts.load('current', {'packages':['corechart']});

	google.charts.setOnLoadCallback(drawChart);



	  function drawChart() {

	     var data = google.visualization.arrayToDataTable([

	      [{type: 'date', label: 'Date'}, {type:'number',label:'1 Day Active Users'}],

	      @foreach($dataGoogle['1day']['rows'] as $k => $v)

	      [{v:new Date('{!!date("M d, Y", strtotime($v[0]))!!}'),f:'{!!date("l, F d, Y", strtotime($v[0]))!!}'},  {!!$v[1]!!}],

	      @endforeach

	    ]);



	    window.options = {

	      title: '',

	      colors:['#046B97','#058DC7','#69BBDD','#C0E2F1'],

		  chartArea:{left:15,right:15},

		  tooltip:{showColorCode:true},

		  pointSize:6,

		  lineWidth:1,

		  height:300,

		  focusTarget:'category',

			series: {

	          0: {

	              areaOpacity: 0

	          }

	        },



    		@if( $max_length > 53 )

		  pointsVisible:false,

		  @endif

	      hAxis: {title: '', format:'MMMM dd, yyyy', gridlines: {count:4, color: 'transparent'}},

	      vAxis: { textPosition: 'in',  minValue: 0,gridlines: {count:2,color: '#f1f1f1'}},

	    };



		var chart = new google.visualization.LineChart(document.getElementById('chart_current'));

	    chart.draw(data, options);

	  }





	  <?php 

	  	$time = [];

	   ?>



	window.data_color =  ['#046B97','#058DC7','#69BBDD','#C0E2F1'];

	window.data_chuan = [

		{

			title:'1 Day Active Users',

			data:[

			@foreach($dataGoogle['1day']['rows'] as $k => $v)

			<?php 

				$time[] = '{v:new Date("'.date("M d, Y", strtotime($v[0])).'"),f:"'.date("l, F d, Y", strtotime($v[0])).'"}';

			 ?>

			{!!$v[1]!!},

			@endforeach

			]



		},

		{

			title:'7 Day Active Users',

			data:[

			@foreach($dataGoogle['7day']['rows'] as $k => $v)

			{!!$v[1]!!},

			@endforeach

			]

		},

		{

			title:'14 Day Active Users',

			data:[

			@foreach($dataGoogle['14day']['rows'] as $k => $v)

			{!!$v[1]!!},

			@endforeach

			]

		},

		{

			title:'28 Day Active Users',

			data:[

			@foreach($dataGoogle['28day']['rows'] as $k => $v)

			{!!$v[1]!!},

			@endforeach

			]

		}

	];



	window.data_time = [{!!implode(',',$time)!!}];





	

	$('.check_box').click(function(event){

		

		event.preventDefault();



		$(this).toggleClass('active');



		var data_import = [];



		$('.check_box.active').each(function(index,el){



			data_import.push($(el).data('index'));

		});





		var data = new google.visualization.DataTable();

        data.addColumn('date', 'Date');



        var data_rows = [];

        var colors = [];





        for (var i = 0; i < data_import.length; i++) {



        	data.addColumn('number',data_chuan[data_import[i]*1].title);



        	colors[i] = data_color[data_import[i]*1];

        	for (var j = 0; j < data_chuan[data_import[i]].data.length; j++) {



        		if( !data_rows[j] ) data_rows[j] = [data_time[j]];

        		data_rows[j].push(data_chuan[data_import[i]].data[j]);



        	}



        }



        data.addRows(data_rows);



		var chart = new google.visualization.LineChart(document.getElementById('chart_current'));

	    chart.draw(data, options);

        











	});



</script>