<?php 

	use_module('filemanager');

	$multiple = isset($multiple)?$multiple:false;

	$ratio = isset($ratio)?$ratio:false;

	$width = isset($width)?$width:false;
	$max_width = isset($max_width)?$max_width:false;
	$min_width = isset($min_width)?$min_width:false;

	$height = isset($height)?$height:false;
	$max_height = isset($max_height)?$max_height:false;
	$min_height = isset($min_height)?$min_height:false;
	if( !isset($auto_resize) ) $auto_resize = [];

	if( is_string($value) ){
		$value = json_decode($value);
	}

	if( !is_array($value) && !is_object($value) ){
		$value = json_decode($value);
	}

	if( is_object($value) ){
		$value = (array)$value;
	}
	
 ?>

<div class="input-image-warpper @if( $multiple ) multi-able @endif" @if( isset($thumbnail) ) data-thumbnail="{{json_encode($thumbnail)}}" @endif data-size="@json($auto_resize)">
	<div class="button_add_img_tiny vn4-btn vn4-btn-img load-filemanager" data-width="{!!$width!!}" data-min-width="{!!$min_width!!}" data-multi="{!!$multiple!!}" data-max-width="{!!$max_width!!}" data-height="{!!$height!!}" data-min-height="{!!$min_height!!}" data-max-height="{!!$max_height!!}" data-ratio="{!!$ratio!!}" data-field-id="image_link" data-type="1">
	    <i class="fa fa-picture-o" aria-hidden="true"></i> @if( $multiple ) @__('Add photo') @else @__('Select an image') @endif
	</div>

	<div>
		<textarea hidden class="image-result" name="{!!isset($name)?$name:$key!!}">
			{!!json_encode($value)!!}
		</textarea>

		<div style="display:inline-block;width:100%;" class="image_preview default_input_img_result  image-clean" id="image_preview_{!!$key!!}">

            	@if( !$multiple )

					 @if( $value && is_array($value) )
					 	<?php 
						 	try {
					 			if( @$value['type_link'] === 'local' ){
					 				echo '<div class="item-image-resutl">'.image_lazy_loading(asset($value['link']), 'class="type-image-'.$value['type_link'].'"').'</div>';
					 			}else{
					 				echo '<div class="item-image-resutl">'.image_lazy_loading($value['link'], 'class="type-image-'.$value['type_link'].'"').'</div>';
					 			}
							} catch (Exception $e) {
							 	echo '<div class="item-image-resutl">'.image_lazy_loading(get_media(json_decode((json_encode($value)),true))).'</div>';
							}
					 	?>
					@else
						<div class="noImageSelected emptyButton" style="display: block;">No image selected<input type="file" multiple class="filemanager_uploadfile_direct" ></div>
					 @endif
				@elseif(!$value)
					<div class="noImageSelected emptyButton" style="display: block;">No image selected<input type="file" multiple class="filemanager_uploadfile_direct" ></div>
            	@endif



        </div>
    	<div class="clear-fix"></div>
	</div>
	


	<div class="note-image">
	    @if($multiple)
	      <p><span style="color:red">Note: </span> Can choose multiple images</p>
	    @endif
        <strong>
        @if($ratio)
            <p><span style="color:red">@__('Ratio'):</span> {!!$ratio!!}</p>
        @endif

        @if($width)
            <p><span style="color:red">@__('Width'):</span> {!!$width!!}px</p>
        @endif

        @if($max_width)
           <p><span style="color:red">@__('Max Width'):</span> {!!$max_width!!}px</p>
        @endif

        @if($min_width)
            <p><span style="color:red">@__('Min Width'):</span> {!!$min_width!!}px</p>
        @endif

        @if($height)
           <p><span style="color:red">@__('Height'):</span> {!!$height!!}px</p>
        @endif

        @if($max_height)
            <p><span style="color:red">@__('Max Height'):</span> {!!$max_height!!}px</p>
        @endif

        @if($min_height)
            <p><span style="color:red">@__('Min Height'):</span> {!!$min_height!!}px</p>
        @endif

        </strong>
    </div>

    
	
	@if( isset($thumbnail) )
		@foreach($thumbnail as $k => $v)
			<div>
			{!!capital_letters($k)!!} - 
			@if(isset($v['width'])) Width: {!!$v['width']!!}px @endif 
			@if(isset($v['height'])) Height: {!!$v['height']!!}px @endif 
			@if(isset($v['max_width'])) Max Width: {!!$v['max_width']!!}px @endif 
			@if(isset($v['max_height'])) Max Height: {!!$v['max_height']!!}px @endif 
			</div>
		@endforeach
	@endif


    @if( isset($auto_resize[0]) )
		@foreach($auto_resize as $a)
			<span class="size_thumb_item" style="    background: #dedede;
			    padding: 3px 7px;
			    display: inline-block;
			    margin:  3px 2px;
			    border: 1px solid;    border-radius: 3px;
			    text-align: center;">{!!$a[0],' x ',$a[1]!!}</span>
		@endforeach
    @endif
</div>


<?php 
	add_action('vn4_footer',function() {
		?>
		<div class="modal-wapper-add-image template-image">
			<div class="" id="modal-add-image"  role="dialog" data-keyboard="false" data-backdrop="static">
			  	<div class="modal-dialog">
				    <div class="modal-content">

				      <div class="modal-header">
				        <button type="button" class="close add-image-btn-close"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></button>
				        <h4 class="modal-title">Insert/edit image</h4>
				      </div>
				      <div class="modal-body">
						<div class="form-group">
							<label for="email">Source</label>
							<div style="position:relative;">
								<input type="url" id="image_link" class="form-control" style="padding-right: 45px;">
								<i class="fa fa-folder-open open-filemanager" data-callback="after_chose_image_filemanager" data-field-id="image_link" data-type="1" aria-hidden="true"></i>
							</div>
						</div>
				      </div>
				      <div class="modal-footer">
				       	<button type="button" class="btn btn-primary" id="add-image-btn-ok">OK</button>
				        <button type="button" class="btn btn-default" id="add-image-btn-cancel" data-dismiss="modal">Cancel</button>
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<?php
	}, 'modal_add_img_js',true);
 ?>