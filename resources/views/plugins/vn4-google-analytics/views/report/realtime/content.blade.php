
<?php

$data = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:'.$webpropertie_id.'&dimensions=rt:deviceCategory,rt:pageTitle,rt:pagePath&metrics=rt:activeUsers&sort=-rt:activeUsers&access_token='.$access_token),true);


$total = $data['totalsForAllResults']['rt:activeUsers'];

$rt_device_color = [
            'DESKTOP'=>'#ed561b',
            'MOBILE'=>'#50b432',
            'TABLET'=>'#058dc7',
          ];

$rt_device = [];
$rt_page = [];
$rt_page_title = [];

foreach ($data['rows'] as $key => $value) {

  if( !isset($rt_device[$value[0]]) ) $rt_device[$value[0]] = 0;

  $rt_device[$value[0]] += $value[3];

  if( !isset($rt_page[$value[2]]) ) $rt_page[$value[2]] = 0;
  $rt_page[$value[2]] += $value[3];
  $rt_page_title[$value[2]] = $value[1];

}
arsort($rt_device);
arsort($rt_page);

?>
	<script type="text/javascript">
    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);

    function drawTable() {
      
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Active Page');
      data.addColumn('string', 'Page Title');
      data.addColumn('number', '');
      data.addColumn('number', 'Active Users');
      data.addRows([
        @foreach($rt_page as $k => $v)


          <?php 
              $path = $k;
              $title = $rt_page_title[$k];

              if( strlen($k) > 55 ){
                $path = mb_substr($k, 0,25).'...'.mb_substr($k, -25);
              }

              if( strlen($title) > 55 ){
                $title = mb_substr($title, 0,25).'...'.mb_substr($title, -25);
              }
           ?>
          ['{!!$path!!}','{!!$title!!}',  {!!$v!!},  {v: {!!number_format($v * 100 / $total)!!}, f: '{!! number_format($v * 100 / $total,2)!!}%'}],
        @endforeach
      ]);
      var table = new google.visualization.Table(document.getElementById('rt_path'));
      table.draw(data, {showRowNumber: true, width: '100%',height: '450px'});


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
         
        <?php 

         ?>

  			@foreach($rt_device as $k => $v )
  			<div style="color: #005c9c;display: inline-block;text-transform: uppercase;font-size: 11px;font-weight: bold;"><em style="display: inline-block;height: .8em;width: .8em;background-color: {!!$rt_device_color[$k]!!};"></em> {!!$k!!} @if( round ($v * 100 / $total) <= 4 ) [{!! round ($v * 100 / $total) !!}%] @endif</div>&nbsp;&nbsp;
  			@endforeach
  		</div>
  		<div style="height: 21px;border-radius: 4px;">
  			@foreach($rt_device as $k => $v )
  			<div class="device_item" style="
  				color: #fff;
  				display: inline-block;
  				font-weight: bold; 
  				float:left;
  				height:21px;
  				font-size: 11px;
  				text-shadow: #7f7f7f 0 -1px;
  				line-height:21px;
  				background-color: {!!$rt_device_color[$k]!!};
  				-webkit-box-reflect: below 1px -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(0.5,rgba(255,255,255,0)),to(rgba(255,255,255,.3)));
  				width:{!! $v * 100 / $total !!}%;">
  				@if( round ($v * 100 / $total) > 4 ) {!! round ($v * 100 / $total)!!}% @endif
  			</div>
  			@endforeach
  		</div>
		</div>

	</div>


  <div style="clear: both;"></div>

  <div style="width:100%">
    <h3 class="title-rl" style="text-align:left;"></h3>
    <div id="rt_path"></div>
  </div>

  <div style="clear: both;"></div>
