<?php 
	$start_date = date('Y-m-d');	
	$end_date = date('Y-m-d');	
  return ;
 ?>

<style type="text/css">
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
      .datepickerFuture{
          pointer-events: none;
          opacity: .4;
      }
</style>
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

<?php 


 add_action('vn4_footer',function() use ($start_date, $end_date){
 	?>
     <link rel="stylesheet" href="{!!asset('vendors/datepicker/datepicker.css')!!}" type="text/css" />
    <script type="text/javascript" src="{!!asset('vendors/datepicker/datepicker.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('vendors/datepicker/eye.js')!!}"></script>
    <script type="text/javascript">
    	
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
 	<?php
 });
?>