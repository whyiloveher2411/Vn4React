<?php 
    if( !$post && isset($default_value ) ) $value = $default_value;

    $class = (!(isset($prepend) && $prepend) && !(isset($append) && $append))?'':'input-group';

 ?>
<div class="{!!$class!!}">
	@if( isset($prepend) && $prepend )
  	<div class="input-group-addon">{!!$prepend!!}</div>
  	@endif
	<input name="{!!isset($name)?$name:$key!!}" @if(isset($minimum_value)) min="{!!$minimum_value!!}" @endif  @if(isset($maximum_value)) max="{!!$maximum_value!!}" @endif @if(isset($step_size)) step="{!!$step_size!!}" @endif {!!isset($required)?'required':''!!} value="{{$value}}" placeholder="{!!isset($placeholder)?$placeholder:''!!}" type="number" id="{!!$key!!}" class="form-control">

	@if( isset($append) && $append )
	<div class="input-group-addon">{!!$append!!}</div>
	@endif
</div>


