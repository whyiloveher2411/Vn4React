<?php 
// Template Name: Quick Post
// Icon: fa-pencil-square-o
 ?>


@if( isset($setting) && $setting )

	

	<?php 

		$post_type = isset($widget['data']['post_type']) && $widget['data']['post_type']? $widget['data']['post_type'] :false;
		$fields = isset($widget['data']['fields']) && $widget['data']['fields']? $widget['data']['fields'] :['title'];

		$post_types = get_admin_object();

		$options = '';

		foreach ($post_types as $key => $value) {
			if( $key !== 'user' ){
				$options .= '<option '.($post_type === $key ? 'selected="selected"':'').' value="'.$key.'">'.$value['title'].'</option>';
			}
		}

	

	 ?>



	 <div class="form-group">

		<label>Section</label>

		<p>Which section do you want to pull recent entries from?</p>

		<select name="data[post_type]" class="form-control" style="width:auto;max-width: 100%;">

			{!!$options!!}			

		</select>
		
	</div>
	
	@if( isset($post_types[$post_type]) )
	<div class="form-group">

		<label>Fields</label>

		<p>Which fields should be visible in the widget?</p>
		
		@foreach( $post_types[$post_type]['fields'] as $key => $field )
		@if( $key !== 'title' )
		<div><label ><input name="data[fields][]" value="{!!$key!!}" @if( array_search($key,$fields) !== false) checked="checked" @endif type="checkbox"> {!!$field['title']!!}</label></div>
		@endif
		@endforeach
		
	</div>
	@endif


	

@else



<?php 

	$post_type = isset($widget['data']['post_type']) && $widget['data']['post_type']? $widget['data']['post_type'] :false;
	$fields = isset($widget['data']['fields']) && $widget['data']['fields']? $widget['data']['fields'] :['title'];

	View::share(['postDetail'=>null]);
	
    $action_post = false;

    $hasPost = false;
	

	if( !$post_type || !($admin_object = get_admin_object($post_type)) ){

		echo 'Please install to use the widget';

		return;

	}
	
	$postTypeConfig = $admin_object;

	$post = null;
?>



<div class="content-warper">


	<form method="POST" id="form_create" action="{!!route('admin.create_data',$post_type)!!}">
		<input type="hidden" name="_token" value="{!!csrf_token()!!}">
	<div class="widget-heading">

	    <h2>

	    	Post a new {!!$admin_object['title']!!} entry

	    </h2>

	</div>

	<div class="body">
	 @foreach($admin_object['fields'] as $key => $field)

      	<?php 
			
			if( $key !== 'title' && array_search($key, $fields) === false ) continue;

    		if( !isset($field['view']) ) $field['view'] = 'input';

				if( $field['view'] === 'hidden' ) continue;



         	$field['key'] =  $key;

     		$field['type_post'] =  $post_type;

 		?>



		@if( !isset($field['not_create_and_update']) || $field['not_create_and_update'] !== true )

		

          <div class="form-group form-field form-input-{!!$key!!}">

            <label class="label-input" for="{!!$key!!}"> {!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif

            </label>
             <?php 

             	$field['value'] = '';

				$action = do_action($post_type.'_fields_'.$key, $field, null);

			 ?>

			 @if( $action )

				{!!$action!!}

			 @else

				{!!get_field($field['view'], $field, null)!!}

			 @endif



            @if($field['view'] != 'image')

            <p class="note">{!!@$field['note']!!}</p>

            @endif

             <div class="clearfix"></div>

          </div>

		@endif

      @endforeach

		<button type="submit" class="vn4-btn vn4-btn-blue">Save</button> <button class="vn4-btn">Cancel</button>

	</div>
	
	</form>
</div>



@endif

