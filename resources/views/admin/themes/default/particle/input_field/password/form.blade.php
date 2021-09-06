<?php 
    $class = (!(isset($prepend) && $prepend) && !(isset($append) && $append))?'':'input-group';
 ?>

<div class="{!!$class!!}">
    @if( isset($prepend) && $prepend )
    <div class="input-group-addon">{!!$prepend!!}</div>
    @endif
    <input name="{!!isset($name)?$name:$key!!}" {!!isset($required) && $required?'required':''!!} type="password" placeholder="{!!isset($placeholder)?$placeholder:''!!}" id="{!!$key!!}" class="form-control">

    @if( isset($append) && $append)
    <div class="input-group-addon">{!!$append!!}</div>
    @endif
</div>




