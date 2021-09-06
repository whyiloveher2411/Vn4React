 @if($post)
	<?php 
		$admin_object = get_admin_object();
	 ?>
	<div style="display: flex;justify-content: space-between;align-items: center;"><a href="#" data='{"iframe_reload":"#simple-table_field_{!!$key!!} iframe"}' data-popup="1" href="#" data-title="Create {!!$admin_object[$object]['title']!!}" data-iframe="{!!route('admin.create_data',['type'=>$object,'relationship_field_'.$field=>$post->id])!!}" class="vn4-btn vn4-btn-blue">Create {!!$admin_object[$object]['title']!!}</a> <a href="javascript:void(0)" onclick="document.querySelector('#simple-table_field_{!!$key!!} iframe').contentDocument.location.reload(true);"><i class="fa fa-refresh" style="padding: 10px;background: #ddd;color: rgb(0, 0, 0,.5);border-radius: 4px;" aria-hidden="true"></i></a></div>

	<div id="simple-table_field_{!!$key!!}" class="data-iframe" data-name="simple-table" data-url="{!!route('admin.controller',['controller'=>'simple-table','method'=>'get', 'data_iframe'=>[
		'iframe_reload'=>'#simple-table_field_'.$key.' iframe'
	] ,'type'=>$object,'title'=>$title, 'post_related'=>[ 
	'type'=>$type_post, 'key'=>$key, 'id'=>$post->id
	]])!!}"></div>

@else
	
	(Create Post Before Add Data)

@endif

