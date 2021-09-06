<?php
$list_value = $value;

$list_value = json_decode($list_value,true);

?>

@if( is_array($list_value) )
@foreach ($list_value as $v)
	@if( isset($field['list_option'][$v]) )
 	{!!$field['list_option'][$v]!!}<br>
 	@endif
@endforeach
@endif

