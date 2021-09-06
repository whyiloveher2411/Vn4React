<?php
$post_relationship = get_post($field['object'],$value);
?>

@if( $post_relationship )
	<a href="#" data-popup="1" data-iframe="{!!route('admin.create_data',['post'=>$post_relationship->id,'type'=>$post_relationship->type,'action_post'=>'edit'])!!}" data-title="Editing: {{$post_relationship->title}}">{!!$post_relationship->title!!}</a>
@else
	(None Object)
@endif