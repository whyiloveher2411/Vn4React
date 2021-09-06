<?php 
	if( is_string($value) ){
		$value = json_decode($value,true);
	}

	if( !is_array($value) ){
		$value = [];
	}

	if( !is_array($value) ) $value = [];
	if( !isset($layout) ) $layout = 'table';

	$minimum_rows = isset($minimum_rows)?$minimum_rows*1:false;
	$maximum_rows = isset($maximum_rows)?$maximum_rows*1:false;

	if( $minimum_rows === 0 && $maximum_rows === 0){
		$minimum_rows = false;
		$maximum_rows = false;
	}

	$name = isset($name)?$name:$key;

	$button_labe  = isset($button_labe)?$button_labe:'Add Item';

	$group_downmenu = '';
	$str_plugin_xpenl = '<li><a class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></li><li><a class=""><i class="fa fa-times" aria-hidden="true"></i></a></li>';

	$htmlGroups = [];

	foreach ($templates as $key_group => $group) {

		if( !isset($group['layout']) || $group['layout'] === 'table' ){
			$group_downmenu .= '<li><a href="#" data-field="'.$key_group.'">'.$group['title'].'</a></li>';

			$htmlGroups[$key_group] = '<input type="hidden" name="'.$name.'[index_flexible][delete]" value="0" class="input-trash"><input type="hidden" name="'.$name.'[index_flexible][type]" value="'.$key_group.'" class="flexible-type"><table class="table table-bordered" style="table-layout:fixed;margin-bottom: 10px;"><thead style="background: #F9F9F9;"><tr>';

			$tbody = '';
			$thead = '';

			foreach($group['items'] as  $key_item => $item){

				if( !isset($item['view']) ) $item['view'] = 'text';

				$thead .= '<td '.(isset($item['width_column'])?'style="width:'.$item['width_column'].'"':'').'>'.$item['title'].'</td>';
				$tbody .= '<td>'.get_field($item['view'],array_merge($item,['value'=>'','name'=>$name.'[index_flexible]['.$key_item.']', 'key'=>'id_group_'.str_slug($key.'-'.$key_group.'-'.$key_item)])).'</td>';
			}

			$htmlGroups[$key_group] .= $thead.'</tr></thead><tbody><tr>'.$tbody.'</tr></tbody></table>';

		}elseif( $group['layout'] === 'tab' ) {
			
			$group_downmenu .= '<li><a href="#" data-field="'.$key_group.'">'.$group['title'].'</a></li>';
			
			$tabs = [];

			foreach($group['items'] as  $key_item => $item){
				
				if( !isset($item['view']) ) $item['view'] = 'text';
				
				$item['value'] = '';
				$item['name'] = $name.'[index_flexible]['.$key_item.']';
				$item['key'] = 'id_group_'.str_slug($key.'-'.$key_group.'-'.$key_item);

				$tabs[$key_item] = [
					'title'=>$item['title'],
					'content'=>function() use ($item){
						echo get_field($item['view'], $item);
					}
				];

			}
			
			ob_start();
			vn4_tabs_top($tabs);
			$content = ob_get_clean();
			ob_flush();

			$htmlGroups[$key_group] = '<input type="hidden" name="'.$name.'[index_flexible][delete]" value="0" class="input-trash"><input type="hidden" name="'.$name.'[index_flexible][type]" value="'.$key_group.'" class="flexible-type">'.$content;
			
		}else{

			$group_downmenu .= '<li><a href="#" data-field="'.$key_group.'">'.$group['title'].'</a></li>';

			$htmlGroups[$key_group] = '<input type="hidden" name="'.$name.'[index_flexible][delete]" value="0" class="input-trash"><input type="hidden" name="'.$name.'[index_flexible][type]" value="'.$key_group.'" class="flexible-type">';

			foreach($group['items'] as  $key_item => $item){
				$htmlGroups[$key_group] .= '<div class="form-group">'.( !isset($item['show_label']) || !$item['show_label'] ? '' : '<label style="width: 100%;">'.$item['title'].'</label>' ).get_field($item['view'],array_merge($item,['value'=>'','name'=>$name.'[index_flexible]['.$key_item.']', 'key'=>'id_group_'.str_slug($key.'-'.$key_group.'-'.$key_item)])).'</div>';
			}
		}
	}
 ?>

<div class="group-input input-flexible" id="flexible-{!!$key!!}"  data-min="{!!$minimum_rows!!}" data-max="{!!$maximum_rows!!}">

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
	<div class="emptyButton add-box-flexible-warpper" @if( empty($value) ) style="display: block;" @endif >Add {!!$title!!} Block</div>

	<div class="list-box">
		
		@foreach( $value as $index => $item)
			<?php 
				if( !isset($item['type']) ){
					continue;
				}
			 ?>
			@if( isset($templates[$item['type']]) )

				<div class="flexible-item">
				@if( !isset($templates[$item['type']]['layout']) || $templates[$item['type']]['layout'] === 'table' )
				<?php 
					$table = '<input type="hidden" name="'.$name.'[index_flexible][delete]" value="'.$item['delete'].'" class="input-trash"><input type="hidden" name="'.$name.'[index_flexible][type]" value="'.$item['type'].'" class="flexible-type"><table class="table table-bordered" style="table-layout:fixed;margin-bottom: 10px;"><thead style="background: #F9F9F9;"><tr>';

					$tbody = '';
					$thead = '';
					foreach($templates[$item['type']]['items'] as  $key_item => $config){

						if( !isset($config['view']) ) $config['view'] = 'text';
						
						$thead .= '<td '.(isset($config['width_column'])?'style="width:'.$config['width_column'].'"':'').'>'.$config['title'].'</td>';
						$tbody .= '<td>'.get_field($config['view'],array_merge($config,['value'=>isset($item[$key_item])?$item[$key_item]:'','name'=>$name.'[index_flexible]['.$key_item.']', 'key'=>'id_group_'.str_slug($key.'-'.$item['type'].'-'.$key_item.'-'.$index)])).'</td>';
					}

					$table .= $thead.'</tr></thead><tbody><tr>'.$tbody.'</tr></tbody></table>';

					vn4_panel('<span class="number_position">'.($index + 1).'. </span><span class="title-type">'.$templates[$item['type']]['title'].'</span> - <span class="title-flexible-item">'.$templates[$item['type']]['title'].'</span>', function() use ($table) {
						echo $table;
					},true, $str_plugin_xpenl, ['class_title'=>$item['delete']*1 === 1 ? 'flexible-title btn-danger':'flexible-title'] );

				 ?>
				 @elseif( $templates[$item['type']]['layout'] === 'tab' )
					<?php 
						$tabs = [];
						
						foreach($templates[$item['type']]['items'] as  $key_item => $config){

							if( !isset($item['view']) ) $item['view'] = 'text';
							
							$config['value'] = isset($item[$key_item])?$item[$key_item]:'';
							$config['name'] = $name.'[index_flexible]['.$key_item.']';
							$config['key'] = 'id_group_'.str_slug($key.'-'.$item['type'].'-'.$key_item.'-'.$index);

							$tabs[$key_item] = [
								'title'=>$config['title'],
								'content'=>function() use ($config){
									echo get_field($config['view'], $config);
								}
							];

						}
						vn4_panel('<span class="number_position">'.($index + 1).'. </span><span class="title-type">'.$templates[$item['type']]['title'].'</span> - <span class="title-flexible-item">'.$templates[$item['type']]['title'].'</span>', function() use ($tabs,$name,$item) {
							echo '<input type="hidden" name="'.$name.'[index_flexible][delete]" value="'.$item['delete'].'" class="input-trash"><input type="hidden" name="'.$name.'[index_flexible][type]" value="'.$item['type'].'" class="flexible-type">';
							vn4_tabs_top($tabs);
						},true, $str_plugin_xpenl, ['class_title'=>$item['delete']*1 === 1 ? 'flexible-title btn-danger':'flexible-title'] );
					 ?>
				 @else
					<?php 
						vn4_panel('<span class="number_position">'.($index + 1).'. </span><span class="title-type">'.$templates[$item['type']]['title'].'</span> - <span class="title-flexible-item">'.$templates[$item['type']]['title'].'</span>', function() use ($name, $templates, $item, $key, $__env, $index ){
							?>
								
								<input type="hidden" name="{!!$name!!}[index_flexible][delete]" value="{!!$item['delete']!!}" class="input-trash"><input type="hidden" name="{!!$name!!}[index_flexible][type]" value="{!!$item['type']!!}" class="flexible-type">
								
								@foreach($templates[$item['type']]['items'] as  $key_item => $config)
				
								 <div class="form-group">
									@if( !isset($config['show_label']) || $config['show_label'] )
								 	<label style="width: 100%;">{!!$config['title']!!}</label>
									@endif

								 	{!!get_field($config['view'],array_merge($config,['value'=>isset($item[$key_item])?$item[$key_item]:'','name'=>$name.'[index_flexible]['.$key_item.']', 'key'=>'id_group_'.str_slug($key.'-'.$item['type'].'-'.$key_item.'-'.$index)]))!!}</div>

								 @endforeach

							<?php
						}, true, $str_plugin_xpenl, ['class_title'=>$item['delete']*1 === 1 ? 'flexible-title btn-danger':'flexible-title']);
					 ?>
				 @endif
				 </div>
		 	@endif
		@endforeach
		
	</div>
	<div class="list_template_title {!!$dropdown_type??'dropup'!!}">
	    <button class="btn btn-default dropdown-toggle vn4-btn vn4-btn-blue pull-right" type="button" data-toggle="dropdown">{!!$button_labe!!} <span class="caret"></span></button>
	    <ul class="dropdown-menu dropdown-menu-right" data-field="{!!$key!!}">
	     	{!!$group_downmenu!!}
	    </ul>
  	</div>
  	<div class="clearfix"></div>
</div>

<?php add_action('vn4_footer',function() use ($templates,$str_plugin_xpenl,$htmlGroups, $__env,$key) { ?>
	
@foreach($templates as $key_group => $group)
	<script type="text/template" id="script-template-flexible-{!!$key,'-',$key_group!!}">

	<div class="flexible-item">
	<?php  	
	vn4_panel('<span class="number_position"></span><span class="title-type">'.$group['title'].'</span> - <span class="title-flexible-item">'.$group['title'].'</span>', function() use ($htmlGroups, $key_group) {
			echo $htmlGroups[$key_group];
		},true, $str_plugin_xpenl,['class_title'=>'flexible-title'] ); ?>
	</div>

	</script>
@endforeach
<?php },$key,true) ?>


