<?php
add_action('vn4_footer',function(){
	?>
		<style>
			.acpf_tabs_top{
			    background: transparent;
			    padding: 10px 2px 0 0;
			}
			.acpf_tabs_top a{
			    padding: 6px 10px;
			    border: #CCCCCC solid 1px;
			    border-bottom: 0 none;
			    font-size: 13px;
			    line-height: 27px;
			    margin: 0 8px 0 0;
			    color: #000;
			    border-color: #CCCCCC;
			    border-bottom-color: #F7F7F7;
			    padding-bottom: 7px;
			    margin-bottom: -1px;
			 	background: #E4E4E4;

			}

			.acpf_tabs_top a.active{
			    background: #f9f9f9;
			 }
			 .acpf_tab_input_warpper{

			 }
			 .acpf_tab_input_warpper .session_content_tab{
			    border: #CCCCCC solid 1px;
			    padding:10px;
			 }
		</style>
	<?php
},'acpf_tab_css',true);
add_action('vn4_footer',function(){
	?>
		<script>

			$(window).load(function(){

				window.___aptp_field_tab = [];
				$('.customfield-post').each(function(index, el) {
					
					var parent = false,name_tab_1 = '';

					$(el).attr('data-index',index);

					$(el).find('>.x_panel>.x_content>.form-aptp-field').each(function(index2, el2) {
						
						if( $(el2).hasClass('form-aptp-field-tab') ){

							if( parent === false ){

								$('<div class="acpf_tab_input_warpper"><div class="acpf_tabs_top" id="session_tab_'+$(el).data('id')+'">Session tab</div><div id="session_content_tab_'+$(el).data('id')+'" class="session_content_tab" ></div></div>').insertBefore($(el2));

								name_tab_1 = $(el2).data('key');

							}


							parent = $(el2).data('key');	

							if( !window.___aptp_field_tab[index] ){
								window.___aptp_field_tab[index] = {id:'session_tab_'+$(el).data('id'),tabs:''};
							}

							if( name_tab_1 === parent ){
								window.___aptp_field_tab[index].tabs += '<a id="'+parent+'" href="javascript:void(0)" class="active">'+$(el2).find('>label').text()+'</a>';
							}else{
								window.___aptp_field_tab[index].tabs += '<a id="'+parent+'" href="javascript:void(0)">'+$(el2).find('>label').text()+'</a>';
							}

							$(el2).remove();

						}else{

							if( parent !== false ){

								$(el2).attr('data-session',parent);

								$(el2).detach().appendTo('#session_content_tab_'+$(el).data('id'));

								if( name_tab_1 !==  parent){
									$(el2).hide();
								}

							}else{
								$(el2).addClass('not-on-tab');
							}
						}

					});

				});

				for (var i = 0; i < window.___aptp_field_tab.length; i++) {
					$('#'+window.___aptp_field_tab[i].id).html(window.___aptp_field_tab[i].tabs);
				};

				$(document).on('click','.acpf_tabs_top a',function(){
					$(this).closest('.acpf_tabs_top').find('.active').removeClass('active');
					$(this).addClass('active');
					$(this).closest('.customfield-post').find('>.x_panel>.x_content>.acpf_tab_input_warpper>.session_content_tab>.form-aptp-field:not(.not-on-tab)').hide();
					$(this).closest('.customfield-post').find('>.x_panel>.x_content>.acpf_tab_input_warpper>.session_content_tab>.form-aptp-field[data-session='+$(this).attr('id')+']').show();
				});
			});
		</script>
	<?php
},'acpf_tab_js',true);