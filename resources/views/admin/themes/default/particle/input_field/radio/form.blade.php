<?php 
	if( !$post && isset($default_value) ) $value = $default_value;

	if( isset($layout) && $layout === 'horizontal' ){
		$layout_class = 'd-inline';
	}else{
		$layout_class = 'd-block';
	}


 ?>
 <div>
@foreach($list_option as $k => $v)

@if( isset($v['image']) )
<div class="radio {!!$layout_class!!}">
	<label>
	{!!image_lazy_loading($v['image'])!!}
  	<br>
    <input type="radio" name="{!!isset($name)?$name:$key!!}" value="{!!$k!!}" @if( $value == $k ) checked @endif >{!!$v['title']!!}
  </label> &nbsp;
</div>
@elseif( is_string($v) )
<div class="radio {!!$layout_class!!}">
  <label>
    <input type="radio" name="{!!isset($name)?$name:$key!!}" value="{!!$k!!}" @if( $value == $k ) checked @endif >{!!$v!!}
  </label> &nbsp;
</div>
@endif
 
@endforeach
</div>
