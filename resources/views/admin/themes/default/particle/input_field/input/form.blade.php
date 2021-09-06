<?php 
    if( !$post && isset($default_value ) ) $value = $default_value;
    $class = (!(isset($prepend) && $prepend) && !(isset($append) && $append))?'':'input-group';
 ?>

<div class="{!!$class!!}">
    @if( isset($prepend) && $prepend )
    <div class="input-group-addon">{!!$prepend!!}</div>
    @endif
    <input name="{!!isset($name)?$name:$key!!}" @if( isset($character_limit) && $character_limit) maxlength="{!!$character_limit!!}" @endif {!!isset($required) && $required?'required':''!!} value="{{$value}}" placeholder="{!!isset($placeholder)?$placeholder:''!!}" type="{!!isset($type)?$type:'text'!!}" id="{!!$key!!}" class="form-control">
    @if( isset($append) && $append)
    <div class="input-group-addon">{!!$append!!}</div>
    @endif
</div>



