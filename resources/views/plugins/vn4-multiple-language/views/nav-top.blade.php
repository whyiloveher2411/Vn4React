<li class="li-img li-right nav-top-lang" > 
	
	<?php 

		if( isset($GLOBALS['my_lang']) ){
			$my_lang = $GLOBALS['my_lang'];
		}


	 ?>
		
		@if( isset($my_lang) )
		<a href="#" class="not-href">{!!$my_lang['lang_name']!!}<img style="width: 16px;height: 11px;margin-top: 16px;" class="img-user icon-img" data-src="{!!plugin_asset($plugin, 'flags/'.$my_lang['flag'].'.png')!!}"></a> 
		@endif
	
	<div class="sub-menu list-lang">
		<p style="height: 32px;padding:0 10px;" ><i style="color: #4b4f56;" class="fa fa-spinner fa-spin "></i></p>
	</div>

</li>

<?php 
	add_action('vn4_footer',function() use ($plugin) {
		?>
			<script>
				$(window).load(function() {
					$('.nav-top-lang').mouseenter(function(event) {

						if(!$(this).hasClass('have-data')){
							var $this = $(this);
							vn4_ajax({'url':'{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'get-my-lang-backend'])!!}',callback:function(data){

								var $list_lang = $this.find('.list-lang:first');

								$list_lang.empty();

								for( key in data.langs ){
									$list_lang.append('<p><a class="chose-lang-default not-href" href="#" data="'+key+'"><img src="'+data.langs[key].flag+'" /> '+data.langs[key].name+'</a></p>');
								}
								
								$this.addClass('have-data');
							}});
						}
						
					});

					$('.nav-top-lang').on('click', '.chose-lang-default', function(event) {
						event.preventDefault();
						vn4_ajax({'url':'{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'languages','method'=>'set-my-lang-backend'])!!}',data:{lang:$(this).attr('data')}});
					});
				});
			</script>
		<?php
	});
 ?>