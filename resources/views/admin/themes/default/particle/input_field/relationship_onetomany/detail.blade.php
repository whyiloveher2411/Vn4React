<?php
$post_relationship = get_post($object,$value);
?>

@if( $post_relationship )
	<a target="_blank" href="{!!route('admin.create_data',['post'=>$post_relationship->id,'type'=>$post_relationship->type,'action_post'=>'detail'])!!}">{!!$post_relationship->title!!}</a>
@else
	(None Object)
@endif