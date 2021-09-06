<?php 
	if( !$post && isset($default_value) ) $value = $default_value;

	if( !isset($toggle) ) $toggle = false;

	if( !is_array($value) ){
		$value = json_decode($value,true);
	}

	if( !is_array($value) ){
		$value = [];
	}else{
		$value = array_flip($value);
	}

	if( !isset($name) ) $name = $key;

	if( !isset($message_null) ) $message_null = 'You must check at least one checkbox';

	if( isset($layout) && $layout === 'horizontal' ){
		$layout_class = 'd-inline';
	}else{
		$layout_class = 'd-block';
	}
 ?>


<input type="hidden" value="[]" checked="checked" name="{!!$name!!}">

@foreach($list_option as $k => $o)
<div class="checkbox {!!$layout_class!!} @if($toggle) ckb @endif " id="{!!$key!!}">
  <label><input type="checkbox" value="{!!$k!!}" @if(isset($value[$k])) checked="checked" @endif name="{!!$name!!}[]">{!!$o['title']??$o!!}</label> &nbsp;
</div>
@endforeach

@if( isset($required) && $required)
<?php 
	add_action('vn4_footer',function() use ($name, $message_null){
		?>
		<script>
			$(window).load(function(){
				$(document).on('submit','form:not(.form-rel)',function(event) {

					if ( $(this).find('input[name="{!!$name!!}[]"]').length > 0 ){

						checked = $(this).find('input[name="{!!$name!!}[]"]:checked').length;
				      	if( checked < 1) {
					        alert("{!!$message_null!!}");
							event.preventDefault();
					        return false;
				      	}
			      	}
				});
			});
		</script>
		<?php
	});
 ?>
@endif