<?php 
	$details = [];
	if( $product ){
		$details = json_decode($product->detailed_specifications,true);
		if( !is_array($details) ) $details = [];
	}
 ?>

@forif($groups_attribute as $group)
<div style="padding: 10px;background: rgb(233 240 247);margin-bottom: 25px;border: 1px solid #dedede;border-radius: 4px;">
	<h3 style="margin-bottom: 20px;">{!!$group['title']!!}</h3>
	@if(isset($group['attributes'][0]))
	<div>
	@foreach($group['attributes'] as $attribute)
	<div class="form-group">
		<label>{!!$attribute['title']!!}</label>
		<input value="{{$details[$group['title']][$attribute['title']]??''}}" name="specifications[{{$group['title']}}][{{$attribute['title']}}]" placeholder="{{$attribute['placeholder']}}" type="text" class="form-control input-text">
	</div>
	@endforeach
	</div>
	@endif
</div>
@endforif