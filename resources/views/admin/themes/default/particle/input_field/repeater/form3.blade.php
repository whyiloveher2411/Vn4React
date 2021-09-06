<?php add_action('vn4_head',function(){ ?>

<style type="text/css">
	.group-input {
		position: relative;
	}
	.group-input .x_content{
		display: none;
	}
	
	.group-input .x_title{
		border-bottom: 1px solid #e6e6e6;
		cursor: pointer;
	}
	.group-input .x_title span:not(.move){
		margin-left: 30px;
	}
	.group-input .move{
        position: absolute;
	    top: 0;
	    left: 0;
	    bottom: 0;
	    width: 33px;
	    margin: 0;
	    color: #939393;
	    text-align: center;
	    font-size: 25px;
	    background: #dddfe2;
	    line-height: 33px;
	    cursor: move;
	}
	.group-input .move:hover{
		color: black;
	}
	.ui-sortable-helper{
		z-index: 999;
	}

</style>

<?php },'input_group_css',true) ?>

<?php
	
	$value = json_decode($value);

	$str = '<input type="hidden" name="{!!$key!!}[delete][]" value="1" class="input-trash">';
	$strTbody = '';
	foreach ($items as $key2 => $item) {
		$strTbody .= '<td>'.$item['title'].'</td>';
		$item['key'] = 'id_group_'.str_slug($key.'-'.$key2);
		$item['name'] = $key.'['.$key2.'][]';
		$item['value'] = '';
		$str .= '<div class="form-group"><label style="width: 100%;">'.$item['title'].get_field($item['view'], $item).'</label></div>';
	}

	$str_plugin_xpenl = '<li><a class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></li><li><a class=""><i class="fa fa-times" aria-hidden="true"></i></a></li>';

?>


<div class="group-input" id="group-input-{!!$key!!}" >

<div class="list-input">

	<table class="table table-bordered">

		<thead>
			<tr>
				{!!$strTbody!!}
			</tr>
		</thead>
	@if( $value )
		<?php 
			$count = count(reset($value));
		 ?>	
		
		@for( $i = 0; $i < $count ; $i++)
			<tr>

			<input type="hidden" name="{!!$key!!}[delete][]" value="{!!$value->delete[$i]!!}" class="input-trash">
				@foreach($items as $key2 => $item)
					<td>
					<?php 
						$item['key'] = 'id_group_'.str_slug($key.'-'.$key2);
						$item['name'] = $key.'['.$key2.'][]';

						if( isset($value->{$key2}[$i]) ){
							$item['value'] = $value->{$key2}[$i];
						}else{
							$item['value'] = '';
						}
					 ?>

					 	{!!get_field($item['view'], $item)!!}
					 </td>
				@endforeach

			</tr>
		@endfor

	@endif
	</table>




	@if( !$value )

	<?php vn4_panel('<h2><span class="move"><i class="fa fa-arrows-alt" aria-hidden="true"></i></span><span class="title">Item</span></h2>', function() use ($str) { ?><div class="input-group-new">{!!$str!!}</div><?php },true, $str_plugin_xpenl ); ?>

	@endif
</div>
<script type="text/template" id="script-template-{!!$key!!}"><?php vn4_panel('<h2><span class="move"><i class="fa fa-arrows-alt" aria-hidden="true"></i></span><span class="title">Item</span></h2>', function() use ($str) { ?><div class="input-group-new">{!!$str!!}</div> <?php },true, $str_plugin_xpenl ); ?> </script>

<a href="javascript:void(0)" data-template="script-template-{!!$key!!}" class="vn4-btn vn4-btn-blue add-group-item">Add Row</a>
<div class="clearfix"></div>
</div>





<?php add_action('vn4_footer',function(){ ?>
	<script type="text/javascript">
		
		$(window).load(function(){

			var script = document.createElement('script');
			script.onload = function () {
			   $( ".group-input .list-input" ).sortable({
			   	stop:function(event, ui){
			   		ui.item.attr('style','');
			   	},
			   	handle: ".move",
			   });
			};

			script.src = "{!!asset('public/admin/js/jquery-ui.min.js')!!}";

			document.head.appendChild(script);

			$(document).on('click','.group-input .x_title',function(event){

				$(this).find('.collapse-link').trigger('click');

			});
			$(document).on('click','.group-input .x_title .fa-trash-o',function(event){
				event.stopPropagation();
				$(this).closest('.x_title').toggleClass('btn-danger');

				if( $(this).closest('.x_title').hasClass('btn-danger') ){
					$(this).closest('.x_panel').find('.input-trash').val(0);
				}else{
					$(this).closest('.x_panel').find('.input-trash').val(1);
				}
			});
			$(document).on('click','.group-input .x_title .fa-times',function(event){
				$(this).closest('.x_panel').remove();
			});
			// $('.group-input').each(function(index,el){

			// 	$(el).find('input:first').addClass('style','background:red;');
			// 	if( $(el).find('input:first-child').val() ){
			// 		$(el).find('.x_title h2').text($(el).find('input:first-child').val());
			// 	}
			// });

			window.update_class_title_item = function(){
				$('.group-input .x_panel').each(function(index,el){
					$(el).find('input:not(.input-trash):first').addClass('change_title_item_group_input');
				});

				
			};
			update_class_title_item();

			$('.change_title_item_group_input').each(function(index,el){

				if( $( el ).val() ){ 
					$(el).closest('.x_panel').find('.x_title h2 .title').text($(el).val());
				}
			});

			// $('.group-input .form-group input:first-child').attr('style','background:red;');
			$(document).on('keyup','.change_title_item_group_input',function(){
				$(this).closest('.x_panel').find('.x_title h2 .title').text($(this).val());
			});

			$(document).on('click', '.group-input .add-group-item', function(event) {
				event.preventDefault();
				
				var element = $($('#'+$(this).data('template')).html());

				element.find('.x_content').css({'display':'block'});

				element.find('textarea.editor-content').attr('id','___change__id__group__input__'+$('textarea.editor-content').length);

				$(this).parent().find('.list-input').append(element);


			});
			window._group_input_open = function(){

				$('.group-input .x_content:has(.input-group-new)').css({display:'block'});
			};

			_group_input_open();

		});
	</script>
<?php },'input_group_js',true) ?>