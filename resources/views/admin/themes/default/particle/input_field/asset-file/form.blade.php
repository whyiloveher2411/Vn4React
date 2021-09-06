<?php 
	use_module('filemanager');
 ?>
<div class="form-group input-file">


	<textarea hidden class="file_result input_file_asset" name="{!!isset($name)?$name:$key!!}">{{ is_array($value) ? json_encode($value) : $value }}</textarea>

	<div class="vn4-btn vn4-btn-img load-filemanager button_add_file_tiny" data-title="filemanager_title_file" data-field-id="filemanager_file_chose" data-type="2">
	    <i class="fa fa-file" aria-hidden="true"></i> Select File
	</div>

	<a href="#" class="preview_file" style="display: none;" target="_blank" ></a>

</div>

<?php 
	add_action('vn4_footer',function(){
		?>	
			<div class="modal-wapper-add-file popup-asset-file">
				<div class="" id="modal-add-file"  role="dialog" data-keyboard="false" data-backdrop="static">
				  	<div class="modal-dialog">
					    <div class="modal-content">

					      <div class="modal-header">
					        <button type="button" class="close add-image-btn-close" onclick="$('#add-file-btn-cancel').trigger('click');">×</button>
					        <h4 class="modal-title">Insert/edit File</h4>
					      </div>
					      <div class="modal-body">
							<div class="form-group">
								<label for="email">Source</label>
								<div style="position:relative;">
									<input type="url" id="filemanager_file_chose" class="form-control">
									<i class="fa fa-folder-open open-filemanager" data-field-id="filemanager_file_chose" data-type="2" aria-hidden="true"></i>
								</div>
							</div>
					      </div>
					      <div class="modal-footer">
					       	<button type="button" class="btn btn-primary" id="add-file-btn-ok">OK</button>
					        <button type="button" class="btn btn-default" id="add-file-btn-cancel" data-dismiss="modal">Cancel</button>
					    </div>
					  </div>
					</div>
				</div>
			</div>
		<?php
	}, 'modal_add_file_js',true);
 ?>
