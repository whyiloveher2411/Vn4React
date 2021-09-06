<?php 
	$list_element_group = [];
	$style_class_show = [];

	if( !$value || !isset($list_group[$value]) ){
		$value = key($list_group);
		$style_class_show = reset($list_group);
	}

	foreach($list_group as $k => $g){
		$list_element_group = array_merge($list_element_group,$g);
		if( $value === $k ) $style_class_show = $g;
 	}

 ?>

 <div class="btn-group btn-group-toggle group-type-warpper" data-group="{!!'.form-input-'.implode(',.form-input-',$list_element_group)!!}" data-toggle="buttons">
 	@foreach($list_group as $k => $g)
	<label class="btn btn-default {!! $value == $k ? 'btn-primary':'' !!} ">
	    <input class="input-group-type" style="" type="radio" name="{!!$key!!}" autocomplete="off" value="{!!$k!!}" data-group="{!!'.form-input-'.implode(',.form-input-',$g)!!}" {!! $value == $k ? 'checked':'' !!}> {!!$k!!}
  	</label>
 	@endforeach
</div>

<?php 
	add_action('vn4_head',function() use ($list_element_group, $style_class_show){
		?>
		<style>
			{!!'.form-input-'.implode(',.form-input-',$list_element_group)!!}{
				display: none;
			}
			{!!'.form-input-'.implode(',.form-input-',$style_class_show)!!}{
				display: block;
			}
		</style>
		<?php
	},'input-group-type-css',true);

add_action('vn4_footer',function() {
	?>
	<script>
		$(window).load(function(){

			$(document).on('change','.input-group-type',function(event) {
				$(this).closest('.btn-group').find('.btn-primary').removeClass('btn-primary');
				$(this).closest('.btn').addClass('btn-primary');
				$($(this).closest('.group-type-warpper').data('group')).slideUp(400);
				$($(this).data('group')).slideDown(400);
			});
		});
	</script>
	<?php
},'input-group-type',true);
