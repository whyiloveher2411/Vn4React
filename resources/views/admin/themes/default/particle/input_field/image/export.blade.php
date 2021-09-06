<?php 
	$value = json_decode($value);
 ?>

 @if( is_array($value) )
	@foreach($value as $v)
		 @if( $v->type_link === 'local' )
		  <a href="{!!asset($v->link)!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!asset($v->link)!!}</a>
		 @else
		 <a href="{!!$v->link!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!$v->link!!}</a>
		 @endif
	@endforeach
 @else
	@if( $value )
		 @if( $value->type_link === 'local' )
		 <a href="{!!asset($value->link)!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!asset($value->link)!!}</a>
		 @else
		 <a href="{!!$value->link!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!$value->link!!}</a>
		 @endif
	@else
		 
	@endif
 @endif


