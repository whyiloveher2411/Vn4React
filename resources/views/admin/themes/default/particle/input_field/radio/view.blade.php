@if( isset($field['list_option'][$value]['image']) )
	<img src="{!!$field['list_option'][$value]['image']!!}">
@elseif( isset($field['list_option'][$value]) )
 	{!!$field['list_option'][$value]!!}
@endif
