@foreach($post_type['fields'] as $k => $field)
<div class="form-group">
	<label>{!!$field['title']!!}</label>
	<?php 
		if( !isset($field['view'])) $field['view'] = 'text';
		$field['value'] = '';
		$field['key'] = $k;	
		$field['type_post'] = $type_post;
		$field['postDetail'] = 0;
	 ?>
	{!!get_field($field['view'], $field)!!}
</div>
@endforeach