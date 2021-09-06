<?php 
    $view = isset($widget['data']['view']) && $widget['data']['view']? $widget['data']['view'] :'';
?>

@if( isset($setting) && $setting )


  <div class="form-group">
    <label>View</label>
    <select name="data[view]" class="form-control" style="width:auto;max-width: 100%;">
      <option @if( $view === 'right-now') selected="selected" @endif value="right-now">Right Now</option>
      <option @if( $view === 'top-keywords') selected="selected" @endif value="top-keywords">Top Keywords</option>
      <option @if( $view === 'pageviews') selected="selected" @endif value="pageviews">Pageviews</option>
      <option @if( $view === 'top-active-pages') selected="selected" @endif value="top-active-pages">Top Active Pages</option>
      <option @if( $view === 'traffic-medium') selected="selected" @endif value="traffic-medium">Traffic Medium</option>
      <option @if( $view === 'Browser') selected="selected" @endif value="browser">Browser</option>
      <option @if( $view === 'location') selected="selected" @endif value="location">Location</option>
      <option @if( $view === 'location-map') selected="selected" @endif value="location-map">Location Map</option>
      <option @if( $view === 'all') selected="selected" @endif value="all">All</option>
    </select>
  </div>

@else
<?php

$cache = Cache::get('widgets-admin-dashboard');

$plugin = $cache['google-analytics-realtime']['plugin'];

$access_code = $plugin->getMeta('access_token_first');

$webpropertie_id = $access_code['webpropertie_id'];

$access_token = get_access_token($plugin);

$r = request();
$filter = $r->get('filter',$plugin->getMeta('country'));
if( $filter == 'null' ) $filter = false;
$listAnalyticsWebsite = $plugin->getMeta('listAnalyticsWebsite');

add_action('vn4_footer',function() use ($filter, $plugin){
?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
    
      google.charts.load('current', {'packages':['table','corechart','geochart'], callback: function () {
        drawTable();
      }});
      window.charts = {};

      function drawTable( reload = false ) {

        $.ajax({
          url: '{!!route('google-analytics.report-item',['folder'=>'dashboard','view'=>'overview','filter'=>$filter])!!}',
          type:'POST',
          method:'POST',
          dataType:'Json',
          data:{
            _token:'{!!csrf_token()!!}',
          },
          success:function(data){
             if( data.error ){
              window.parent.show_message({icon:'fa-exclamation-circle',content: data.message, color:'#CE812E',title:'Google Analytics!'});

              clearInterval(setData);
              return;
            }
            let data_chart = data;
            //Active Users right now

          $('.rt_user_label').html(data_chart.rt_user.label);
          $('.rt_user_value').html(data_chart.rt_user.value);
          $('.rt_trafficType_label').html(data_chart.rt_trafficType.label);
          $('.rt_trafficType_value').html(data_chart.rt_trafficType.value);

          $('.counting.right_now').attr('data-count',data_chart.total);

          if( reload ){
            var options_30 = [];
          }else{
            var options_30 = {
              duration: 2500,
              startup: true
            };
          }

          var data = new google.visualization.DataTable();
          data.addColumn('string','mins ago');
          data.addColumn('number','Page Views');
          data.addColumn({type: 'string', role: 'tooltip'});
          data.addColumn({type: 'string', role: 'style'});
          data.addRows(data_chart.chart_30);
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
            animation: options_30
          };
      
        if( $('#chart_30').length ){

          if( !window.charts.chart_30 ){
            window.charts.chart_30 = new google.visualization.ColumnChart(document.getElementById('chart_30'));
          }
          window.charts.chart_30.draw(data, options);
        }

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Active Page');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows(data_chart.rt_pagePath);

        if( $('#rt_pagePath').length ){

          if( !window.charts.rt_pagePath ){
            window.charts.rt_pagePath = new google.visualization.Table(document.getElementById('rt_pagePath'));
          }

          window.charts.rt_pagePath.draw(data, {showRowNumber: true, allowHtml:true, width: '100%'});
        }



        // Traffic Source
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Medium');
        data.addColumn('string', 'Source');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows(data_chart.rt_source);
        if( $('#rt_source').length ){

          if( !window.charts.rt_source ){
            window.charts.rt_source = new google.visualization.Table(document.getElementById('rt_source'));
          }

          window.charts.rt_source.draw(data, {showRowNumber: true, width: '100%'});
        }

        // Keywords
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Keyword');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows(data_chart.rt_keyword);
        if( $('#rt_keyword').length ){

          if( !window.charts.rt_keyword ){
            window.charts.rt_keyword = new google.visualization.Table(document.getElementById('rt_keyword'));
          }

          window.charts.rt_keyword.draw(data, {showRowNumber: true, width: '100%'});
        }



        // Browser
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Browser');
        data.addColumn('number', '');
        data.addColumn('number', 'Active Users',{'width':'50px'});
        data.addRows(data_chart.rt_browser);
        if( $('#rt_browser').length ){

          if( !window.charts.rt_browser ){
            window.charts.rt_browser = new google.visualization.Table(document.getElementById('rt_browser'));
          }

          window.charts.rt_browser.draw(data, {showRowNumber: true, width: '100%'});
        }

        if( reload ){
          var time = 1000;
        }else{
          var time = 4000;
        }
        $('.counting.right_now').each(function() {
            var $this = $(this),
                countTo = $this.attr('data-count');
            
            $({ countNum: $this.text()}).animate({
              countNum: countTo
            },

            {
              duration: time,
              step: function() {
                $this.text(Math.floor(this.countNum));
              },
              complete: function() {
                $this.text(this.countNum);
              }

            });  
        });

       @if($filter)

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'City');
            data.addColumn('number', '');
            data.addColumn('number', 'Active Users',{'width':'50px'});
            data.addRows(data_chart.rt_location);

            if( $('#rt_location').length ){

              if( !window.charts.rt_location ){
                window.charts.rt_location = new google.visualization.Table(document.getElementById('rt_location'));
              }
              window.charts.rt_location.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});
            }
          


             var data = new google.visualization.DataTable();
              data.addColumn('number', 'Lat');                                
              data.addColumn('number', 'Long');
              data.addColumn('string', 'City'); 
              data.addColumn('number', 'Active Users'); 
             data.addColumn({type:'string', role:'tooltip',p:{html:true}});                        

            data.addRows(data_chart.rt_country);

            var opts = {
              region: data_chart.region,
              displayMode: 'markers',
              backgroundColor: 'rgb(234, 247, 254)',
              defaultColor: 'rgb(227, 123, 51)',
              legend:'none',
              animation: {
                  duration: 1000,
                  easing: 'out',
              },
              // legend:{textStyle: {color: 'blue', bold:true, fontSize: 16}},
              tooltip: {isHtml: true},
              sizeAxis: {minValue: 0,  maxSize: 22},
              colorAxis: {colors: ['rgb(227, 123, 51)','rgb(227, 123, 51)']}
            };
            
            if( $('#rt_country').length ){


              if( !window.charts.rt_country ){
                window.charts.rt_country = new google.visualization.GeoChart(document.getElementById('rt_country'));
              }

              google.visualization.events.addListener(window.charts.rt_country, 'ready', function(){
                var body = document.body,

                html = document.documentElement;

                var height = $('.right_col').height();

                document.body.style.height = height + 'px';

                $('#iframe-dashboard',window.parent.document).css({'height': height+'px'});
              });

              window.charts.rt_country.draw(data, opts);
             
            }
        @else
         
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Country');
              data.addColumn('number', '');
              data.addColumn('number', 'Active Users',{'width':'50px'});
              data.addRows(data_chart.rt_location);
            if( $('#rt_location').length ){

              if( !window.charts.rt_location ){
                window.charts.rt_location = new google.visualization.Table(document.getElementById('rt_location'));
              }
              window.charts.rt_location.draw(data, {showRowNumber: true,allowHtml:true, width: '100%'});
            }
            
            if( $('#rt_country').length ){

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Country');
            data.addColumn('number', 'Active Users');
            data.addRows(data_chart.rt_country);
            var options = {
              legend:'none',
              backgroundColor: 'rgb(234, 247, 254)',
            };
            function myClickHandler(){
                var selection = window.charts.rt_country.getSelection();

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
              
              if( !window.charts.rt_country ){
                window.charts.rt_country = new google.visualization.GeoChart(document.getElementById('rt_country'));
              }
              google.visualization.events.addListener(window.charts.rt_country, 'select', myClickHandler);

              google.visualization.events.addListener(window.charts.rt_country, 'ready', function(){
                  var body = document.body,

                  html = document.documentElement;

                  var height = $('.right_col').height();

                  document.body.style.height = height + 'px';

                  $('#iframe-dashboard',window.parent.document).css({'height': height+'px'});
              });

              window.charts.rt_country.draw(data, options);
            }
          @endif
          }    
        });

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

       window.setData = setInterval(function() {
          drawTable(true);
       }, 10000);

     });
    </script>
    <?php 
},'dashboard-google-anlytics',true);
?>

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
          right: 70px;
          top: 6px;
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
        .device_item{
          color: #fff;
          display: inline-block;
          font-weight: bold; 
          float:left;
          height:21px;
          font-size: 11px;
          text-shadow: #7f7f7f 0 -1px;
          line-height:21px;
          -webkit-box-reflect: below 1px -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(0.5,rgba(255,255,255,0)),to(rgba(255,255,255,.3)));
        }
        .google-visualization-table-seq{
          width: 30px;
          text-align: center;
        }
      </style>
    <!--   <div class="outer-title" style="position: absolute;top: 5px;color: #4a4a4a;">
          <h2>Google Analytics</h2>
      </div>
    <br> -->
   <!--  <select id="change_website">
      @foreach($listAnalyticsWebsite as $w)
      <option value="{!!$w[0]!!}" @if($w[0] === $webpropertie_id) selected="selected" @endif > {!!$w[1]!!} </option>
      @endforeach
    </select> -->
    
    @if( $view === 'all' )
    <div class="column-left" style="width: 32.999%;text-align: center;display: inline-block;float: left;box-sizing: border-box;padding:0 5px 0 0; ">

      <div class="card">
        <div style="font-size: 200%;padding-top:20px;">Right now</div>
        <span class="counting right_now" data-count="" style="font-size: 75px;" id="total_">0</span>
        <div style="font-size: 82%;">active users on site</div>
        
        <div class="processing" style="padding-top: 25px">
          <div class="rt_user_label" style="text-align: left;margin-bottom:3px;"></div>
          <div class="rt_user_value" style="height: 21px;border-radius: 4px;"></div>
          <br>


          <div class="rt_trafficType_label" style="text-align: left;margin-bottom:3px;"></div>
          <div class="rt_trafficType_value" style="height: 21px;border-radius: 4px;"></div>
          <br>
          <small style="font-size: 12px;">* Data updates continuously and each pageview</small>
        </div>
      </div>


      <div class="card">
        <h3 class="title-rl" style="text-align:left;">Top Keywords:</h3>
        <div id="rt_keyword"></div>
      </div>

      <div class="card">
        <h3 class="title-rl" style="text-align:left;">Traffic Medium:</h3>
        <div id="rt_source"></div>
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
        <div id="rt_country"  style="height: 450px;width: 100%;"></div>
      </div>

    </div>
    @else
      @if( $view === 'right-now' )
        <div style="text-align: center;">
          <div style="font-size: 200%;padding-top:20px;">Right now</div>
          <span class="counting right_now" data-count="" style="font-size: 75px;" id="total_">0</span>
          <div style="font-size: 82%;">active users on site</div>
          
          <div class="processing" style="padding-top: 25px">
            <div class="rt_user_label" style="text-align: left;margin-bottom:3px;"></div>
            <div class="rt_user_value" style="height: 21px;border-radius: 4px;"></div>
            <br>


            <div class="rt_trafficType_label" style="text-align: left;margin-bottom:3px;"></div>
            <div class="rt_trafficType_value" style="height: 21px;border-radius: 4px;"></div>
            <br>
            <small style="font-size: 12px;">* Data updates continuously and each pageview</small>
          </div>
        </div>
        @endif
      
        @if( $view === 'top-keywords' )
          <div class="widget-heading"><h2>Top Keywords:</h2></div>
          <div id="rt_keyword"></div>
        @endif
        
        @if( $view === 'traffic-medium' )
          <div class="widget-heading"><h2>Traffic Medium:</h2></div>
          <div id="rt_source"></div>
        @endif
    
        @if( $view === 'browser' )
          <div class="widget-heading"><h2>Browser:</h2></div>
          <div id="rt_browser"></div>
        @endif
        
        @if( $view === 'location' )
          <div class="widget-heading"><h2>Location:</h2></div>
          <div id="rt_location"></div>
        @endif
    

        @if( $view === 'pageviews' )
          <div class="widget-heading"><h2>Pageviews:</h2></div>
          <div id="chart_30" style="margin-bottom:5px;"></div>
        @endif
        
        @if( $view === 'top-active-pages' )
          <div class="widget-heading"><h2>Top Active Pages:</h2></div>
          <div id="rt_pagePath" style="margin-bottom:5px;max-height: 300px;overflow: auto;"></div>
        @endif
        
        @if( $view === 'location-map' )
          @if( $filter )
            <a href="?filter=null" style="cursor:pointer; display: inline-block;width: auto; background: #4d90fe; font-size: 13px; margin: 0 3px 0 0; padding: 7px 10px;-webkit-border-radius: 2px;color: white;background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed); line-height: 1em;white-space: nowrap;position: absolute;z-index: 1;">COUNTRY: {!!$filter!!} <strong style="color:white;">X</strong></a>
          @endif
          <div id="rt_country"  style="height: auto;width: 100%;"></div>
        @endif
    @endif
@endif