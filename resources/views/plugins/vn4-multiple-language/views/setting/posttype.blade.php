<form method="POST">
	<input type="hidden" value="{!!csrf_token()!!}" name="_token">
	<div class="row">
		<div class="col-md-2 col-xs-12">
	      <h3>Custom post types</h3>
	      <p class="note">Activate languages and translations for custom post types.</p>
	    </div>
	    <div class="col-md-10 col-xs-12" >
	    	 <div class="x_panel" style="background: white;padding: 10px;border-radius: 4px;">
			<?php 
				$admin_object = get_admin_object();

				$post_type_actived = $plugin->getMeta('custom-post-types');

				if( !is_array($post_type_actived) ) $post_type_actived = [];
			 ?>
			 @foreach($admin_object as $key => $a)
				<div class="col-xs-6 col-md-4">
					<label><input type="checkbox" @if( array_search($key, $post_type_actived) !== false ) checked="checked" @endif  name="post-type[]" value="{!!$key!!}"> {!!$a['title']!!}</label>
				</div>
			 @endforeach
			<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<hr>
	<input style="margin-left:10px;" type="submit" class="vn4-btn vn4-btn-blue" name="save-change" value="@__('Save changes')">
</form>