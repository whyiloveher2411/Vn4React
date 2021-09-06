<?php 
	add_action('vn4_head',function() use ($plugin_keyword){
		?>
			<style>
				#seo_vn4 .icon-optimization{
					width: 20px;
				}
				#seo_vn4 .google-title-style{
					color: #1a0dab;
				    cursor: pointer;
				    font-size: 18px;
				    max-width: 600px;
				    margin-left: 50px;
				    position: relative;
				    cursor: pointer;
				}
				#seo_vn4 .google-title-style:hover{
					text-decoration: underline;
				}
				#seo_vn4 .google-url-style{
					color: #006621;
				    font-style: normal;
				 	margin-left: 50px;
				    font-size: 14px;
				    cursor: pointer;
				    max-width: 600px;
				    position: relative;
				    cursor: pointer;
				}

				#seo_vn4 .google-url-style:hover:after,#seo_vn4 .google-title-style:hover:after,#seo_vn4 .google-description-style:hover:after{
					content: "";
					display: inline-block;
					position: absolute;
				 	left: -20px;
    				top: -1px;
					width: 0; 
					height: 0; 
					border-top: 10px solid transparent;
					border-bottom: 10px solid transparent;
					border-left: 10px solid #dedede;
				}

				#seo_vn4 .google-description-style{
					min-height: 50px;
					line-height: 1.4;
				    word-wrap: break-word;
				    font-size: small;
				    font-family: arial,sans-serif;
				    color: #545454;
				 	margin-left: 50px;
				    max-width: 600px;
				    position: relative;
				    cursor: pointer;
				}
			</style>
		<?php
	},$plugin_keyword.'_css',true);

 ?>	
<div id="seo_vn4">
	<i class="fa fa-question-circle" aria-hidden="true"></i> {!!__p('Help Center',$plugin_keyword)!!} <i class="fa fa-chevron-down"></i> <span class="label label-success">@__('Coming Soon')</span>
	<hr>
	<?php 
		vn4_tabs_left([
			'tab-optimization'=>[
				'title'=>'<svg class="icon-optimization" version="1.1" xmlns:x="&amp;ns_extend;" xmlns:i="&amp;ns_ai;" xmlns:graph="&amp;ns_graphs;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" viewBox="0 0 30 47" enable-background="new 0 0 30 47" xml:space="preserve" alt=""><g id="BG_1_"></g><g id="traffic_light"><g><g><g><path fill="#5B2942" d="M22,0H8C3.6,0,0,3.6,0,7.9v31.1C0,43.4,3.6,47,8,47h14c4.4,0,8-3.6,8-7.9V7.9C30,3.6,26.4,0,22,0z M27.5,38.8c0,3.1-2.6,5.7-5.8,5.7H8.3c-3.2,0-5.8-2.5-5.8-5.7V8.3c0-1.5,0.6-2.9,1.7-4c1.1-1,2.5-1.6,4.1-1.6h13.4c1.5,0,3,0.6,4.1,1.6c1.1,1.1,1.7,2.5,1.7,4V38.8z"></path></g><g class="traffic-light-color traffic-light-red"><ellipse fill="#C8C8C8" cx="15" cy="23.5" rx="5.7" ry="5.6"></ellipse><ellipse fill="#DC3232" cx="15" cy="10.9" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="36.1" rx="5.7" ry="5.6"></ellipse></g><g class="traffic-light-color traffic-light-orange"><ellipse fill="#F49A00" cx="15" cy="23.5" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="10.9" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="36.1" rx="5.7" ry="5.6"></ellipse></g><g class="traffic-light-color traffic-light-green"><ellipse fill="#C8C8C8" cx="15" cy="23.5" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="10.9" rx="5.7" ry="5.6"></ellipse><ellipse fill="#63B22B" cx="15" cy="36.1" rx="5.7" ry="5.6"></ellipse></g><g class="traffic-light-color traffic-light-empty"><ellipse fill="#C8C8C8" cx="15" cy="23.5" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="10.9" rx="5.7" ry="5.6"></ellipse><ellipse fill="#C8C8C8" cx="15" cy="36.1" rx="5.7" ry="5.6"></ellipse></g><g class="traffic-light-color traffic-light-init"><ellipse fill="#5B2942" cx="15" cy="23.5" rx="5.7" ry="5.6"></ellipse><ellipse fill="#5B2942" cx="15" cy="10.9" rx="5.7" ry="5.6"></ellipse><ellipse fill="#5B2942" cx="15" cy="36.1" rx="5.7" ry="5.6"></ellipse></g></g></g></g></svg>',
				'content'=>function()  use ($post, $plugin,$data )  {
					
					echo view_plugin($plugin,'view.post-type.tab_optimization',['post'=>$post,'data'=>$data]);

				}
			],
			'tab-social'=>[
				'title'=>'<i class="fa fa-share-alt" aria-hidden="true"></i>',
				'content'=>function() use  ($post, $__env,$plugin,$data ) {

					echo view_plugin($plugin,'view.post-type.tab_social',['post'=>$post,'data'=>$data]);

				},
			],
			'tab-advanced'=>[
				'title'=>'<i class="fa fa-cogs" aria-hidden="true"></i>',
				'content'=>function(){
					echo '<span class="label label-success">'.__('Coming Soon').'</span>';
				}
			]
		],false,'config-seo');
	 ?>
</div>

<?php 	
add_action('vn4_footer',function(){
?>

	<script type="text/javascript">
		$(window).load(function(){

			$(document).on('change','#title',function(){
				$input = $('.google-title-input>input');
				if( !$input.val() || $input.data('change') ){
					$input.val($(this).val());
					$input.trigger('focusout');
					$input.data('change',1);
				}
				
			});	

			$(document).on('change','#form_create textarea:first',function(){

				$input = $('.google-description-input>textarea');
				if( !$input.val() || $input.data('change') ){
					$input.val($(this).val());
					$input.trigger('focusout');
					$input.data('change',1);
				}

			});
			
			$('.google-title-input input').focusout(function(){

				if( $(this).val() != '' ){
					$(this).data('change',0);
				}else{
					$(this).data('change',1);
					$(this).val($('#title').val());
				}

				$('.google-title-style').text($(this).val());
				window.__seo_google_focsin = false;
				$('.google-title-style').show();
				$('.google-title-input').hide();
			});


			$('.google-description-input textarea').focusout(function(){

				if( $(this).val() != '' ){
					$(this).data('change',0);
				}else{
					$(this).data('change',1);
					$(this).val($('#form_create textarea:first').val());
				}

				$('.google-description-style').text($(this).val());
				window.__seo_google_focsin = false;
				$('.google-description-style').show();
				$('.google-description-input').hide();
			});

			$(document).on('click','.google-title-input input',function(event){
				event.stopPropagation();
			});

			$(document).on('click','.google-description-input textarea',function(event){
				event.stopPropagation();
			});

			$(document).on('click',function(event){
				event.stopPropagation();
				if( !$(this).hasClass('google-title-style') && window.__seo_google_focsin ){
					window.__seo_google_focsin = false;
					$('.google-title-style').show();
					$('.google-title-input').hide();

					$('.google-description-style').show();
					$('.google-description-input').hide();
				}
			});

			$(document).on('click','.google-url-style',function(event){
				$('body,html').animate({
			        scrollTop: 0
			    }, 300, function(){
			    	$('#input_slug__slug__btn_edit').trigger('click');
			    	$('#input_slug__slug_content #input_slug__slug__edit input').trigger('focus');
			    });
			});

			window.__after_register_slug = function(data){
				$('.google-url-style').text(data.permalinks);
			};

			$(document).on('click','.google-title-style',function(event){
				event.stopPropagation();
				window.__seo_google_focsin = true;
				$(this).hide();
				$('.google-title-input').show();
			});

			$(document).on('click','.google-description-style',function(event){
				event.stopPropagation();
				window.__seo_google_focsin = true;
				$(this).hide();
				$('.google-description-input').show();
			});

		});
	</script>

<?php
},'vn4_seo_post_type',true)
 ?>