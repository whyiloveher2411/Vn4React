<div class="customfield-post" data-id="{!!$customField->id!!}" {!!$show!!}>
    <style>
      .customfield-post .x_title {
        z-index: 0;
      }
    </style>
	<?php 

    vn4_panel($customField->title,function() use ($customField,$__env,$postType,$post, $plugin) {
		$fields = json_decode($customField->fields,true);
	 ?>

    	 @foreach($fields as $field)
    		<?php 
    			$key = 'aptp_'.$customField->id.'_'.$field['field_name'];
    		 ?>
    		<div class="form-group form-aptp-field form-aptp-field-{!!$field['field_type']!!} " data-key="{!!$key!!}">

          <label class="" for="{!!$key!!}"> {!!$field['title']!!}</label>
          <div class="vn4-pd0">
              <input type="hidden" name="aptp_field[]" value="aptp_meta_post_{!!$field['field_name']!!}">
              <?php 
                  $action = do_action($postType.'_fields_'.$key);
                  $field[$field['field_type']]['name'] = 'aptp_meta_post_'.$field['field_name'];
                  $field[$field['field_type']]['title'] = $field['title'];
                  $field[$field['field_type']]['required'] = $field['field_required'];
                  $field[$field['field_type']]['key'] = $key;
                  $field[$field['field_type']]['id'] = $customField->id;
                  $field[$field['field_type']]['value'] = $post?$post->getMeta('aptp_meta_post_'.$field['field_name']):'';
                  $field[$field['field_type']]['post'] = $post;
               ?>

               @if( $action )
                  {!!$action!!}
               @else
                  {!!view_plugin($plugin,'views.field-type.input.'.$field['field_type'], ['param'=>$field[$field['field_type']]])!!}
               @endif
              <p class="note">{!!$field['field_instructions']!!}</p>
          </div>
        </div>

    	 @endforeach

     <?php }); ?>
</div>