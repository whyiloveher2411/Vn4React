<?php 
	if( !$post && isset($default_value) ) $value = $default_value;

	
 ?>
<textarea name="{!!isset($name)?$name:$key!!}" {!!isset($required) && $required ?'required':''!!} id="{!!$key!!}" @if(isset($character_limit) && $character_limit) maxlength="{!!$character_limit!!}" @endif placeholder="{!!isset($placeholder)?$placeholder:''!!}" class="form-control" rows="{!!isset($rows)?$rows:5!!}">{!!$value?json_encode(json_decode($value),JSON_PRETTY_PRINT):''!!}</textarea>
