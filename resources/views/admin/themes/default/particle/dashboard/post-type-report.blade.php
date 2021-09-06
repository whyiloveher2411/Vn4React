<?php 
// Template Name: Post Report
// Icon: fa-pie-chart


$post_type = isset($widget['data']['post_type']) && $widget['data']['post_type']? $widget['data']['post_type'] :false;
$field = isset($widget['data']['field']) && $widget['data']['field']? $widget['data']['field'] :false;
$report_count = isset($widget['data']['report_count']) && $widget['data']['report_count']? $widget['data']['report_count'] :false;

$admin_object = get_admin_object();
	
  $argFieldType = ['select'=>function($field,$key, $post_type) use ($admin_object, $__env) {

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


        };



        $('#result_{!!$key!!}').text({!!$count_row!!});



        var chart = new google.visualization.PieChart(document.getElementById('chart-{!!$post_type,'-',$key!!}'));



        chart.draw(data, options);

    <?php

    }

  },'checkbox'=>function($field){


  },'relationship_onetomany'=>function($field,$key, $post_type) use ($admin_object,$__env){

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
              is3D: true,
             legend:{
                position: 'bottom',
                textStyle: {fontSize: 13},
                alignment: 'center',
              },
              chartArea:{
                height: 200,
              },
              height: 250,
          };



          $('#result_{!!$key!!}').text({!!$count_row!!});



          var chart = new google.visualization.PieChart(document.getElementById('chart-{!!$post_type,'-',$key!!}'));



          chart.draw(data, options);

      <?php

    }

  },'relationship_manytomany'=>function($field,$key, $post_type) use ($admin_object, $__env) {

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


              hAxis: {

                format: '#'

              },

              chartArea:{
                height: 200,
              },
              height: 250,

          };



          $('#result_{!!$key!!}').text({!!$count_row!!});



          var chart = new google.visualization.BarChart(document.getElementById('chart-{!!$post_type,'-',$key!!}'));

          chart.draw(data, options);

      <?php

    }

  }];

?>

@if( isset($setting) && $setting )



<?php 

	// dd($field);

	$options = '';
	

	$listFields = [];
	
	foreach ($admin_object as $key => $value) {

		$options .= '<option '.($post_type === $key ? 'selected="selected"':'').' value="'.$key.'">'.$value['title'].'</option>';
		
		$fields = '';

		foreach ($value['fields'] as $key2 => $value2) {
			if( isset($value2['view']) && is_string($value2['view']) && isset($argFieldType[$value2['view']]) ){
				$fields .= '<option '.($key2 === $field? 'selected="selected"':'' ).' value="'.$key2.'">'.$value2['title'].'</option>';
			}
		}
		
		if( $fields ){
			$listFields[$key] = '<select class="form-control item-post-type post-type-'.$key.'"  '.($post_type !== $key? 'style="display:none;width:auto;max-width: 100%;" name=""': 'style="width:auto;max-width: 100%;" name="data[field]"' ).' >'.$fields.'<select>';
		}

	}
 ?>



	<div class="form-group">

		<label>Section</label>

		<p>Which section do you want to pull report from?</p>

		<select name="data[post_type]" onchange="$('.item-post-type').attr('name','').hide(); $('.post-type-'+ $(this).val() ).attr('name','data[field]').show(); " class="form-control" style="width:auto;max-width: 100%;">

			{!!$options!!}			

		</select>

	</div>

  <div class="form-group">
    <label><input type="checkbox" @if($report_count) checked="checked" @endif onchange=" if( $(this).is(':checked') ){ $(this).closest('form').find('.field-group').hide(); }else $(this).closest('form').find('.field-group').show();" name="data[report_count]" value="1"> Report count</label>
  </div>

	<div class="form-group field-group" style="@if($report_count) display: none; @endif">
		
		<label>Field Group</label>
		
		{!!implode('',$listFields)!!}
		
	</div>



@else

<?php 

	if( (!$post_type || !isset($admin_object[$post_type]) || !isset($admin_object[$post_type]['fields'][$field]) || !isset($argFieldType[ $admin_object[$post_type]['fields'][$field]['view'] ] )) || !$report_count ){
		echo 'Please install to use the widget';
		return;
	}

  if( !$report_count ){
	
  	ob_start();

  	$argFieldType[ $admin_object[$post_type]['fields'][$field]['view'] ]( $admin_object[$post_type]['fields'][$field],$field, $post_type);

  	$chartContentScript = ob_get_contents();

  	ob_end_clean();

  	add_action('vn4_footer',function() use ($chartContentScript, $field) {
  		?>
  		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  		 <script type="text/javascript">

  		    google.charts.load("current", {packages:['corechart']});

  		    google.charts.setOnLoadCallback(drawChart);

  		    function drawChart() {
  		        @if( $chartContentScript )

  		        {!!$chartContentScript!!}

  		        @else

  		        $('#result_{!!$field!!}').text(0);

  		        $('#chart-{!!$field!!}').html('<p><h4 style="font-size:18px;text-align: center;"><img style="box-shadow: none;width: 200px;max-width: 100%;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}"><strong>@__('There is no data.')<br><span style="color:#ababab;font-size: 16px;">@__('Seems like no data have been created yet.')</span></strong></h4></p>');

  		        @endif

  		    }

  		  </script>
  		<?php
  	});

  	$title = $admin_object[$post_type]['title'].' - '.$admin_object[$post_type]['fields'][$field]['title'];
  }else{

  	add_action('vn4_footer',function(){
  		?>
  		<script type="text/javascript">
  			$(window).load(function(){
  				setTimeout(function() {
  					$('.counting-post-type').each(function() {
					  var $this = $(this).find('.number'),
					      countTo =$(this).attr('data-count');
					  
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
  				}, 100);
  			});
  		</script>
  		<?php
  	},'counting-post-type-js',true);
  	$title = $admin_object[$post_type]['title'];
  }

?>


<div class="report-field">
	
	<div class="widget-heading">
  		<h2 style="z-index: 1;position: relative;"><a style="z-index: 1;" href="#" onclick="window.parent.location = '{!!route('admin.show_data',['post_type'=>$post_type])!!}';return false;">{!!$title!!}</a></h2>
	</div>

  	<div class="chart2" style="height:auto;" id="chart-{!!$post_type,'-',$field!!}">
  	 	@if( $report_count )
  	 	<div style="font-size: 120px;position: absolute;left: 0;top: 0;bottom: 0;right: 0;display: flex;justify-content: center;align-items: center;z-index: 0;">
  	 		<div class="count counting-post-type" style="line-height: 75px;" data-count="{!!number_format(DB::table($admin_object[$post_type]['table'])->where('type', $post_type)->count())!!}"><span class="number">0</span>
  	 			<p style="text-align: center;line-height: 0;margin: 0;"><small style="font-size: 12px;">Entries</small></p>
  	 		</div>
  	 		
  	 	</div>
  	 	@endif
  	</div>

</div>



@endif


