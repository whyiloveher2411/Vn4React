<?php add_action('vn4_footer',function() use ($param)  { 
?>

<div class="modal" id="modal-many-record" role="dialog" style="max-width: 100%;">
  	<div class="modal-dialog" style="position: relative;">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo asset(''); ?>admin/images/close-24px.svg"></button>
	        <h4 class="modal-title">Data</h4>
	      </div>
	      <div class="modal-body" style="height: auto;">
				
	      </div>
	  </div><!-- /.modal-dialog -->
	</div>
</div>

<script type="text/javascript">
	$(window).load(function(){


		$('body').on('click','.show-many-record',function(){

			$('.show-many-record.selected').removeClass('selected');
			$(this).addClass('selected');
			let href = window.location.href;
			$('#modal-many-record .modal-body').html('<iframe style="width:100%;" onload="resizeIframe(this)" seamless frameborder="0" scrolling="no" src="<?php echo route('admin.page','many-record'); ?>?'+ href.substring(href.indexOf('?') + 1) +'&'+jQuery.param($(this).data())+'"></iframe>');
			$('#modal-many-record').modal('show');
		});

		$('body').on('click','.remove-item-relationship',function(event){
			event.stopPropagation();

			$parent = $(this).closest('.show-many-record');
			$(this).parent().remove();

			let values = [];

			if( $parent.children().length < 1 ){
				$parent.html('Click to add');
			}else{
				let $input = $parent.find('input');
				for (let i = 0; i < $input.length; i++) {
					values.push($input[i].value);
				}
			}

			if( fnstring = $parent.data('onchange') ){

				var fn = window[fnstring];

				// is object a function?
				if (typeof fn === "function") fn( values );

			}

		});
	});
</script>
<?php 

});