
<?php 
    if( !$post && isset($default_value ) ) $value = $default_value;

    $class = (!(isset($prepend) && $prepend) && !(isset($append) && $append))?'':'input-group';
 ?>

<div class="{!!$class!!}">
    @if( isset($prepend) && $prepend )
    <div class="input-group-addon">{!!$prepend!!}</div>
    @endif
    <input name="{!!isset($name)?$name:$key!!}" @if( isset($character_limit) && $character_limit) maxlength="{!!$character_limit!!}" @endif {!!isset($required) && $required?'required':''!!} value="{{$value}}" placeholder="{!!isset($placeholder)?$placeholder:''!!}" type="{!!isset($type)?$type:'text'!!}" id="{!!$key!!}" autocomplete="off" class="colorpicker form-control">
    @if( isset($append) && $append)
    <div class="input-group-addon">{!!$append!!}</div>
    @endif
</div>


<?php 

add_action('vn4_head',function(){
	?>
	    <link href="{!!asset('vendors/colorpicker')!!}/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<?php
},'colorpicker-css',true);

add_action('vn4_footer',function(){
	?>
    <script src="{!!asset('vendors/colorpicker')!!}/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript">
		$('.colorpicker').colorpicker({  });
	</script>
	<?php
},'colorpicker-js',true);
