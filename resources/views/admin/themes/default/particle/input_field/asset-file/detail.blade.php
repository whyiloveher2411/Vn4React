<?php 
	$value = json_decode($value);
 ?>

 @if( $value )
 	<a href="{!!$value->link!!}" target="_balnk">{!!$value->file_name!!}</a>
 @endif