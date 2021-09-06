@extends(backend_theme('master'))

<?php 
    title_head(__('Dashboard'));
 ?>
@section('content')
<h1 class=" title-master">
	<ul class="pull-right advance-feature widget-manage">
		<li class="dropdown ">
			<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-plus"></i> New widget</a>
			<ul class="dropdown-menu dropdown-menu-right" role="menu">
				
				<?php 

					Cache::forget('widgets-admin-dashboard');

					$templateWidget = Cache::rememberForever('widgets-admin-dashboard', function(){

						if( file_exists( $dashboard_theme = cms_path('resource','views/themes/'.theme_name().'/inc/dashboard.php') ) ){
							include $dashboard_theme;
					  	}
						$plugins = plugins();
						foreach ($plugins as $plugin) {
						  if( file_exists( $dashboard_plugin = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/dashboard.php')) ){
						    include $dashboard_plugin;
						  }
						}

						$file_page = glob(cms_path('resource').'/views/admin/themes/'.$GLOBALS['backend_theme'].'/particle/dashboard/*.blade.php');
						sort($file_page);
		
						foreach ($file_page as $page) {
							$v = basename($page,'.blade.php');
							if( $v === 'index' ) continue;
			              	$name = capital_letters($v);
			              	$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
			              	$file_get_contents = file_get_contents( $page );
			              	preg_match( '|Template Name:(.*)$|mi', $file_get_contents, $header );
			              	if( isset($header[1]) ){
			                  	$name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
			              	}
		
							$icon = 'fa-life-ring';
							preg_match( '|Icon:(.*)$|mi', $file_get_contents, $header );
			              	if( isset($header[1]) ){
			                  	$icon = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
			              	}
			              	$templateWidget[$v] = [
								'title'=>$name,
								'icon'=>$icon,
								'view'=>backend_theme('particle.dashboard.'.$v)
			              	];

						}
						$templateWidget = apply_filter('widgets-admin-dashboard',$templateWidget);
						return $templateWidget;
					});
					
				 ?>
			 	@foreach($templateWidget as $key => $page)
					<li><a href="javascript:void(0)" class="widget-item" data-type="{!!$key!!}"><label><i class="fa {!!$page['icon']!!}" aria-hidden="true"></i>&nbsp;&nbsp; {!!$page['title']!!}</label></a></li>
		       	@endforeach
			</ul>
		</li>
	</ul>
</h1>
<style type="text/css">
	.message-warper, .vn4-message{
		display: none !important;
	}
	.container.body .right_col{
		padding: 0;
	}
	.box-content{
		background: white;
		padding: 10px;
	}
	.dashboard-grid .item{
	    border: 2px transparent solid;
		break-inside: avoid;
	 	background: #fff;
	    position: relative;
	    padding: 24px;
	    border-radius: 4px;
	    word-wrap: break-word;
	    -webkit-box-sizing: border-box;
	    box-sizing: border-box;
		display: flex;
	    /*align-items: center;*/
    	/*justify-content: center;*/
	}

	.dashboard-grid .pene{
		width: 100%;
		position: relative;
	}

	.dashboard-wrapper {
		column-gap: 5px;
		column-count: 5;
			display: grid;
		grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
		grid-column-gap: 2.5px;
	}
	.widget-heading h2{
      	margin: 0 0 15px 0;
  	}
	.dashboard-wrapper  div {
	}  
	.light{
		color: #7b8793 !important;
		font-weight: normal;
	}
	.dashboard-wrapper .two {

	}
	.list-icon{
		position: absolute;
	    right: 8px;
	    top: 8px;
	    z-index: 9;
        font-size: 15px;
        color: #b2c3d4;
        opacity: 0;
		transition: opacity linear 200ms;
	}
	.icon{
		cursor: pointer;
		float: left;
		margin-left: 3px;
	}
	.icon:hover{
        color: #7b8793;
	}
	.dashboard-wrapper .item:hover .list-icon{
		opacity: 1;

	}

	.dashboard-grid {
	  display: grid;
	  grid-template-columns: repeat(12, 1fr);
	  grid-gap: 10px;
	  grid-auto-rows: minmax(180px, auto);
      grid-auto-columns: 12.5%;
	  grid-auto-flow: dense;
	}

	.row-2{
	  grid-row-end: span 2;
	}
	.row-3{
	  grid-row-end: span 3;
	}
	.row-4{
	  grid-row-end: span 4;
	}
	.row-5{
	  grid-row-end: span 5;
	}

	@for( $i = 1; $i <= 12; $i++ )
	.col-{!!$i!!}{
	  grid-column-end: span {!!$i!!};
	}
	@endfor
	fieldset {
	    padding: .35em .625em .75em;
	    margin: 0 2px;
	    border: 1px solid silver;
	}
	legend{
		display: inline;
	    font-size: inherit;
	    padding: 0 5px;
	    border: none;
	    width: auto;
	    margin: 0;
	    line-height: 16px;
	}

</style>

<?php 
	$dashboard_widgets = json_decode( setting('admin-dashboard-widgets'), true );

	if( !is_array($dashboard_widgets) || !isset($dashboard_widgets['position']) ){
		$dashboard_widgets = [ 'data'=>[],'position'=>[] ];
	}

	if( isset($dashboard_widgets['position']) ){

		$result = [];

		foreach ($dashboard_widgets['position'] as $key => $value) {
			if( isset($dashboard_widgets['data'][$value]) ){
				$dashboard_widgets['data'][$value]['index'] = $value;
				$result[] = $dashboard_widgets['data'][$value];
			}
		}

		$dashboard_widgets = $result;

	}else{

		function partition(Array $list, $p) {
		    $listlen = count($list);
		    $partlen = floor($listlen / $p);
		    $partrem = $listlen % $p;
		    $partition = array();
		    $mark = 0;
		    for($px = 0; $px < $p; $px ++) {
		        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
		        $partition[$px] = array_slice($list, $mark, $incr);
		        $mark += $incr;
		    }
		    return $partition;
		}

		foreach ($dashboard_widgets['data'] as $key => $value) {
			if( !isset($value['type']) || !$value['type'] ){
				unset($dashboard_widgets['data'][$key]);
			}
		}

		$dashboard_widgets = partition($dashboard_widgets['data'],5);

	}

	$index = 0;
 ?>
 <div style="min-height: 500px;">
<div class=" dashboard-grid dashboard-wrapper" >
	@foreach($dashboard_widgets as $c => $widget)
		@if( isset($widget['type']) && $widget['type'] && isset($templateWidget[ $widget['type'] ]) )
	 	<div style="{!!isset($widget['data']['style'])?e($widget['data']['style']):''!!}" class=" item row-{!!isset($widget['data']['row'])?$widget['data']['row']:1!!} col-{!!isset($widget['data']['column'])?$widget['data']['column']:1!!}" data-index="{!!isset($widget['index'])?$widget['index']:$index!!}" data-type="{!!$widget['type']!!}">
	 	<?php $index++; ?>
	 		<div class="list-icon pull-right">
				<span class="move-icon icon"><i class="fa fa-arrows" aria-hidden="true"></i></span>
				<span class="settings-icon icon "><i class="fa fa-cog"></i></span>
				<span class="remove-icon icon "><i class="fa fa-times"></i></span>
			</div>
			<div class="pene">
				@include( $templateWidget[ $widget['type'] ]['view'], ['widget'=>$widget])
            </div>
		</div>
		@endif
	@endforeach
</div>
</div>
@stop

@section('js')
    <link href="{!!asset('vendors/colorpicker')!!}/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <script src="{!!asset('vendors/colorpicker')!!}/js/bootstrap-colorpicker.js"></script>

	<script type="text/javascript">
		$(window).load(function(){
			var isInIframe = (window.location != window.parent.location) ? true : false;
    		if(!isInIframe){
    			window.location.href = '{!!route('admin.index')!!}';
    		}
			function update_height_iframe(){
				var body = document.body,
                html = document.documentElement;
                var height = $('.right_col').height();
                document.body.style.height = height + 'px';
				$('#iframe-dashboard',window.parent.document).css({'height': height+'px'});
			}

			$('.widget-manage').on('click','.widget-item',function(){

				$.ajax({
					url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'add-widget'])!!}',
					data:{
						_token: '{!!csrf_token()!!}',
						type: $(this).data('type')
					},
					success:function(result){

						if( result.message ){

							window.parent.show_message(result.message);

							
						}else{
							$('.dashboard-grid').append('<div class=" item " data-index="'+result.index+'" data-type="'+result.type+'" ><div class="list-icon pull-right"><span class="move-icon icon"><i class="fa fa-arrows" aria-hidden="true"></i></span><span class="settings-icon icon "><i class="fa fa-cog"></i></span><span class="remove-icon icon "><i class="fa fa-times"></i></span>				</div><div class="pene">'+result.content+'</div></div>');
							change_position_widget();
							update_height_iframe();
						}
					}
				});

			});

			$(document).on('click','form button[type=submit]',function() {
		        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
		        $(this).attr("clicked", "true");
		    });

			$('.dashboard-wrapper').on('submit','form.from-setting',function( event ){

				event.preventDefault();
				let data = $(this).serializeArray(), $this = $(this), $item = $this.closest('.item');
				let val = $("button[type=submit][clicked=true]").val();
				data.push({name:'action',value:val});
				data.push({name:'_token',value:'{!!csrf_token()!!}'});
				data.push({name:'index',value: $(this).closest('.item').data('index')});

				$.ajax({
					url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'edit-widget'])!!}',
					data:data,
					success:function(result){

						if( result.message ){
							window.parent.show_message(result.message);
						}else{

							$this.closest('.pene').animate({'opacity':'0'},300,function(){
								console.log(result);
								$this.closest('.pene').html(result.content).animate({'opacity':1},300);
								$item.removeClass('col-1 col-2 col-3 col-4 col-5 col-6 col-7 col-8').addClass('col-'+result.column);
								$item.removeClass('row-1 row-2 row-3 row-4 row-5').addClass('row-'+result.row);
							});
						}

					}
				});



			});

			$('.dashboard-grid').on('click','.settings-icon',function( event ){
				let data = {index: $(this).closest('.item').data('index')}, $this = $(this);
				data._token = '{!!csrf_token()!!}';
				$.ajax({
					url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'edit-widget'])!!}',
					data:data,
					success:function(result){
						if( result.message ){
							window.parent.show_message(result.message);
						}else{
							$this.closest('.item').find('.pene').animate({'opacity':'0'},300,function(){

								$this.closest('.item').find('.pene').html(result.content).animate({'opacity':1},300);

							});
						}
						// $this.closest('.pene').html(result.content);
					}
				});

			});
			
			$('.dashboard-grid').on('change','[name="data[column]"]',function(){
				$(this).closest('.item').removeClass('col-1 col-2 col-3 col-4 col-5 col-6 col-7 col-8').addClass('col-'+$(this).val());
				update_height_iframe();
			});

			$('.dashboard-grid').on('change','[name="data[row]"]',function(){
				$(this).closest('.item').removeClass('row-1 row-2 row-3 row-4 row-5').addClass('row-'+$(this).val());
				update_height_iframe();
			});

			$('.dashboard-grid').on('change','[name="data[style]"]',function(){
				$(this).closest('.item').attr('style',$(this).val());
				update_height_iframe();
			});

			$('.dashboard-grid').on('click','.remove-icon',function(){
				var r = confirm("Are you sure!");
                if (r == true) {

                    let $this = $(this);
					$.ajax({
						url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'remove-widget'])!!}',
						data:{
							_token: '{!!csrf_token()!!}',
							index: $this.closest('.item').data('index'),
						},
						success:function(result){
							if( result.message ){
								window.parent.show_message(result.message);
							}else{
								if( result.success ){
									$this.closest('.item').remove();
									update_height_iframe();
								}
							}
							// $this.closest('.pene').html(result.content);
						}
					});
                }
			});
			function change_position_widget(){
				let data = [];
				// $('.dashboard-grid .col').each(function(index, el){
				// 	let column = [];

					$('.dashboard-grid .item').each(function(index2, el2){

						data.push($(el2).data('index'));

					});

					// data.push(column);
				// });

				$.ajax({
					url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'update-position-widget'])!!}',
					data:{
						_token:'{!!csrf_token()!!}',
						position: data,
					},
					success:function(result){
						if( result.message ){
							window.parent.show_message(result.message);
						}

						console.log(result);
						// $this.closest('.pene').html(result.content);
					}
				});
			}

			//Begin: repeater
            var script = document.createElement('script');

            script.onload = function () {
               $( ".dashboard-grid" ).sortable({
                handle:'.move-icon',
                connectWith: ".dashboard-grid",
                stop:function(event, ui){
                    ui.item.attr('style','');
                	$('.item').css({'border':'2px transparent solid'});
                },
                start:function(event,ui){
                	$('.item').css({'border':'2px #dedede dashed'});
                    ui.placeholder.height(ui.item.height() - 4);

                },
                update: function(event, ui) {
                	$('.item').css({'border':'2px transparent solid'});
                	// if(ui.sender) {
                		change_position_widget();
		            // }
                },
                change:function(event, ui){
					update_height_iframe();
                }
               });
            };

            script.src = $('meta[name="domain"]').attr('content')+'/admin/js/jquery-ui.min.js';
            document.head.appendChild(script);
            

            $('.title-master .pull-left',window.parent.document).append('<i style="font-size:11px;" class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;<div class="dropdown"><a href="?dashboard=google-realtime" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Google Realtime</a><ul class="dropdown-menu dropdown-menu-right" role="menu"><li><a href="javascript:void(0)" class="widget-item" data-type="feed"><label>Google Realtime</label></a></li><li><a href="javascript:void(0)" class="widget-item" data-type="feed"><label>Google Analytics</label></a></li><li><a href="javascript:void(0)" class="widget-item" data-type="feed"><label>System Dashboard</label></a><li><a href="javascript:void(0)" class="widget-item" data-type="feed"><label>Sale Dashboard</label></a></li></li></ul></div>');
		});
	</script>
@stop