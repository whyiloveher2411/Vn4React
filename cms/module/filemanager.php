<?php add_action('vn4_footer',function() use ($param) { 


	$argType = ['image'=>'1','file'=>'2','video'=>'3'];

	$typeDefault = 'image';

	$field_id = $param['field_id']??'image_field';

	$url = asset('filemanager/filemanager/dialog.php');
?> 



<div class="modal" id="filemanager-wapper"  role="dialog" style="max-width: 100%;margin-top: 32px;">
  	<div class="modal-dialog" style="max-width: 100%;position: relative;">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close close-iframe-filemanager"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></button>
	        <h4 class="modal-title" id="filemanager-title">Insert/edit image</h4>
	      </div>
	      <div class="modal-body" id="iframe-filemanager">
			
	      </div>
	  </div><!-- /.modal-dialog -->
	</div>
</div>

<script type="text/javascript">
	
	$('body').on('mouseover click','.load-filemanager',function(event){


		let filemanager_type = $(this).data('type'), multi = $(this).data('multi')?'1':'0', img = $(this).parent().find('img').attr('src');

		if( img ){
			img = '&image_detail='+ img.replace(/^.*\/\/[^\/]+/, '');
		}else{
			img = '';
		}

		let url = '<?php echo $url; ?>?type='+ filemanager_type + '&field_id=' + $(this).data('field-id')+'&multi='+multi+img;

		if( !window._filemanager_type ){
			window._filemanager_type = [];
		}

		$('#iframe-filemanager .filemanager-iframe').hide();

		if( window._filemanager_type.indexOf(url) < 0 ){

			window._filemanager_type.push(url);

			$('#iframe-filemanager').append('<iframe id="iframe-filemanager-'+window._filemanager_type.indexOf(url)+'" class="filemanager-iframe" width="100%" height="100%" src="'+url+'" frameborder="0"></iframe>');
		}else{
			$('#iframe-filemanager #iframe-filemanager-'+window._filemanager_type.indexOf(url)).show();
		}

	});

	$('body').on('click','.open-filemanager',function(event){

		if( $(this).data('title') ){
			$('#filemanager-title').html( window[$(this).data('title')]() );
		}else{
			$('#filemanager-title').html('Insert/edit image');
		}

		var callback = $(this).data('callback');

		if( callback ){
			window._callback_filemanager = callback;
		}else{
			window._callback_filemanager = false;
		}

		$('#filemanager-wapper').fadeIn();
	});


	function responsive_filemanager_callback(field_id){
		
		if( window._callback_filemanager ){
			var callback_string = window._callback_filemanager;
			window[callback_string](field_id);
		}else{
			$('#filemanager-wapper').fadeOut();
		}

	}


	$('body').on('click', '.close-iframe-filemanager', function(event) {
		event.preventDefault();
		$('#filemanager-wapper').fadeOut();
	});

</script>


<?php }, 'module_filemanager',true); ?>

