<?php

$filters = json_decode($category->filters,true);
$filter_value = json_decode($category->filter_value,true);	

if( !is_array($filter_value) ) $filter_value = [];
if( !is_array($filters) ) $filters = [];

$filter_value_merge = [];

foreach ($filter_value as $v) {
	$filter_value_merge = array_merge($filter_value_merge, $v);
}

$details = [];

if( $product ){
	$details = json_decode($product->detailed_filters,true);
	if( !is_array($details) ) $details = [];
}

$details = array_column($details, NULL, 'id');

$filters_posts = get_posts('ecommerce_filter',['count'=>1000,'callback'=>function($q) use ($filters){
	$q->whereIn('id',$filters);
}])->keyBy('id');

$filter_value_posts = get_posts('ecommerce_filter_value',['count'=>1000,'callback'=>function($q) use ($filter_value_merge){
	$q->whereIn('id',$filter_value_merge);
}])->groupBy('ecommerce_filter');

?>

@foreach($filters_posts as  $filter)
<div style="padding: 10px;background: rgb(233 240 247);margin-bottom: 25px;border: 1px solid #dedede;border-radius: 4px;">
	<h3 style="margin-bottom: 20px;">{!!$filter->title!!}</h3>
	@if(isset($filter_value_posts[$filter->id]))
	<div>
	@foreach($filter_value_posts[$filter->id] as $value)
		<label><input value="{{$value->id}}" name="detailed_filters[]" type="checkbox" class="form-control input-text" {!! isset($details[$value->id]) ? 'checked="checked"' : ''!!}  > {!!$value->title!!}</label>&nbsp;&nbsp;&nbsp;&nbsp;
	@endforeach
	</div>
	@endif
</div>	
@endforeach
