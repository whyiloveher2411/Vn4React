<?php 
	title_head(__p('Create Connect Post', $plugin->key_word));
 ?>
@extends(backend_theme('master'))
@section('css')
	
	<style>
		.vn4_tabs_top>.content-bottom{
			background: none;
			border: none;
			padding: 0;
		}
		.menu-top{
		    border-bottom: 1px solid #ddd;
		}
	</style>

@stop
@section('content')

<form method="POST">
	<input type="hidden" value="{!!csrf_token()!!}" name="_token">
	<div class="row">
		<div class="col-md-2 col-xs-12">
	      <h3>Custom post types</h3>

	      <?php 
    	 	$custome_post_language = $plugin->getMeta('custom-post-types',[]);

    	 	$post_type = Request::get('post_type',$custome_post_language[0]??'');

    	 	$admin_object = get_admin_object();
    	  ?>

    	  <select class="form-control" id="post_type"> 
    	  @foreach($custome_post_language as $name)
    	  	@if( isset($admin_object[$name]) )
    	  	<option @if( $post_type === $name ) selected="selected" @endif value="{!!$name!!}">{!!$admin_object[$name]['title']!!}</option>
    	  	@endif
    	  @endforeach
    	  </select>

	      <p class="note">Select the post type you want to create connect.</p>
	    </div>
	    <div class="col-md-10 col-xs-12" >
	    	 @if( isset($admin_object[$post_type]) )
	    	 <?php 
	    	 	$languages = languages();

	    	 	$sub_fields = [];

	    	 	foreach ($languages as $v) {
	    	 		$sub_fields[$v['lang_slug']] = [
	    	 			'title'=>$v['lang_name'],
	    	 			'view'=>'relationship_onetoone',
	    	 			'object'=>$post_type,
	    	 			'excludeRelationshipOnetoone'=>false,
	    	 			'type'=>'many_record',
	    	 		];
	    	 	}

	    	 	echo get_field('repeater',[
	    	 		'title'=>'Post Connect',
	    	 		'key'=>'post-connect',
	    	 		'value'=>'',
	    	 		'sub_fields'=>$sub_fields
	    	 	]);
	    	  ?>
	    	 @endif
		</div>
	</div>
	<hr>
	<input style="margin-left:10px;" type="submit" class="vn4-btn vn4-btn-blue" name="save-change" value="@__('Save changes')">
</form>
@stop

@section('js')
	<script type="text/javascript">
		
		$(window).load(function(){
			$(document).on('change','#post_type',function(){
				window.location.href = replaceUrlParam(window.location.href, 'post_type',$(this).val());
			});
		});

	</script>
@stop