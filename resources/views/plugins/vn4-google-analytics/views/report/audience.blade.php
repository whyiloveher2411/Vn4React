<html>
  <head>
    <!--Load the AJAX API-->
     <link rel="stylesheet" href="{!!plugin_asset($plugin->key_word,'css/datepicker.css')!!}" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="{!!plugin_asset($plugin->key_word,'css/layout.css')!!}" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style type="text/css">
      *{
        font-family: Roboto, sans-serif;
        margin: 0;
        padding: 0;
        color: #222;
        text-decoration: none;
        outline: none;
        box-sizing: border-box;
      }
      
      body{
        background: white;
        overflow-x: hidden;
        text-align: left;
      }
      .datepicker{
        position: relative !important;
      }
      #widgetCalendar {
          background: #f7f7f7;
          border: 1px solid #dedede;
          padding: 0 165px 0 15px;
          right: 0;
          left: auto;
          border-radius: 5px;
          border-top-right-radius: none;
          width: auto;
      }
      .datepickerNotInMonth{
        opacity: 0;
      }
      .datepickerDoW th{
        border-bottom: #ccc solid 1px;
      }
      .datepickerDoW th:not(:first-child) span{
        font-weight: bold;
      }
      .table_chart .row1 td{
          vertical-align: top;
      }
      div.datepicker table{
        background: white;
      }
      .datepickerSpace{
        background: #f7f7f7;
      }
      .datepickerSpace div{
        width: 4px;
      }
      .datepickerViewDays>thead>tr:first-child{
        background: #dddddd;
      }
      .custom_picker{
        position: absolute;
        display: inline-block;
        top: 10px;
        z-index: 999;
        right: 25px;
        width: 141px;
        text-align: left;
      }
      .select_range{
          display: block;
          margin-bottom: 5px;
          font-size: 11px;
          font-weight: bold;
      }
      .select_range select{
        display: inline-block;
        width: 70px;
        font-size: 11px;
      }
      .picker_apply{
        display: inline-block;
        padding: 2px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        cursor: pointer;
      }
      .picker_apply:hover,.picker_apply:active,.picker_apply:visited{
        background: #dedede;
      }
      div.datepicker tbody th{
        text-align: center;
      }
      div.datepicker table td {
          text-align: right;
          border: 1px solid #fbfbfb;
          text-align: center;
      }
      tbody.datepickerDays td.datepickerSelected{
          background: #0077cc;
      }
      tbody.datepickerDays td.datepickerSelected a, tbody.datepickerDays td.datepickerSelected span{
          color: white !important;
      }
      .google-visualization-table-td, .google-visualization-table-th{
        height: 29px;
      }
      .datepickerViewDays a, .datepickerViewDays span{
        font-size: 11px;
      }
      .datepickerToday{
        background: #8b8b8b;
      }
      div.datepicker  .datepickerToday span{
        color: white;
      }
      .google-visualization-table-table a{
        color: #005c9c;
        font-size:12.4px;
      }
      .google-visualization-table-table a:hover{
        text-decoration: underline;
      }
      .google-visualization-table-table tr:nth-child(odd){
        background: rgb(248, 248, 248);
      }
      .google-visualization-table-table tr:hover,.google-visualization-table-table tr:hover td{
        background-color: #d6e9f8 !important;
      }

      .google-visualization-table-table:not(.not_style)  th{
        text-align: left;
      }
      .google-visualization-table-table td:last-child ,.google-visualization-table-table td:nth-last-child(2){
        width:29px;
       background: rgb(243, 243, 243);
      }
      .google-visualization-table-table tr:nth-child(odd) td:last-child,.google-visualization-table-table  tr:nth-child(odd) td:nth-last-child(2){
       background: rgb(234, 234, 234);
      }
      .google-visualization-table-table:not(.not_style) td{
        border: solid #ddd;
        border-width: 0 1px 1px 0;
      }
      .title-rl{
        font-size: 17px;
        color: #005c9c;
        border-bottom: 2px solid #666;
      }
      .device_item:first-child{
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
      }
      .device_item{
        border-right: 1px solid white;
        box-sizing: border-box;
      }
      .device_item:last-child{
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
      }
      .datepickerFuture{
          pointer-events: none;
          opacity: .4;
      }
      .google-visualization-tooltip-item-list .google-visualization-tooltip-item:first-child{

      }
      .google-visualization-tooltip-item-list{
        margin: 10px 0;
      }
      .google-visualization-tooltip-item{
        margin: 5px 0 !important;
      }
      .icon-refesh{
        position: absolute;
        right: 0;
        top: 4px;
        z-index: 999;
        height: 20px;

      }
      .metrics_frame{
        display: inline-block;
          margin: 15px 0 10px 10px;
        width: 180px;
        cursor: pointer;
        border-bottom: 0 none;
          border-right: 1px solid #cbcbcb;
          text-align: left;
      }
      img{
        max-width: 100%;
      }
      .metrics_title{
          color: #222;
          display: block;
          font-size: 13px;
          font-weight: normal;
      }
      .metrics_total{
        color: #222;
          font-size: 24px;
          max-width: 160px;
          min-width: 65px;
          word-wrap: break-word;
      }
      .chart_area{
        border-color: #fff;
          border-style: solid;
          border-width: 1px 2px 2px 1px;
          cursor: pointer;
          float: left;
          margin-right: 10px;
          padding-bottom: 3px;

      }
      
      .chart_area text{
        font-size: 11px;
      }
      .metrics_circle{
          min-width: 400px;

      }
      .dimension_type{

      }
      .dimension_type tr{
        font-size: 12px;
      }
      .dimension_type td{

      }
      .dimension_type th{
          border-bottom: 1px solid #666;
          padding: 12px 6px 3px;
          text-align: left;
          font-weight: bold;
      }
      .dimension_type ul{

      }
      .dimension_type li{
        position: relative;
          color: #058dc7;
          cursor: pointer;
          list-style-type: none;
          padding: 8px 6px;
      }
      .dimension_type li.active{
          background: #e0eff6; 
        color: #000;
      }
      .dimension_type li.active:after{
        content: "";
        display: inline-block;
        position: absolute;
        background: url("{!!plugin_asset($plugin->key_word,'images/nav_child_closed_ltr.png')!!}") center center;
          width: 7px;
          height: 7px;
          right: 5px;
          top: 11px;
      }

      #dimension_result .google-visualization-table-seq{
        width: 20px;
      }

      #dimension_result tr td:last-child{
        text-align: left;
      }
      #dimension_result th{
        font-weight: bold;
        border-bottom: 1px solid #666;
      }

      .google-visualization-table-table th:nth-last-child(2), .google-visualization-table-table td:nth-last-child(2){
        width: 50px !important;
      }
        .google-visualization-table-table th:last-child{
          width: 160px;
        }
      #dimension_result .percent_user{
          min-width: 1px;
        display: inline;
          height: 1.17em;
          float: left;
          margin: 0 10px 0 0;
            background-color: #058dc7;
      }
      .modeSelector{
        text-align: right;
        position: absolute;
        z-index: 10;
        right: 25px;
        top: 30px;
      }
      .modeSelector a{
        display: inline-block;
        height: 31px;
        border-color: #ccc;
        background-color: #f3f3f3;
        padding: 8px 7px;
        font: bold 11px 'Roboto',sans-serif;
        color: #444;
        border: 1px solid #ccc;
        background-image: -webkit-linear-gradient(top,#fefefe,#f3f3f3);
        background-image: -moz-linear-gradient(top,#fefefe,#f3f3f3);
        cursor: pointer;
        min-width: 18px;
        text-align: center;
        float: right;
        border-left-width: 0px;
      }
      .modeSelector a:last-child{
      border-left-width: 1px;
      }
      .modeSelector a:hover, .modeSelector a:active, .modeSelector a:visited {
        border-color: #ccc;
        box-shadow: inset 0px 1px 2px rgba(0,0,0,.2);
        color: #222;
      }
      .modeSelector a.active{
      background-color: #dfdfdf;
      background-image: -webkit-linear-gradient(top,#f0f0f0,#dfdfdf);
      background-image: -moz-linear-gradient(top,#f0f0f0,#dfdfdf);
      border-color: #ccc;
      box-shadow: inset 0px 1px 5px rgba(0,0,0,.3);
      color: #222;
      }
      
    </style>
  </head>
<?php 
    
    $start_date = $r->get('start-date',date('Y-m-d', strtotime(' -7 day')));
    $end_date = $r->get('end-date',date('Y-m-d', strtotime(' -1 day')));

  
 ?>
<body>
    <div id="widget" style="z-index: 11;float:right;margin-right:25px;">
        <div id="widgetField">
            <span>{!!date("d F, Y", strtotime($start_date))!!} - {!!date("d F, Y", strtotime($end_date))!!}</span>
            <a href="#">Select date range</a>
        </div>
        <div id="widgetCalendar" style="visibility: hidden;">

          <div class="custom_picker">
            <label class="select_range">Date Range: 
                <select name="" id="select_range">
                  <option value="custom">Custom</option>
                  <option value="today">Today</option>
                  <option value="yesterday">Yesterday</option>
                  <option value="lastweek">Last week</option>
                  <option value="latmonth">Last month</option>
                  <option value="last7days">Last 7 days</option>
                  <option value="last30days">Last 30 days</option>
                </select>
            </label>
            <span class="picker_apply">Apply</span>
          </div>
          
        </div>

    </div>


   
    <script type="text/javascript" src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>
    <script type="text/javascript" src="{!!plugin_asset($plugin->key_word,'js/datepicker.js')!!}"></script>
    <script type="text/javascript" src="{!!plugin_asset($plugin->key_word,'js/eye.js')!!}"></script>


    <a href="javascript:void(0)" onClick="isInIframe?parent.show_loading('Refresh Data'):'';window.location.reload()"><img src="{!!plugin_asset($plugin->key_word,'img/refresh_icon.svg')!!}" class="icon-refesh" alt=""></a>
  	{!!view_plugin($plugin, 'views.report.'.$folder.'.'.$view,['r'=>$r,'start_date'=>$start_date,'end_date'=>$end_date,'access_code'=>$access_code,'webpropertie_id'=>$webpropertie_id,'access_token'=>$access_token])!!}
    
    <script>

      function replaceUrlParam(url, paramName, paramValue){
        if(paramValue == null)
          paramValue = '';
        var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
        if(url.search(pattern)>=0){
          return url.replace(pattern,'$1' + paramValue + '$2');
        }
        return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue ;
      }


      var isInIframe = (window.location != window.parent.location) ? true : false;

      document.addEventListener("DOMContentLoaded", function(event) {
          // - Code to execute when all DOM content is loaded. 
        if( isInIframe ){
          parent.hide_loading();
        }
          // parent.$('body').css({'background':'red'});
          // - including fonts, images, etc.
      });

      // function closeIt()
      // {
      //   if( isInIframe ){
      //     parent.show_loading();
      //   }
      // }
      // window.onbeforeunload = closeIt;

    </script>
    <script>

        Date.prototype.addDays2 = function(days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }

        Date.prototype.addMonths2 = function (value) {
            var n = this.getDate();
            this.setDate(1);
            this.setMonth(this.getMonth() + value);
            this.setDate(Math.min(n, this.getDaysInMonth()));
            return this;
        };




        window.rangeDate = [new Date('{!!$start_date!!}'),new Date( '{!!$end_date!!}' )];

        var initLayout = function() {
            
            var now3 = rangeDate[0];
            var now4 = rangeDate[1];
            ddatePicker = $('#widgetCalendar').DatePicker({
                flat: true,
                format: 'd B, Y',
                // format: 'Y-m-d',
                current: new Date('{!!$start_date!!}'),
                date: [new Date(now3), new Date(now4)],
                calendars: 3,
                mode: 'range',
                starts: 1,
                onChange: function(formated) {
                    $('#select_range').val('custom');

                    if( formated.length == 2){
                        for (var i = 0; i < formated.length; i++) {
                            var date = new Date(formated[i]);
                            // var y = date.getFullYear(),m = date.getMonth()+1,d = date.getDate();
                            // m = m<10?'0'+m:m;
                            // d = d<10?'0'+d:d;
                            // rangeDate[i] = y+'-'+m+'-'+d;
                            rangeDate[i] = date;
                        };
                    }
                    $('#widgetField span').get(0).innerHTML = formated.join(' - ');
                }
            });
            var state = false;
            $("#widgetCalendar").click(function(event){
                event.stopPropagation();
                return false;
            });
            $('#widgetField>a').bind('click', function(event){
                event.stopPropagation();

                if( !state ){
                  $('#widgetCalendar').css({'visibility':'initial'});
                }
                $('#widgetCalendar').stop().animate({height: state ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500, function(){

                  if( !state ){
                    $('#widgetCalendar').css({'visibility':'hidden'});
                  }

                });
                state = !state;
                return false;
            });

            $('body').click(function(){
              event.stopPropagation();
              $('#widgetCalendar').stop().animate({height: 0}, 500, function(){
                  state = false;
                  $('#widgetCalendar').css({'visibility':'hidden'});
              });
              state = false;
              return false;
            });


            $('.picker_apply').click(function(){
              var url = window.location.href;
              url = url.replace('#','');


              var y = rangeDate[0].getFullYear(),m = rangeDate[0].getMonth()+1,d = rangeDate[0].getDate();
                  m = m<10?'0'+m:m;
                  d = d<10?'0'+d:d;
                  var firstDay = y+'-'+m+'-'+d;

              var y = rangeDate[1].getFullYear(),m = rangeDate[1].getMonth()+1,d = rangeDate[1].getDate();
                  m = m<10?'0'+m:m;
                  d = d<10?'0'+d:d;
                  var lastDay = y+'-'+m+'-'+d;

              url = replaceUrlParam(url,'start-date',firstDay);
              url = replaceUrlParam(url,'end-date',lastDay);
              window.location.href = url;
            });

            $('#select_range').change(function(){

              var val = $(this).val(),now = new Date(), firstDay = now, lastDay = now;


              if( val == 'today' ){
                  ddatePicker.DatePickerSetDate([now,now]);
                  rangeDate = [firstDay,lastDay];
              }else if( val == 'yesterday' ){
                  firstDay = now.addDays2(-1);
                  lastDay = now.addDays2(-1);
                  ddatePicker.DatePickerSetDate([ firstDay  , lastDay  ]);
                  rangeDate = [firstDay,lastDay];
              }else if( val == 'lastweek' ){
                  var beforeOneWeek = new Date(new Date().getTime() - 60 * 60 * 24 * 7 * 1000)
                  , day = beforeOneWeek.getDay()
                  , diffToMonday = beforeOneWeek.getDate() - day + (day === 0 ? -6 : 1)
                  , firstDay = new Date(beforeOneWeek.setDate(diffToMonday))
                  , lastDay = new Date(beforeOneWeek.setDate(diffToMonday + 6));
                  ddatePicker.DatePickerSetDate([firstDay,lastDay]);
                  rangeDate = [firstDay,lastDay];
              }else if( val == 'latmonth' ){
                  var y = now.getFullYear(),m = now.getMonth() - 1;
                  var firstDay = new Date(y, m , 1);
                  var lastDay = new Date(y, m + 1, 0);
                  ddatePicker.DatePickerSetDate([firstDay,lastDay]);
                  rangeDate = [firstDay,lastDay];
              }else if( val == 'last7days' ){
                  firstDay =  now.addDays2(-7);
                  lastDay =  now.addDays2(-1);
                  ddatePicker.DatePickerSetDate([firstDay,lastDay]);
                  rangeDate = [firstDay,lastDay];
              }else if( val == 'last30days' ){
                  firstDay =  now.addDays2(-30);
                  lastDay =  now.addDays2(-1);
                  ddatePicker.DatePickerSetDate([firstDay,lastDay]);
                  rangeDate = [firstDay,lastDay];
              }

              $('#widgetField span').get(0).innerHTML = ddatePicker.DatePickerformatDate(rangeDate,'d B, Y').join(' - ');

            });

            $('#widgetCalendar div.datepicker').css('position', 'absolute');
        };


        EYE.register(initLayout, 'init');
   </script>
</body>
</html>