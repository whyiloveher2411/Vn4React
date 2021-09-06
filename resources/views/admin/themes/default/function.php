<?php

function add_meta_box( $id, $title, $post_type_add_meta, $type , $priority, $callback_html ,  $callback_save, $argParameter = array() ){

	if( isset($argParameter['callback_title']) ){
		dd('function add_meta_box');
	}

	$mock_action = 'add_meta_box_left';

	if( $type === 'right' ){

		$mock_action = 'add_meta_box_right';

		if( isset($argParameter['positions']) && $argParameter['positions'] === 'top' ){
			$mock_action = 'add_meta_box_right_top';
		}

	}  

	add_action($mock_action, function($customePostConfig, $post, $post_type) use ( $id,$title,$post_type_add_meta,$callback_html, $argParameter ) {

		if( is_callable($post_type_add_meta) ){
			$post_type_add_meta = $post_type_add_meta($customePostConfig, $post, $post_type);
		}

		if( $post_type_add_meta === null || $post_type_add_meta === true || ( is_string($post_type_add_meta) && $post_type === $post_type_add_meta ) || ( is_array($post_type_add_meta) &&  in_array($post_type , $post_type_add_meta) !== false)  ){
			?>
			<div class="x_panel form-input-<?php echo $id; ?>" id="<?php echo $id; ?>" style="<?php echo $argParameter['x_panel_style']??''; ?>">
				<input type="text" hidden name="vn4_check_meta_<?php echo $id; ?>" value="<?php echo time(); ?>">
				<div class="x_title">

					<h2><?php if( is_string($title)) echo $title; elseif ( is_callable($title) ) echo $title($customePostConfig, $post, $post_type);  ?></h2>
					<ul class="nav navbar-right panel_toolbox">
						<?php if( isset($argParameter['toolbox']) ) echo $argParameter['toolbox']($customePostConfig, $post, $post_type); 
							if ( is_callable($callback_html) ){
						 ?>
						<li>
							<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<?php
						}
						?>
					</ul>
					<div class="clearfix"></div>
				</div>
				<?php 
				if ( is_callable($callback_html) ){
					echo '<div class="x_content">';
					call_user_func_array ( $callback_html,[$customePostConfig, $post, $post_type] );
					echo '</div>';
				}
				?>
			</div>
			<?php

		}
		return $post;

	},$priority);

	add_action('saved_post',function($post, $request, $admin_object) use ($id,$post_type_add_meta,$callback_save){

		if( Request::has('vn4_check_meta_'.$id) ){

			$value = call_user_func_array ( $callback_save,[$post, $request] );

			if( $value ){
				return $value;
			}

		}

		return $post;

	},$priority);

}

function vn4_tabs_left($tabs,  $new_link = false, $id = ''){

	$param = get_param('vn4-tab-left-'.$id,false);

	$tab_current = Request::get('vn4-tab-left-'.$id,key($tabs));
	if( !isset($tabs[$tab_current]) ){ $tab_current = key($tabs); }

	if( !$param ) $param = '?vn4-tab-left-'.$id.'='; else $param = '?'.$param.'&vn4-tab-left-'.$id.'=';


	if( $new_link ){
		?>
		<div class="vn4_tabs_left" data-id="<?php echo $id; ?>">
			<div class="menu-left">
				<ul>
					<?php foreach( $tabs as $key_tab => $tab ): ?>
					<li  class="<?php echo $tab['class']??''?> <?php if($tab_current === $key_tab): ?> active <?php endif; echo 'tab_control_'.$key_tab; ?>"><a class="new-link" aria-controls="<?php echo $key_tab; ?>" href="<?php echo $param.$key_tab; ?>">
						<?php echo $tab['title']; ?>
					</a></li>
				<?php endforeach; ?>

				</ul>
			</div>
			<div class="content-right">
				<div class="tab <?php echo $tabs[$tab_current]['class']??''?> content-item content-tab-<?php echo $tab_current; ?> active " >

					<?php $tabs[$tab_current]['content'](); ?>

				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
	}else{
		?>
		<div class="vn4_tabs_left" data-id="<?php echo $id; ?>">
			<div class="menu-left">
				<ul>
					<?php foreach( $tabs as $key_tab => $tab ): ?>
					<li  class="<?php echo $tab['class']??''?> <?php if($tab_current === $key_tab): ?> active <?php endif; echo 'tab_control_'.$key_tab; ?>"><a aria-controls="<?php echo $key_tab; ?>" href="<?php echo $param.$key_tab; ?>">
						<?php echo $tab['title']; ?>
					</a></li>
				<?php endforeach; ?>

				</ul>
			</div>
			<div class="content-right">
				<?php foreach( $tabs as $key_tab => $tab ): ?>
				<div class="tab <?php echo $tab['class']??''?> content-item content-tab-<?php echo $key_tab; if($tab_current === $key_tab): ?> active <?php endif; ?> " >

					<?php $tab['content'](); ?>

				</div>

			<?php endforeach; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
	}

}

function vn4_tabs_top($tabs, $new_link = false, $id = ''){

	$param = get_param('vn4-tab-top-'.$id,false);

	$tab_current = Request::get('vn4-tab-top-'.$id,key($tabs));



	if( !$param ) $param = '?vn4-tab-top-'.$id.'='; else $param = '?'.$param.'&vn4-tab-top-'.$id.'=';

	if( $new_link ){

		if( strpos($tab_current, '_parent_') !== false ){
			$tab_current_arg = explode('_parent_', $tab_current);
			if( isset( $tabs[$tab_current_arg[0]]['submenu'][$tab_current_arg[1]]['content'] ) ){
				$content_tab_active = $tabs[$tab_current_arg[0]]['submenu'][$tab_current_arg[1]]['content']; 
			}else{

				$tab_current = key($tabs);

				if( !isset($tabs[$tab_current]['submenu']) ){
					$content_tab_active = $tabs[$tab_current]['content']; 
				}else{
					$content_tab_active = $tabs[$tab_current]['submenu'][key($tabs[$tab_current]['submenu'])]['content']; 
				}

			}

		}else{

			if( !isset($tabs[$tab_current]) ){ $tab_current = key($tabs); }

			if( !isset($tabs[$tab_current]['submenu']) ){
				$content_tab_active = $tabs[$tab_current]['content']; 
			}else{
				$content_tab_active = $tabs[$tab_current]['submenu'][key($tabs[$tab_current]['submenu'])]['content']; 
			}
		}

		?>
	<div class="vn4_tabs_top" data-id="<?php echo $id; ?>">
			<div class="menu-top">
				<?php 

				foreach( $tabs as $key_tab => $tab ): 
					if( isset($tab['submenu']) ) :
				?>

						<div class="dropdown" style="display:inline;">
						  <a href="javascript:void(0)" class="drop-menu <?php if(isset($tab_current_arg) && $tab_current_arg[0] === $key_tab ): ?>  active <?php endif; echo 'tab_control_'.$key_tab; ?>" aria-controls="<?php echo $key_tab; ?>" data-toggle="dropdown"><?php echo $tab['title']; ?>
						  <span class="caret"></span></a>
						  <ul class="dropdown-menu">
							
							<?php 
								foreach ($tab['submenu'] as $k => $v) {
									?>
						    	<li><a href="<?php echo $param.$key_tab.'_parent_'.$k; ?>" class="new-link <?php if($key_tab.'_parent_'.$k === $tab_current): ?>  active <?php endif; echo 'tab_control_'.$key_tab.'_parent_'.$k; ?>" aria-controls="<?php echo $key_tab.'_parent_'.$k; ?>" ><?php echo $v['title']; ?></a></li>
									<?php
								}
							 ?>

						  </ul>
						</div>
				<?php 
					else:
				 ?>

					<a href="<?php echo $param.$key_tab; ?>" class="new-link <?php if($key_tab === $tab_current): ?>  active <?php endif; echo 'tab_control_'.$key_tab; ?>" aria-controls="<?php echo $key_tab; ?>" ><?php echo $tab['title']; ?></a>
					
			<?php  endif;
			endforeach; ?>

		</div>

		<div class="content-bottom">

			<div class="content-item tab-content-<?php echo $tab_current; ?> active">

				<?php $content_tab_active(); ?> 

				<div class="clearfix"></div>
			</div>

		</div>
		<div class="clearfix"></div>
	</div>
	<?php
	}else{
		if( strpos($tab_current, '_parent_') !== false ){
			$tab_current_arg = explode('_parent_', $tab_current);

			if( !isset( $tabs[$tab_current_arg[0]]['submenu'][$tab_current_arg[1]]['content'] ) ){

				$tab_current = key($tabs);

				if( isset($tabs[$tab_current]['submenu']) ){
					$tab_current = $tab_current.'_parent_'. key($tabs[$tab_current]['submenu']);
				}

			}

		}else{

			if( !isset($tabs[$tab_current]) ){ $tab_current = key($tabs); }

			if( isset($tabs[$tab_current]['submenu']) ){
				$tab_current = $tab_current.'_parent_'. key($tabs[$tab_current]['submenu']);
			}
		}
	?>
	<div class="vn4_tabs_top" data-id="<?php echo $id; ?>">
		<div class="menu-top">
			<?php foreach( $tabs as $key_tab => $tab ):

			if( isset($tab['submenu']) ) :
				?>

						<div class="dropdown" style="display:inline;">
						  <a href="javascript:void(0)" class="drop-menu <?php if(isset($tab_current_arg) && $tab_current_arg[0] === $key_tab ): ?>  active <?php endif; echo 'tab_control_'.$key_tab; ?>" aria-controls="<?php echo $key_tab; ?>" data-toggle="dropdown"><?php echo $tab['title']; ?>
						  <span class="caret"></span></a>
						  <ul class="dropdown-menu">
							
							<?php 
								foreach ($tab['submenu'] as $k => $v) {
									?>
						    	<li><a href="<?php echo $param.$key_tab.'_parent_'.$k; ?>" class="<?php if($key_tab.'_parent_'.$k === $tab_current): ?>  active <?php endif; echo 'tab_control_'.$key_tab.'_parent_'.$k; ?>" aria-controls="<?php echo $key_tab.'_parent_'.$k; ?>" ><?php echo $v['title']; ?></a></li>
									<?php
								}
							 ?>

						  </ul>
						</div>
				<?php 
					else:
				 ?>
			
					<a href="#" class=" <?php if($key_tab == $tab_current): ?>  active <?php endif; echo 'tab_control_'.$key_tab; ?>" aria-controls="<?php echo $key_tab; ?>" ><?php echo $tab['title']; ?></a>
			<?php endif; endforeach; ?>
		</div>
		<div class="content-bottom">

			<?php foreach ($tabs as $key_tab => $tab): 

				if( isset($tab['submenu']) ) :

					foreach ($tab['submenu'] as $k => $v) {

						?>
						<div class="content-item <?php echo 'tab-content-'.$key_tab.'_parent_'.$k; if($key_tab.'_parent_'.$k == $tab_current): ?> active <?php endif; ?> ">

							<?php $v['content'](); ?> 

							<div class="clearfix"></div>
						</div>
						<?php
					}
			?>
			
			<?php else: ?>
			
			<div class="content-item <?php echo 'tab-content-'.$key_tab; if($key_tab == $tab_current): ?> active <?php endif; ?> ">

				<?php $tab['content'](); ?> 

				<div class="clearfix"></div>
			</div>

			<?php endif; endforeach; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
	}

}


function vn4_setting_template($data){

 	$key_last = array_key_last($data);

 	echo '<div class="setting-warper">';
 	foreach ($data as $key => $content) {
 		?>
 		<div class="setting_template setting-<?php echo $key; ?>">
	 		<div class="col-left col-md-3">
	 			<h2><?php echo $content['title']; ?></h2>
		 		<p><?php echo $content['description']; ?></p>
 			</div>
 			<div class="col-right col-md-9">

 				<?php 
 					foreach ($content['contents'] as $right) {

 						echo '<div class="content-right">';
 						$right();
 						echo '</div>';

 					}
 				 ?>
 			</div>
	 	</div>
 		<?php

 	}
 	echo '</div>';
}


function vn4_panel($title, $content = null , $plugin_collapse = true,  $plugin = null, $arrayParamert = array()){
	?>
	<div class="x_panel" style="<?php echo $arrayParamert['x_panel_style']??''; ?>">
		<?php if( $title ): ?>
		<div class="x_title <?php echo isset($arrayParamert['class_title'])?$arrayParamert['class_title']:'' ?>">
			<?php if( is_string($title)) echo $title; elseif(is_callable($title)) echo $title(); ?>
				<?php if( isset($arrayParamert['callback_title']) && is_callable($content) ) $arrayParamert['callback_title'](); ?>
			<ul class="nav navbar-right panel_toolbox">
				<?php if( is_string($plugin)) echo $plugin; elseif(is_callable($plugin)) $plugin(); ?>

				<?php 
				if( $plugin_collapse === true ){
					echo '<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>';
				}
				?>

			</ul>
			<div class="clearfix"></div>
		</div>
		<?php endif; if( $content ): ?>
		<div class="x_content" style="<?php if( !$title ){echo "display: block;";}echo $arrayParamert['x_panel_content']??''; ?>" >
			<?php if( is_string($content)) echo $content; elseif(is_callable($content)) $content(); ?>
		</div>
		<?php endif; if( isset($arrayParamert['footer']) ): ?>
			<div class="x_footer">
				<?php $arrayParamert['footer'](); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="clearfix"></div>
	<?php
}


if( !function_exists('vn4_register_tool')){

	function vn4_register_tool($callback){


		add_action('vn4_register_tool',function() use ($callback) {

			$input = $callback();

			if( !isset($input[0]) ){
				$title = '';$description = ''; $id = str_random(10);$link = '#';
				extract($input);

				?>
				<div class="x_panel" id="<?php echo $id; ?>">
					<div class="x_title">
						<h2><label><?php echo $title; ?></label></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<p class="note"><?php echo $description; ?></p><br>
						<a class="vn4-btn vn4-btn-blue" href="<?php echo $link; ?>"><?php echo $button; ?></a>
					</div>
				</div>
				<?php
			}else{
				foreach ($input as $tool) {
					$title = '';$description = ''; $id = str_random(10);$link = '#';
					extract($tool);

					?>
					<div class="x_panel" id="<?php echo $id; ?>">
						<div class="x_title">
							<h2><label><?php echo $title; ?></label></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<p class="note"><?php echo $description; ?></p><br>
							<a class="vn4-btn vn4-btn-blue" href="<?php echo $link; ?>"><?php echo $button; ?></a>
						</div>
					</div>
					<?php
				}
			}
		});
	}
}
