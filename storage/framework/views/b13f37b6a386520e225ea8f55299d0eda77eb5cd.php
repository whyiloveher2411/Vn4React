<?php $is_link_admin =  is_admin(); ?>

<?php if( $is_link_admin || (Auth::check() &&  Auth::user()->getMeta('active_show_toolbar') && Auth::user()->customize_time < time() )): ?>


<?php
	$request = request();
	function get_sidebar_admin_object(){
		// return Cache::rememberForever('__9__get_sidebar_admin_object_nav-top.blade.php', function() {


            if ( isset($GLOBALS['function_helper_get_sidebar_admin_object']) ){
		        return $GLOBALS['function_helper_get_sidebar_admin_object'];
		    }
		    $sidebar = Cache::rememberForever('get_sidebar_admin_object', function(){
		    	return include public_path().'/../resources/views/admin/themes/'.$GLOBALS['backend_theme'].'/data/sidebar_admin.php';
			});
		   
		    $GLOBALS['function_helper_get_sidebar_admin_object'] = $sidebar;

		    return $sidebar;

        // });
	    
	}
 ?>

<?php if(!$is_link_admin): ?>
	<input type="text" id="laravel-token" value="<?php echo csrf_token(); ?>" hidden>
<?php endif; ?>

<link href="<?php echo asset('vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet"><link href="<?php echo asset('admin/css/nav-top-login.css'); ?>" rel="stylesheet">

<div class="vn4-nav-top-login" id="vn4-nav-top-login">
	
	<ul>
		<?php if($is_link_admin): ?>
		<li class="menu-toggle"><a href="#" class="menu_toggle not-href"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
		<?php endif; ?>
		

		<li class="li-title hidden-xs">
			
			<?php if($is_link_admin): ?>
				<a href="<?php echo route('index'); ?>" target="_blank" ><i class="fa fa-home" aria-hidden="true"></i><?php echo setting('general_site_title'); ?></a>

				<div class="sub-menu multi-site">

				</div>
			<?php else: ?> 
				<a href="#" class="not-href"><i class="fa fa-tachometer" aria-hidden="true"></i><?php echo setting('general_site_title'); ?></a>
				<div class="sub-menu menu-admin">
					<ul>
						<?php 
							function get_sidebar_admin_quick($list_sidebar)
						    {
						        $str = '';

						        foreach ($list_sidebar as $key1 => $sidebar) {
						            
						            $icon = isset($sidebar['icon'])?$sidebar['icon']:'fa-pencil';

						            $symbols_submenu = isset($sidebar['submenu'])?'<span class="fa fa-chevron-down"></span>':'';

						            if(isset($sidebar['url'])){
						                $href = $sidebar['url'];
						                $str = $str.'<li class="li-title"><a href="'.$href.'"><i class="fa '.$icon.' "></i> '.$sidebar['title'].$symbols_submenu.' </a>';
						            }else{
						                $str = $str.'<li class="li-title"><a><i class="fa '.$icon.' "></i> '.$sidebar['title'].$symbols_submenu.' </a>';
						            }

						            if(isset($sidebar['submenu'])){

						                $str = $str.'<div class="sub-menu"><ul>';

						                foreach($sidebar['submenu'] as $key2 => $value){

						                    $hasSubmenu = isset($value['submenu']);

						                    if($hasSubmenu){
						                        $str = $str.'<li class="li-title"><a>'.$value['title'].$symbols_submenu.'</a>';
						                    }else{
						                        $str = $str.'<li class="li-title"><a href="'.$value['url'].'">'.$value['title'].'</a>';
						                    }

						                    if($hasSubmenu){

						                        $str = $str.'<div class="sub-menu"><ul>';
						                         foreach($value['submenu'] as $key3 => $value3){
						                            $str = $str.'<li class="li-title">
						                                            <a href="'.$value3['url'].'">'.$value3['title'].'</a>
						                                        </li>';
						                         }

						                        $str = $str.'</ul></div>';
						                    }

						                    $str = $str.'</li>';
						                }
						                $str = $str.'</ul></div>';
						            }
						            $str = $str.'</li>';
						        }

						       return $str;

						    }
						 ?>
						<?php echo get_sidebar_admin_quick(get_sidebar_admin_object()['data']); ?>

					</ul>
				</div>
			<?php endif; ?> 
		</li>

		<li class="li-title">
	 		<a href="<?php echo route('admin.page',['page'=>'plugin']); ?>" style="line-height: 59px;">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path style="fill: white;" d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/></svg>
			</a>
		</li>


		<li class="li-title hidden-xs"><span><a href="#" class="not-href"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('New'); ?></a></span>
			<div class="sub-menu">
				<?php 
					$object = get_admin_object();
				 ?>
				<ul>

					 <?php $__currentLoopData = $object; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 	<?php if( ( isset($value['button_new_toolbar']) && $value['button_new_toolbar']) && (!isset($value['layout']) || ( is_string($value['layout']) && $value['layout'] === 'create_data' ) || ( is_array($value['layout']) && array_search('create_data',$value['layout']) !== false )) && check_permission($key.'_create') ): ?>
						<li><a href="javascript:void(0)" data-title="Create <?php echo e($value['title']); ?>" data-popup="1" data-iframe="<?php echo route('admin.create_data',['type'=>$key]); ?>"><?php echo $value['title']; ?></a></li>
						<?php endif; ?>
					 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
				</ul>
			</div>
		</li>
		<li class="li-title hidden-xs"><a href="#" class="not-href"><i class="fa fa-wrench" aria-hidden="true"></i><?php echo __('Tool'); ?></a>
			<div class="sub-menu">

				<a data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'render-model','rel'=>'nav-top']); ?>"><i class="fa fa-cubes" aria-hidden="true"></i> <?php echo __('Render Model'); ?></a>
				<a data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'check-database','rel'=>'nav-top']); ?>"><i class="fa fa-check" aria-hidden="true"></i> <?php echo __('Check Database'); ?></a>
				<a data-image="<?php echo asset('/admin/images/image-backup.png'); ?>" data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'backup-database','rel'=>'nav-top']); ?>"><i class="fa fa-database" aria-hidden="true"></i> <?php echo __('Backup Database'); ?></a>
				<a href="<?php echo route('admin.page',['page'=>'restore-database']); ?>"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo __('Restore Database'); ?></a>
				<a data-image="<?php echo asset('/admin/images/image-loading-deploy-asset.svg'); ?>" data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'develop-asset','rel'=>'nav-top']); ?>"><i class="fa fa-files-o" aria-hidden="true"></i> <?php echo __('Deploy asset'); ?></a>
				<a data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'minify-html','rel'=>'nav-top']); ?>"><i class="fa fa-check" aria-hidden="true"></i> <?php echo __('Minify View'); ?></a>
				<a data-image="<?php echo asset('/admin/images/image-loading-refresh-view.svg'); ?>" data-message="<?php echo e(__('The process is running, please wait a moment')); ?>" href="<?php echo route('admin.page',['page'=>'tool-genaral','action'=>'refresh-views','rel'=>'nav-top']); ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo __('Refresh views'); ?></a>
				
				<a data-popup="1" href="#" data-title="Cache Management" data-iframe="<?php echo route('admin.page',['page'=>'cache-management']); ?>"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __('Cache Management'); ?></a>

				
				<?php 
					do_action('vn4_adminbar_tool');
				 ?>

			</div>
		</li>
		<?php 
			do_action('vn4_adminbar',$is_link_admin);
	 	?>
	 	<li class="li-title hidden-xs hidden-sm form-search" aria-hidden="true">
			<input type="search" autocomplete="off" class="form-control " id="inputSearch" placeholder="<?php echo e(__('Enter something')); ?>" name="search" data-url="<?php echo route('admin.controller',['controller'=>'search','method'=>'index']); ?>">
			<i class="fa fa-search" aria-hidden="true"></i>

			<div class="sub-menu sub-menu-search">
				<p>Nothing</p>
			</div>
		</li>
		<?php 
			$user = Auth::user();
          	$src = get_media($user->profile_picture, asset('admin/images/face_user_default.jpg'), 'nav-top');
          	$user_mode = $user->getMeta('admin_mode',['light-mode',__('Light Mode')]);

          	$url_change_mode = route('admin.controller',['controller'=>'user','method'=>'set-user-mode-view']);
       ?>
		<li class="li-img  li-right" > <a href="#" class="not-href"><?php echo __('Hello'); ?>, <?php echo $user->last_name,' ',$user->first_name; ?> <img data-src="<?php echo $src; ?>" class="img-user icon-img"></a> 
			
			<div class="sub-menu action-user display-flex">
				<div class="vn4-user-image-left">
					<a href="<?php echo route('admin.page',['page'=>'profile']); ?>" style="height: auto;padding: 0;"><img class="vn4-img-user" data-src="<?php echo $src; ?>"></a>
				</div>
				<div class="vn4-user-action-right">
					<a href="<?php echo route('admin.page','profile'); ?>" style="text-transform: capitalize;"><?php echo $user->role; ?></a>
					<a data-popup="1" href="#" data-title="<?php echo e(__('Profile')); ?>" data-iframe="<?php echo route('admin.page',['page'=>'profile']); ?>"><?php echo __('Edit My Profile'); ?></a>
					<a href="<?php echo route('logout'); ?>"><?php echo __('Log Out'); ?></a>
				</div>
			</div>
		</li>


		<li class="li-title hidden-xs li-right"><span><a href="#" class="not-href"><?php echo $user_mode[1]; ?> <i class="fa fa-eye" aria-hidden="true"></i></a></span>
			<div class="sub-menu">
				<ul>
					<li><a class="ajax not-href" href="#" data-url="<?php echo $url_change_mode; ?>?mode=light-mode&name=Light+Mode"><?php echo __('Light Mode'); ?></a></li>
					<li><a class="ajax not-href" href="#" data-url="<?php echo $url_change_mode; ?>?mode=dark-mode&name=Dark+Mode"><?php echo __('Dark Mode'); ?></a></li>
				</ul>
			</div>
		</li>
		<?php 
			do_action('nav-top');
		 ?>
	 	<li class="li-title hidden-xs li-right"><a href="#" id="notify" class="not-href notify"><i class="fa fa-bell" aria-hidden="true"></i></a>
	 		<div class="sub-menu" style="min-width: 400px;padding: 0px;box-shadow: 0 3px 8px rgba(0, 0, 0, .25);border-radius: 0 0 4px 4px ;">
				<table style="width: 100%;border-radius: 0 0 4px 4px;overflow: hidden;"  >
					<tbody id="notify-menu">
						
					</tbody>
				</table>
			</div>
		</li>

	</ul>
</div>

<?php 
	echo '<div class="data-iframe" data-url="'.route('admin.page',['page'=>'tool-genaral','action'=>'check-notify']).'"></div>';
 ?>
<?php endif; ?>
