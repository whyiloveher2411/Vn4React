<?php 
	$value = json_decode($value);

 ?>

 @if( is_object($value) )

 	<?php 
 		$count = count(reset($value));
 	 ?>

 	 @for( $i = 0; $i < $count; $i ++)
 	 @foreach($items as $k => $item)
 	 	<label>{!!$item['title']!!}: </label>
 	 	<?php 
 	 		$item['value'] = $value->$k[$i];
 	 	 ?>
 	 	@if( view()->exists(backend_theme('particle.input_field.'.$item['view'].'.detail')))
		{!!vn4_view(backend_theme('particle.input_field.'.$item['view'].'.detail'), $item)!!}
		@else
		{!!$value->$k[$i]!!}
		@endif
		@if($item['view'] != 'image')
		<p class="note">{!!isset($item['note'])?$item['note']:''!!}</p>
		@endif
 	 @endforeach
 	 	<hr>
 	 @endfor


 @endif