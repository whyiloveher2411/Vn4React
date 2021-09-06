<?php

$list_value = json_decode($value,true);

?>

@if( is_array($list_value) )
@foreach ($list_value as $v)
 	{!!$list_option[$v]!!}<br>
@endforeach
@endif

