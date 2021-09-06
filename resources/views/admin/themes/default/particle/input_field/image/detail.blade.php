<?php 
	$value = json_decode($value);
 ?>

 @if( is_array($value) )
	@foreach($value as $v)
		 @if( $v->type_link === 'local' )
		  <a href="{!!asset($v->link)!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!image_lazy_loading(asset($v->link), 'class="type-image-'.$v->type_link.'" style="max-width: 50%;width: 50%;height: auto;float:left;padding:5px;"')!!}</a>
		 @else
		 <a href="{!!$v->link!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!image_lazy_loading($v->link, 'class="type-image-'.$v->type_link.'" style="max-width: 50%;width: 50%;height: auto;float:left;padding:5px;"')!!}</a>
		 @endif
	@endforeach
 @else
	@if( $value )
		 @if( $value->type_link === 'local' )
		 <a href="{!!asset($value->link)!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!image_lazy_loading(asset($value->link), 'class="type-image-'.$value->type_link.'"')!!}</a>
		 @else
		 <a href="{!!$value->link!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')" >{!!image_lazy_loading($value->link, 'class="type-image-'.$value->type_link.'"')!!}</a>
		 @endif
	@else
		 {!!image_lazy_loading(asset('public/admin/images/img_not_found.jpg'))!!}
	@endif
 @endif

 <div class="clear-fix"></div>


