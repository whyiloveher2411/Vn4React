<?php 
    if( !$post && isset($default_value ) ) $value = $default_value;

    $class = (!(isset($prepend) && $prepend) && !(isset($append) && $append))?'':'input-group';
    $readonly = $readonly??false;
 ?>

<div class="{!!$class!!}">
    @if( isset($prepend) && $prepend )
    <div class="input-group-addon">{!!$prepend!!}</div>
    @endif
    <input @if( $readonly ) readonly="readonly" @endif name="{!!isset($name)?$name:$key!!}" @if( isset($character_limit) && $character_limit) maxlength="{!!$character_limit!!}" @endif {!!isset($required) && $required?'required':''!!} value="{{$value}}" placeholder="{!!isset($placeholder)?$placeholder:''!!}" type="text" id="{!!$key!!}" class="form-control input-text">
    @if( isset($append) && $append)
    <div class="input-group-addon">{!!$append!!}</div>
    @endif
</div>



