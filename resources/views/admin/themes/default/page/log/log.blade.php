 @extends(backend_theme('master'))
 @section('css')
  <style type="text/css">
      .stack {
            color: #9c9c9c;
      }
      .texct
      .date {
        min-width: 75px;
      }

      .text {
        word-break: break-all;
      }

      a.llv-active {
        z-index: 2;
        background-color: #f5f5f5;
        border-color: #777;
      }

      .list-group-item {
        word-wrap: break-word;
      }

      .dataTables_wrapper input[type="search"], .dataTables_wrapper select{
        height: 30px;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border: 1px solid #dedede;
        box-shadow: none;
      }
      .posttype-item{
          width: 100%;
          height: 100px;
          border-radius: 4px;
          padding: 15px 95px 15px 15px;
          position: relative;
          overflow: hidden;
          background: white;
            border: 1px solid #dddfe2;
          color: white;
          margin-bottom: 25px;
      }
      .posttype-item i{
          position: absolute;
          font-size: 60px;
          top: 0;
          right: 15px;
          line-height: 100px;
          opacity: .35;
          text-align: right;
      }
      .posttype-item .title{
          font-size: 20px;
          line-height: 24px;
          letter-spacing: normal;
          overflow-wrap: normal;
          text-align: left;
      }
      .posttype-item .count{
          font-size: 32px;
        font-weight: bold;
      }
      .bg-white-transparent-2 {
          border-color: rgba(0, 0, 0, 0.2)!important;
      }
      .bg-white{
        background: white;
        color:#25405D;
      }
      .system-item{
        line-height: 28px;
      }


      .fa-5 {
        font-size: 8em;
      }

      .posttype-item:hover i.fa-3dicon{
        color:#25405D;
        opacity: 1;
      }
  </style>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
 @stop

@section('content')
<?php 
  title_head( '<i class="fa fa-calendar" aria-hidden="true"></i> '.__('Log Viewer')); use_module('log'); 

  $hasLog = is_array($levelResult) && count($levelResult) > 0;
  $log_levels = [
        'emergency'=>0,
        'alert'=>0,
        'critical'=>0,
        'error'=>0,
        'warning'=>0,
        'notice'=>0,
        'info'=>0,
        'debug'=>0,
        'processed'=>0,
        'failed'=>0,
    ];

  if( $hasLog ){
    $log_levels = array_merge($log_levels, $levelResult);
  }

  $logData = [
    'all'=>[
      'color'=>'#8a8a8a'
    ],
    'emergency'=>[
      'color'=>'#b71b1c',
      'icon'=>'fa-bug',
    ],
    'alert'=>[
      'color'=>'#d32f30',
      'icon'=>'fa-bell-o',
    ],
    'critical'=>[
      'color'=>'#f44437',
      'icon'=>'fa-heartbeat',
    ],
    'error'=>[
      'color'=>'#CA2121',
      'icon'=>'fa-times-circle',
    ],
    'warning'=>[
      'color'=>'#CE812E',
      'icon'=>'fa-exclamation-triangle',
    ],
    'notice'=>[
      'color'=>'#29B87E',
      'icon'=>'fa-exclamation-circle',
    ],
    'info'=>[
      'color'=>'#2E79B4',
      'icon'=>'fa-exclamation-circle',
    ],
    'debug'=>[
      'color'=>'#90caf8',
      'icon'=>'fa-globe',
    ],
    'processed'=>[
      'color'=>'#c658ff',
      'icon'=>'fa-bug',
    ],
    'failed'=>[
      'color'=>'#CA2121',
      'icon'=>'fa-bug',
    ],
  ];

?>

 <div class="container-fluid">
  <div class="row">

    @if( $files )
    <div class="col sidebar col-md-2">
      <div class="list-group">
        @foreach($files as $file)
          <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
             class="list-group-item @if ($current_file == $file) llv-active @endif">
            {{$file}}
          </a>
        @endforeach
      </div>
    </div>
    @endif

    <div class=" @if( $files ) col-md-10 @else col-md-12 @endif table-container">
    <div class="row">
      @if( $hasLog )
      <div id="error_chart" class="col-md-4" style="height: 300px;background: none;">
        
      </div>
     <div class="text-truncate col-md-8" style="display: grid;grid-column-gap: 25px; grid-template-columns: auto auto auto  ; margin-bottom: 25px;">
        @foreach($log_levels as $key => $log)
        @if( $log )
          <a href="#">
            <div class="posttype-item" style="background: {!!$logData[$key]['color']!!};">
              <i class="fa {!!$logData[$key]['icon']!!} fa-5 fa-3dicon"></i>
              <div class="title">{!!capital_letters($key)!!}</div>
                  <div class="count counting" data-count="{!!$log!!}">0</div>
            </div>
          </a>
        @endif
        @endforeach
      </div>
      @endif
      
    </div>

      <div class="p-3">
        @if($current_file)
          <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}"><span class="fa fa-download"></span>
            Download file</a>
           - 
          <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}"><span
                class="fa fa-trash"></span> Delete file</a>
          @if(count($files) > 1)
             - 
            <a id="delete-all-log" href="?delall=true"><span class="fa fa-trash"></span> Delete all files</a>
          @endif
        @endif
      </div>
      <br>
      @if ($logs === null)
        <div>
          Log file >50M, please download it.
        </div>
      @else
        @if( !isset($logs[0]) )
          <h4 style="font-size:18px;text-align: center;">
          <img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}">
          <strong>@__('Log not found.')<br> 
            <span style="color:#ababab;font-size: 16px;">@__('Seems like no log have been created yet.')</span>
          </strong>
        </h4>
        @else
        <table id="table-log" class="table table-striped">
          <thead>
          <tr>
            <th>&nbsp;&nbsp;Level&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;Context&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
            <th>Content</th>
          </tr>
          </thead>
          <tbody>

          @foreach($logs as $key => $log)
            <tr data-display="stack{{{$key}}}">
              <td class="text-{{{$log['level_class']}}}"><span class="fa fa-{{{$log['level_img']}}}"
                                                               aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
              <td class="text">{{$log['context']}}</td>
              <td class="date">{{{$log['date']}}}</td>
              <td class="text">
                @if ($log['stack']) <button type="button" style="display:none;" class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                       data-display="stack{{{$key}}}"><span
                      class="fa fa-search"></span></button>@endif
                {{{$log['text']}}}
                @if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif
                @if ($log['stack'])
                  <div class="stack" id="stack{{{$key}}}"
                       style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                  </div>@endif
              </td>
            </tr>
          @endforeach

          </tbody>
        </table>
        @endif
      @endif
      
    </div>
  </div>
</div>

@stop
@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
  $(window).load(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [2, 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $(document).on('click','#delete-log, #delete-all-log',function () {
      return confirm('Are you sure?');
    });
    $('.counting').each(function() {
      var $this = $(this),
          countTo = $this.attr('data-count');
      
      $({ countNum: $this.text()}).animate({
        countNum: countTo
      },

      {

        duration: 3000,
        step: function() {
          $this.text(Math.floor(this.countNum));
        },
        complete: function() {
          $this.text(this.countNum);
          //alert('finished');
        }

      });  
      

    });

    @if( $hasLog )
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChartuserType);

      function drawChartuserType() {

        var data = google.visualization.arrayToDataTable([
          ['User Type', 'User'],
          @foreach($log_levels as $key => $log)
          @if( $log )
          ['{!!capital_letters($key)!!}', {!!$log!!} ],
          @endif
          @endforeach
        ]);

        var options = {
          title: '',
          pieHole:5,
          backgroundColor: 'transparent',
          width: '100%',
          height: '100%',
          chartArea: {
              left: "3%",
              top: "3%",
              height: "94%",
              width: "90%"
          },
          legend : { position : 'bottom' },
          slices: {
            <?php 
              $index = 0;
             ?>
            @foreach($log_levels as $key => $log)
            @if( $log )
            {!!$index!!}: { color: '{!!$logData[$key]['color']!!}' },
            <?php 
              $index ++;
             ?>
            @endif
            @endforeach
          },
          tooltip: {textStyle: {fontSize: 10}},
        };

        var chart = new google.visualization.PieChart(document.getElementById('error_chart'));
        chart.draw(data, options);
      }
    @endif

  });
</script>
@stop
