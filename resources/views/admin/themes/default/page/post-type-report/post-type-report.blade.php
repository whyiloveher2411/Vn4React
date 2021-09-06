@extends(backend_theme('master'))



@section('css')

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <style type="text/css">

    .report-field{

      max-width: 1000px;

      margin: 0 auto;

      background: white;

      margin-bottom: 20px;

      padding: 20px;

      border-radius: 4px;

    }

  </style>

@stop

@section('content')

<?php 



  $admin_object = get_admin_object();

  $post_type = Request::get('post-type');

  title_head( $admin_object[$post_type]['title'] );

  add_action('vn4_heading_before',function() use ($post_type){

    ?>

    <a href="{!!route('admin.show_data',['post-type'=>$post_type])!!}">

    <?php

  });

  add_action('vn4_heading',function() use ($post_type){

    ?>

     </a> - Report

    <?php

  });



  $argFieldType = ['select'=>function($field,$key) use ($admin_object, $post_type, $__env) {
    $result = DB::select(DB::raw('SELECT r.id,r.'.$key.' as title, count(r.id) as count

        from '.$admin_object[$post_type]['table'].' r

        group by r.'.$key

    ));

    $count_row = 0;

    if( $result ){ 

    ?>

    var data = google.visualization.arrayToDataTable([

         ['{!!$field['title']!!}', 'Count'],

         @foreach( $result as $row)

         [ @if( isset($field['list_option'][$row->title]['title'])) '{!!$field['list_option'][$row->title]['title']!!}' @else '{!!$row->title!!}' @endif, {!!$row->count!!}],

         <?php 

          $count_row += $row->count;

          ?>

         @endforeach

         ]);

         var options = {

           legend:{

            textStyle: {fontSize: 13}

            },
            colors: [
          @foreach( $result as $row)
              @if( isset($field['list_option'][$row->title]['color']))
              '{!!$field['list_option'][$row->title]['color']!!}',
              @endif
              @endforeach
            ],
            pieSliceTextStyle: {fontSize: 12}

        };



        $('#result_{!!$key!!}').text({!!$count_row!!});



        var chart = new google.visualization.PieChart(document.getElementById('chart-{!!$key!!}'));



        chart.draw(data, options);

    <?php

    }

  },'checkbox'=>function($field){


  },'relationship_onetomany'=>function($field, $key) use ($admin_object,$post_type,$__env){

    $result = DB::select(DB::raw('SELECT r.id,r.title, count(a.id) as count

        from '.$admin_object[$field['object']]['table'].' r

        left join '.$admin_object[$post_type]['table'].' a on r.id = a.'.$key.'

        group by r.id 

        HAVING count > 0;

        '

    ));

    if( $result ){ 

      $count_row = 0;

      ?>

      var data = google.visualization.arrayToDataTable([

           ['{!!$field['title']!!}', 'Count'],

           @foreach( $result as $row)

           ['{!!$row->title!!}', {!!$row->count!!}],

           <?php 

            $count_row += $row->count;

            ?>

           @endforeach

           ]);

           var options = {

             legend:{

              textStyle: {fontSize: 13}

              },

              pieSliceTextStyle: {fontSize: 12}

          };



          $('#result_{!!$key!!}').text({!!$count_row!!});



          var chart = new google.visualization.PieChart(document.getElementById('chart-{!!$key!!}'));



          chart.draw(data, options);

      <?php

    }

  },'relationship_manytomany'=>function($field, $key) use ($admin_object, $post_type, $__env) {

    $result = DB::select(DB::raw('SELECT f.*, count(f.id) as report_count

       FROM  '.vn4_tbpf().$post_type.'_'.$field['object'].' l 

       JOIN  '.$admin_object[$field['object']]['table'].' f ON l.tag_id = f.id 

       JOIN  '.$admin_object[$post_type]['table'].' p ON l.post_id =p.id 

       GROUP BY f.id 

       HAVING report_count > 0;

       '

    ));



    if( $result ){ 

      $count_row = DB::table($admin_object[$post_type]['table'])->where('type',$post_type)->count();

      ?>

      var data = google.visualization.arrayToDataTable([

           ['{!!$field['title']!!}', 'Count'],

           @foreach( $result as $row)

           ['{!!$row->title!!}', {!!$row->report_count!!}],

           @endforeach

           ]);

           var options = {

             legend:{

              position: 'none'

              },

              pieSliceTextStyle: {fontSize: 12},

              hAxis: {

                format: '#'

              }

          };



          $('#result_{!!$key!!}').text({!!$count_row!!});



          var chart = new google.visualization.BarChart(document.getElementById('chart-{!!$key!!}'));

          chart.draw(data, options);

      <?php

    }

  }];



  $argChart = [];



  foreach ($admin_object[$post_type]['fields'] as $key => $value) {

    if( isset($value['view']) && is_string($value['view']) && isset($argFieldType[$value['view']]) ){

      ?>  

        <div class="report-field">

          <h2>{!!$value['title']!!}</h2>

          <p class="report-row"><span id="result_{!!$key!!}">#</span> Result</p>

          <div class="chart2" style="height:350px;" id="chart-{!!$key!!}"></div>

        </div>

      <?php



      ob_start();

      $argFieldType[$value['view']]($value,$key);

      $output = ob_get_contents();

      ob_end_clean();

      $argChart[$key] = $output;

    }

  }



  if( !$argChart ){

    ?>

    <div>

    <h4 style="font-size:18px;text-align: center;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}"><strong>@__('There is no data.')<br><span style="color:#ababab;font-size: 16px;">@__('In some cases, the data will not be suitable for graphing')</span></strong></h4>

    </div>

    <?php

  }



 ?>





 <div id="chart">

    

  </div>

@stop

@section('js')

  <script type="text/javascript">

    google.charts.load("current", {packages:['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        @foreach($argChart as $key => $js)

        @if( $js )

        {!!$js!!}

        @else

        $('#result_{!!$key!!}').text(0);

        $('#chart-{!!$key!!}').html('<p><h4 style="font-size:18px;text-align: center;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}"><strong>@__('There is no data.')<br><span style="color:#ababab;font-size: 16px;">@__('Seems like no data have been created yet.')</span></strong></h4></p>');

        @endif

        @endforeach

    }

  </script>

@stop



