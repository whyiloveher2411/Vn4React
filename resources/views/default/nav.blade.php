<?php 
	$container_class = isset($arg['container_class'])?$arg['container_class']:'';
	$container_id = isset($arg['container_id'])?$arg['container_id']:'menu-'.$arg['key'];
	$container = isset($arg['container'])?$arg['container']:'ul';
	$link_before = isset($arg['link_before'])?$arg['link_before']:'';
	$show_wrap = isset($arg['show_wrap'])?$arg['show_wrap']:true;
	$depth = isset($arg['depth'])?$arg['depth']:100;
	$depth_current = isset($arg['depth_current'])?$arg['depth_current']:1;
	$callback_menu_item = isset($arg['callback_menu_item'])?$arg['callback_menu_item']:false;
	$class_li_child = 'sub';
	$class_ul_child = 'children';
	$icon_child = isset($arg['icon_child'])?$arg['icon_child']:'';
	$GLOBALS['url_current'] = url()->current();
	$active_class = isset($arg['active_class'])?$arg['active_class']:'active';

	$GLOBALS['function_show_menu_default'] = function($menu, $depth_current) use ($link_before, $callback_menu_item, $arg, $depth,$class_ul_child,$class_li_child,$icon_child,$active_class) {
		
		$count = count($menu);

		for ($i=0; $i < $count; $i++) { 

			$class = $GLOBALS['url_current'] === $menu[$i]['link']?$menu[$i]['classes'].' '.$active_class:$menu[$i]['classes'];

			if( $menu[$i]['posttype'] === 'menu-items' ){
				echo vn4_nav_menu_db( $menu[$i]['id'],null, array_merge($arg,['show_wrap'=>false,'depth_current'=>$depth_current]) );
			}else{

				if( ($depth_current + 1) > $depth && isset($menu[$i]['children']) ){
					unset($menu[$i]['children']);
				}
				
				if( $depth_current <= $depth ){

					if( $callback_menu_item ){

						$callback_menu_item($link_before.$menu[$i]['label'], $menu[$i]['link'],$class, $menu[$i]['attrtitle'], $menu[$i],$GLOBALS['function_show_menu_default'],array_merge($arg,['depth_current'=>$depth_current]));
					}else{
						if( isset($menu[$i]['children']) ){
							echo '<li class=" '.$class_li_child.' '.$class.'" ><a '.$menu[$i]['attrtitle'].' href="'.$menu[$i]['link'].'">'.$link_before.$menu[$i]['label'].$icon_child.'</a>';
							echo '<ul class="'.$class_ul_child.'">';
							$GLOBALS['function_show_menu_default']($menu[$i]['children'] , $depth_current + 1 );
							echo '</ul>';
						}else{
							echo '<li class="'.$class.'" ><a '.$menu[$i]['attrtitle'].' href="'.$menu[$i]['link'].'">'.$link_before.$menu[$i]['label'].'</a>';
						}
						echo '</li>';
					}
				}
			}
		}
	};

 ?>



@if( Auth::check() && Auth::user()->customize_time > time() - 1 )

	@if( $show_wrap )
	<{!!$container!!} id="{!!$container_id!!}" style="position: relative;" class="vn4-nav {!!$container_class!!}">
	<i onclick="parent.callNavMenu('{!!$arg['key']!!}')" class="fa fa-pencil customize-menu-icon" style="position: absolute;transform: translate(-110%,-50%);top: 50%;background: #0085ba!important;color: white;display: inline-block;width: 30px;height: 30px;font-size: 18px;line-height: 26px;text-align: center;border-radius: 50%;border: 2px solid;cursor: pointer;float:left;"></i>
	@endif

@else

@if( $show_wrap )
<{!!$container!!} id="{!!$container_id!!}" class="vn4-nav @if(isset($container_class)) {!!$container_class!!} @endif ">
@endif

@endif
  <?php $GLOBALS['function_show_menu_default']($menu,$depth_current); ?>

@if( $show_wrap )
</{!!$container!!}>
@endif
