<?php 
	title_head(__('Language'));
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
	<div class=" max-width-1000 margin-center">
	<?php 
		vn4_setting_template([
			'post-type'=>[
				'title'=>'Custom post types',
				'description'=>'Activate languages and translations for custom post types.',
				'contents'=>[
					function() use ($plugin, $__env) {
						$admin_object = get_admin_object();

						$post_type_actived = $plugin->getMeta('custom-post-types');

						if( !is_array($post_type_actived) ) $post_type_actived = [];

						 ?>
						 <div class="row">
						 @foreach($admin_object as $key => $a)
							<div class="col-xs-6 col-md-4">
								<label><input type="checkbox" @if( array_search($key, $post_type_actived) !== false ) checked="checked" @endif  name="post-type[]" value="{!!$key!!}"> {!!$a['title']!!}</label>
							</div>
						 @endforeach
						 </div>
						 <?php
					}
				]
			]
		]);
	 ?>
		<input style="margin-left:10px;" data-message="The process is running, please wait a moment" type="submit" class="vn4-btn vn4-btn-blue pull-right" name="save-change" value="@__('Save changes')">
		<div class="clearfix"></div>
	 </div>
</form>
@stop
