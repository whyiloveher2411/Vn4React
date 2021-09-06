<?php

	if( !isset($layout) ) $layout = 'table';
	$name = isset($name)?$name:$key;

	if( is_string($value) ){

		$value = json_decode($value,true);

	}

	if( !is_array($value) ){

		$value = [];

	}

	// $width = 100/count($sub_fields);

?>

<div class="group-input input-group" id="input-group-{!!$key!!}" data-name="{!!$name!!}">

<?php  vn4_panel(null, function() use ($sub_fields, $__env,$name, $key, $post,$value, $layout) { ?>

@if( $layout === 'table' )

<table class="table table-bordered">

	<thead style="background: #F9F9F9;">

		<tr>

			@foreach($sub_fields as $i)

			<th style="{!!isset($i['width_column'])?'width:'.$i['width_column']:''!!}">{!!$i['title']!!}</th>

			@endforeach

		</tr>

	</thead>

	<tbody>

		<tr>

			@foreach($sub_fields as $k => $i)

			<?php 
				if( !isset($i['view']) ) $i['view'] = 'text';

				if( isset($value[$k]) ){

					$i['value'] = $value[$k];

				}else{

					$i['value'] = '';

				}
				
				$i['key'] = $key.'_'.$k;

				$i['name'] = $name.'['.$k.']';

			 ?>

			<td>

				{!!get_field($i['view'], $i, $post)!!}

			</td>

			@endforeach



		</tr>

	</tbody>

</table>





@elseif( $layout === 'tab' )

<?php 
	
	$tabs = [];

	foreach($sub_fields as $k => $i){

		if( !isset($i['view']) ) $i['view'] = 'text';

		if( isset($value[$k]) ){

			$i['value'] = $value[$k];

		}else{

			$i['value'] = '';

		}
		
		$i['key'] = $key.'_'.$k;

		$i['name'] = $name.'['.$k.']';

		$tabs[$k] = [
			'title'=>$i['title'],
			'content'=>function() use ($i,$post){
				echo get_field($i['view'], $i, $post);
			}
		];
	}

	vn4_tabs_top($tabs);
 ?>

@else

@foreach($sub_fields as $k => $i)
	
	<?php 
		if( !isset($i['view']) ) $i['view'] = 'text';
		
		if( isset($value[$k]) ){

			$i['value'] = $value[$k];

		}else{

			$i['value'] = '';

		}
		
		$i['key'] = $key.'_'.$k;

		$i['name'] = $name.'['.$k.']';

	 ?>

	 <div class="form-group"><label style="width: 100%;">{!!$i['title'],get_field($i['view'], $i, $post)!!}</label></div>

@endforeach

@endif
<?php },true, null , ['x_panel_style'=>$layout !== 'block'?'border:none;':'','x_panel_content'=>$layout !== 'block'?'padding:0;':'']); ?>
</div>



<?php add_action('vn4_footer',function(){ ?>

	<script type="text/javascript">
		$(document).on('click','.input-group>.x_panel>.x_title',function(event){
			event.stopPropagation();
			$(this).find('.collapse-link').trigger('click');

		});
	</script>

<?php },'input_group_js',true) ?>
