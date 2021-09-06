<?php
	
	$minimum_rows = isset($minimum_rows)?$minimum_rows*1:false;
	$maximum_rows = isset($maximum_rows)?$maximum_rows*1:false;

	if( $minimum_rows === 0 && $maximum_rows === 0){
		$minimum_rows = false;
		$maximum_rows = false;
	}
	$button_label  = isset($button_label)?$button_label:'Add Item';

	$name = isset($name)?$name:$key;

	if( !isset($layout) ) $layout = 'table';

	if( is_string($value) ){
		$value = json_decode($value,true);
	}

	if( !is_array($value)) $value = [];
	
	$str_plugin_xpenl = ( !isset($button_trash) || $button_trash ? '<li><a class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>' : '' ).( !isset($button_remove) || $button_remove ? '<li><a class=""><i class="fa fa-times" aria-hidden="true"></i></a></li>' : '' );

	if( $layout === 'block' ){
		$htmlItem = '<input type="hidden" name="'.$name.'[index_repeater][delete]" value="0" class="input-trash">';

		foreach ($sub_fields as $key2 => $item) {

			if (!isset($item['view']) ) $item['view'] = 'text';

			$item['key'] = 'id_group_'.str_slug($key.'-'.$key2);
			$item['name'] = $name.'[index_repeater]['.$key2.']';
			$item['value'] = '';
			$htmlItem .= '<div class="form-group"><label style="width: 100%;">'.$item['title'].'</label>'.get_field($item['view'], $item).'</div>';
		}

	}elseif( $layout === 'custom' ){
		
		$list_data = [];

		foreach ($sub_fields as $key2 => $item) {

			if (!isset($item['view']) ) $item['view'] = 'text';

			$item['key'] = 'id_group_'.str_slug($key.'-'.$key2);
			$item['name'] = $name.'[index_repeater]['.$key2.']';
			$item['value'] = '';

			$list_data[$key2] = get_field($item['view'], $item);

		}

		$htmlItem = '<input type="hidden" name="'.$name.'[index_repeater][delete]" value="0" class="input-trash">'.$custom($list_data);

	}else{

		$htmlItem = '<input type="hidden" name="'.$name.'[index_repeater][delete]" value="0" class="input-trash"><table class="table table-bordered" style="table-layout:fixed;margin-bottom: 10px;"><thead style="background: #e9f0f7;"><tr>';

		$tbody = '';
		$thead = '';

		// if( !isset($sub_fields) ) dd($key);

		foreach ($sub_fields as $key2 => $item) {

			if (!isset($item['view']) ) $item['view'] = 'text';

			$item['key'] = 'id_group_'.str_slug($key.'-'.$key2);
			$item['name'] = $name.'[index_repeater]['.$key2.']';
			$item['value'] = '';

			$thead .= '<td '.(isset($item['width_column'])?'style="width:'.$item['width_column'].'"':'').'>'.$item['title'].'</td>';
			$tbody .= '<td>'.get_field($item['view'], $item).'</td>';

		}

		$htmlItem .= $thead.'</tr></thead><tbody><tr>'.$tbody.'</tr></tbody></table>';

	}
	

?>


<div class="group-input input-repeater" id="input-repeater-{!!$key!!}" data-name="{!!$name!!}" data-min="{!!$minimum_rows!!}" data-max="{!!$maximum_rows!!}" >

@if( $minimum_rows || $maximum_rows )
<p class="note">Rule 
@if( !$maximum_rows )
	 Minimum: {!!$minimum_rows!!}
@else
	@if( $minimum_rows )
	: From {!!$minimum_rows,' to ',$maximum_rows!!}
	@else
	 Maximin: {!!$maximum_rows!!}
	@endif
@endif
Entities </p>
@endif

<div class="emptyButton add-box-repeater-warpper" @if( empty($value) ) style="display: block;" @endif >{!!$button_label!!}</div>

<div class="list-input {!!$class??''!!}">


	@if( $value )
	
		@if( $layout === 'block' )
		@foreach($value as  $index => $v)
			<div class="repeater-item" style="z-index: {!!1000 - $index!!};">
			<?php  vn4_panel('<h2 style="word-break: break-all;"><span class="number_position">'.($index + 1).'. </span><span class="title">Item</span></h2>', function() use ($sub_fields, $__env,$name, $key, $v, $index) { ?>
				<div class="input-group-old">
				<input type="hidden" name="{!!$name!!}[index_repeater][delete]" value="{!!$v['delete']!!}" class="input-trash">
					@foreach($sub_fields as $key2 => $item)
						
						<?php 
							if( !isset($item['view']) ) $item['view'] = 'text';
							
							$item['key'] = 'id_group_'.str_slug($key.'-'.$key2.'-'.$index);
							$item['name'] = $name.'[index_repeater]['.$key2.']';

							if( isset($v[$key2]) ){
								$item['value'] = $v[$key2];
							}else{
								$item['value'] = '';
							}
						 ?>

						 <div class="form-group"><label style="width: 100%;">{!!$item['title']!!}</label>{!!get_field($item['view'], $item)!!}</div>

					@endforeach
				</div>
				<?php },true, $str_plugin_xpenl, ['class_title'=>$v['delete']*1 === 1 ? 'btn-danger':''] ); ?>
				</div>
		@endforeach
		@elseif( $layout === 'custom' )
			<?php $index = 0; ?>
			@foreach($value as $index =>  $v)

				@if( isset($v['delete']) )
				<div class="repeater-item" style="z-index: {!!1000 - $index!!};" >
				<?php  vn4_panel('<h2 style="word-break: break-all;"><span class="number_position">'.(++$index).'. </span><span class="title">Item</span></h2>', function() use ($sub_fields, $__env,$name, $key, $v, $index, $custom) { ?>

				<?php 
					$list_data = [];

					foreach ($sub_fields as $key2 => $item) {

						if (!isset($item['view']) ) $item['view'] = 'text';
								
						$item['key'] = 'id_group_'.str_slug($key.'-'.$key2.'-'.$index);
						$item['name'] = $name.'[index_repeater]['.$key2.']';

						if( isset($v[$key2]) ){
							$item['value'] = $v[$key2];
						}else{
							$item['value'] = '';
						}
						

						$list_data[$key2] = get_field($item['view'], $item);

					}

					echo '<input type="hidden" name="'.$name.'[index_repeater][delete]" value="'.$v['delete'].'" class="input-trash">'.$custom($list_data);

				 },true, $str_plugin_xpenl, ['class_title'=>$v['delete']*1 === 1 ? 'btn-danger':''] ); ?>

				 </div>
				@endif

			@endforeach

		@else
		<?php $index = 0; ?>
		@foreach($value as $index => $v)

			@if( isset($v['delete']) )
			<div class="repeater-item"  style="z-index: {!!1000 - $index!!};" >
			<?php  vn4_panel('<h2 style="word-break: break-all;"><span class="number_position">'.(++$index).'. </span><span class="title">Item</span></h2>', function() use ($sub_fields, $__env,$name, $key, $v, $index) { ?>
				<div class="input-group-old">
				<input type="hidden" name="{!!$name!!}[index_repeater][delete]" value="{!!$v['delete']!!}" class="input-trash">

				<table class="table table-bordered" style="table-layout:fixed;margin-bottom: 10px;"><thead style="background: #F9F9F9;"><tr>
					<?php $thead ='';$tbody = ''; ?>
					@foreach($sub_fields as $key2 => $item)
						
						<?php 
							if (!isset($item['view']) ) $item['view'] = 'text';
							
							$item['key'] = 'id_group_'.str_slug($key.'-'.$key2.'-'.$index);
							$item['name'] = $name.'[index_repeater]['.$key2.']';

							if( isset($v[$key2]) ){
								$item['value'] = $v[$key2];
							}else{
								$item['value'] = '';
							}
							
							$thead .= '<td '.(isset($item['width_column'])?'style="width:'.$item['width_column'].'"':'').'>'.$item['title'].'</td>';
							$tbody .= '<td>'.get_field($item['view'], $item).'</td>';

						 ?>

					@endforeach

				 {!!$thead!!}</tr></thead><tbody><tr>{!!$tbody!!}</tr></tbody></table>
				</div>
				<?php },true, $str_plugin_xpenl, ['class_title'=>$v['delete']*1 === 1 ? 'btn-danger':''] ); ?>
			</div>
			@endif
		@endforeach
		@endif

	@endif

</div>


<a href="javascript:void(0)" data-template="script-template-{!!$key!!}" class="vn4-btn vn4-btn-blue add-group-item" >{!!$button_label!!}</a>
<div class="clearfix"></div>
</div>


<?php add_action('vn4_footer',function() use ($key,$htmlItem,$str_plugin_xpenl ){ ?>

<script type="text/template" id="script-template-{!!$key!!}"><div class="repeater-item"><?php vn4_panel('<h2 style="word-break: break-all;"><span class="number_position"></span><span class="title">Item</span></h2>', function() use ($htmlItem) { ?><div class="input-group-new">{!!$htmlItem!!}</div> <?php },true, $str_plugin_xpenl ); ?> </div></script>

<?php },$key,true) ?>
