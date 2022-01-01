<?php 

	$value = '';

	if( isset($data['post']) ){
		$value = json_decode($data['post']->filters,true);
	}

	echo get_field('relationship_manytomany',[
		'title'=>'Filters',
		'key'=>'filters',
		'name'=>'filters',
		'type_post'=>'ecommerce_category',
		'object'=>'ecommerce_filter',
		'data'=>[
			'onchange'=>'ecommerce_category_filters'
		],
		'value'=>$value,
	]);

	$filter_value = [];

	if( isset($data['post']) ){

		$filter_value = json_decode($data['post']->filter_value,true);

		echo '<div class="filters-value" style="margin-top: 15px;">'.view_plugin($plugin, 'views.category.filter_value',['ids'=>$value, 'filter_value'=>$filter_value]).'</div>';

	}

add_action('vn4_footer',function() use ($plugin,$filter_value) {
?>
<script type="text/javascript">
	
	window.filter_value = {!!json_encode($filter_value)!!};

	function ecommerce_category_filters(ids){
		if( ids ){

			for (var i = 0; i < ids.length; i++) {
				if( $('#filter_value_'+ids[i]).length ){

					let vals = [], $inpnuts = $('#filter_value_'+ids[i]+' input');

					for (let i = 0; i < $inpnuts.length; i++) {
						vals.push($inpnuts[i].value);
					}

					filter_value[ids[i]] = vals;

				}
			}

			vn4_ajax({
				url: '{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'category','method'=>'filters'])!!}',
				dataType:'html',
				data:{
					ids: ids,
					filter_value: filter_value,
				},
				callback:function(result){

					let filters = $('.form-input-filters');

					if( !filters.find('.filters-value').length ){
						filters.append('<div class="filters-value" style="margin-top: 15px;"></div>');
					}else{
						filters.find('.filters-value').empty();
					}

					let warpper = filters.find('.filters-value');

					warpper.append(result);

				}
			});

		}else{
			 $('.form-input-filters .filters-value').remove();
		}
	}

</script>
<?php
});

	// $details = [];
	// if( $product ){
	// 	$details = json_decode($product->detailed_filters,true);
	// 	if( !is_array($details) ) $details = [];
	// }

// @forif($groups_filters as $group)
// <div style="padding: 10px;background: rgb(233 240 247);margin-bottom: 25px;border: 1px solid #dedede;border-radius: 4px;">
// 	<h3 style="margin-bottom: 20px;">{!!$group['title']!!}</h3>
// 	@if(isset($group['values'][0]))
// 	<div>
// 	@foreach($group['values'] as $value)
// 		<label><input value="{{$value['title']}}" {!! isset($details[$group['title']]) && array_search($value['title'], $details[$group['title']]) !== false ? 	'checked="checked"' : ''!!} name="filters[{{$group['title']}}][]" type="checkbox" class="form-control input-text"> {!!$value['title']!!}</label>&nbsp;&nbsp;&nbsp;&nbsp;
// 	@endforeach
// 	</div>
// 	@endif
// </div>
// @endforif