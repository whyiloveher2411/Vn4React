<!DOCTYPE html>
<html lang="{!!App::getLocale()!!}">
  <head>
    
    <link rel="icon" href="{!!asset('admin/favicon.ico')!!}">
    <?php
    $user = Auth::user();
    $mode =  $user->getMeta('admin_mode',['light-mode','Light Mode']);
    $class_body = $user->getMeta('collapse',false)?'collapse-body':'nav-md';
    do_action('admin_after_open_head'); 
    // $main_version*10000 + $minor_version *100 + $sub_version = mysqli_get_client_version();
    $isFrame = Request::has('iframe');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{!!strip_tags(vn4_one_or(do_action('title_head'),'Quản trị admin')),' &lsaquo; ',setting('general_site_title','Site title')!!}</title>
     <link href="@asset(vendors/bootstrap/css/bootstrap.min.css)" rel="stylesheet">
     <link href="@asset(admin/css/custom.min.css)" rel="stylesheet">
     <link href="@asset(admin/css/default.css)" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="{!!asset('admin/css/mode/'.$mode[0].'.css')!!}">
      <meta name="domain" content="{!!url('/')!!}">
      <meta name="url_create_thumbnail" content="{!!route('admin.controller',['controller'=>'image','method'=>'filemanager-create-thumbnail'])!!}">
      <meta name="url_load_more_js" content="{!!route('admin.controller',['controller'=>'javascript','method'=>'load-more'])!!}">
      <meta name="url_filemanagerUploadFileDirect" content="{!!route('admin.controller',array_merge(['controller'=>'image','method'=>'filemanager-upload-file-direct'],Route::current()->parameters()))!!}">
      <link href="@asset()vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"><link href="{!!asset('admin/css/nav-top-login.css')!!}" rel="stylesheet">
      <style type="text/css">
      	body.is-iframe, *{
      		margin: 0;
      		padding: 0;
      	}
		.card{
		    border-radius: 4px;
		    border: 1px solid #dddfe2;
		}
		.card-body {
		    flex: 1 1 auto;
		    min-height: 1px;
		    padding: 15px;
		}
		.text-grey {
		    color: #b6c2c9!important;
		}
		.row>[class^=col-] {
		    padding-left: 10px;
		    padding-right: 10px;
		}
		.text-truncate {
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		}
		.bg-teal {
		    background-color: #00acac!important;
		}
		.rounded-right {
		    border-top-right-radius: 4px!important;
		    border-bottom-right-radius: 4px!important;
		}
		.posttype-item{
	        width: 100%;
		    height: 100px;
		    border-radius: 4px;
		    padding: 15px 95px 15px 15px;
		    position: relative;
		    overflow: hidden;
		    background: white;
	        border: 1px solid #dddfe2;
		    color: #25405D;
		    border-left: 5px solid;
		}
		.posttype-item i{
		    position: absolute;
		    font-size: 60px;
		    top: 0;
		    right: 15px;
		    line-height: 100px;
		    opacity: .35;
		    text-align: right;
		}
		.posttype-item .title{
		    font-size: 20px;
		    line-height: 24px;
		    letter-spacing: normal;
		    overflow-wrap: normal;
		    text-align: left;
		}
		.posttype-item .count{
		    font-size: 32px;
			font-weight: bold;
		}
		.bg-white-transparent-2 {
		    border-color: rgba(0, 0, 0, 0.2)!important;
		}
		.bg-white{
			background: white;
			color:#25405D;
		}
		.system-item{
			line-height: 28px;
		}
		.fa-5 {
			font-size: 8em;
		}
		.posttype-item:hover i.fa-3dicon{
			/*transform-style*/
			-webkit-transform-style: preserve-3d;
			-moz-transform-style: preserve-3d;
			-ms-transform-style: preserve-3d;
			-o-transform-style: preserve-3d;
			transform-style: preserve-3d;
			/*perspective*/
			-webkit-perspective: 1000px;
			-moz-perspective: 1000px;
			-ms-perspective: 1000px;
			-o-perspective: 1000px;
			perspective: 1000px;
			/*Webkit*/
			-webkit-animation-name: rotate;
			-webkit-animation-duration:3s;
			-webkit-animation-timing-function: linear;
			-webkit-animation-iteration-count:infinite; 
			 -webkit-animation-fill-mode:both; 
			 /*mozilla*/
			-moz-animation-name: rotate;
			-moz-animation-duration:3s;
			-moz-animation-timing-function: linear;
			-moz-animation-iteration-count:infinite; 
			-moz-animation-fill-mode:both; 
			 /*Opera*/
			-o-animation-name: rotate;
			-o-animation-duration:3s;
			-o-animation-timing-function: linear;
			-o-animation-iteration-count:infinite; 
			-o-animation-fill-mode:both; 
			 /*IE 10*/
			-ms-animation-name: rotate;
			-ms-animation-duration:3s;
			-ms-animation-timing-function: linear;
			-ms-animation-iteration-count:infinite; 
			-ms-animation-fill-mode:both; 
			
			 /*Default*/
			animation-name: rotate;
			animation-duration:3s;
			animation-timing-function: linear;
			animation-iteration-count:infinite; 
			animation-fill-mode:both; 
			color:#25405D;
			opacity: 1;
		}
		@-webkit-keyframes rotate {
		 	0% {
				 text-shadow: 1px 1px 1px #CCC;
				 -webkit-transform: rotateY(0deg); 
			} 
		 
			25% {
				  text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC,-4px 1px 1px #CCC,
				 -5px 1px 1px #CCC,-6px 1px 1px #CCC,-7px 1px 1px #CCC,-8px 1px 1px #CCC,-9px 1px 1px #CCC,-10px 1px 1px #CCC,
				 -11px 1px 1px #CCC,-12px 1px 1px #CCC,-13px 1px 1px #CCC,-14px 1px 1px #CCC,-15px 1px 1px #CCC,-16px 1px 1px #CCC,
				 -17px 1px 1px #CCC,-18px 1px 1px #CCC,-19px 1px 1px #CCC,-20px 1px 1px #CCC; 
				 -webkit-transform: rotateY(40deg); 
			}
			50% {
				 text-shadow: 0px 0px 0px #CCC;
				 -webkit-transform: rotateY(0deg); 
			} 
		 
			75% {
				  text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC,4px 1px 1px #CCC,
				 5px 1px 1px #CCC,6px 1px 1px #CCC,7px 1px 1px #CCC,8px 1px 1px #CCC,9px 1px 1px #CCC,10px 1px 1px #CCC,
				 11px 1px 1px #CCC,12px 1px 1px #CCC,13px 1px 1px #CCC,14px 1px 1px #CCC,15px 1px 1px #CCC,16px 1px 1px #CCC,
				 17px 1px 1px #CCC,18px 1px 1px #CCC,19px 1px 1px #CCC,20px 1px 1px #CCC; 
				 -webkit-transform: rotateY(-40deg); 
			}
			100% {
				 text-shadow: 1px 1px 1px #CCC;
				 -webkit-transform: rotateY(0deg); 
			} 
		}
		@-moz-keyframes rotate {
		 	0% {
				 text-shadow: 1px 1px 1px #CCC;
				 -moz-transform: rotateY(0deg); 
			} 
		 
			25% {
				  text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC,-4px 1px 1px #CCC,
				 -5px 1px 1px #CCC,-6px 1px 1px #CCC,-7px 1px 1px #CCC,-8px 1px 1px #CCC,-9px 1px 1px #CCC,-10px 1px 1px #CCC,
				 -11px 1px 1px #CCC,-12px 1px 1px #CCC,-13px 1px 1px #CCC,-14px 1px 1px #CCC,-15px 1px 1px #CCC,-16px 1px 1px #CCC,
				 -17px 1px 1px #CCC,-18px 1px 1px #CCC,-19px 1px 1px #CCC,-20px 1px 1px #CCC; 
				 -moz-transform: rotateY(40deg); 
			}
			50% {
				 text-shadow: 0px 0px 0px #CCC;
				 -moz-transform: rotateY(0deg); 
			} 
		 
			75% {
				  text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC,4px 1px 1px #CCC,
				 5px 1px 1px #CCC,6px 1px 1px #CCC,7px 1px 1px #CCC,8px 1px 1px #CCC,9px 1px 1px #CCC,10px 1px 1px #CCC,
				 11px 1px 1px #CCC,12px 1px 1px #CCC,13px 1px 1px #CCC,14px 1px 1px #CCC,15px 1px 1px #CCC,16px 1px 1px #CCC,
				 17px 1px 1px #CCC,18px 1px 1px #CCC,19px 1px 1px #CCC,20px 1px 1px #CCC; 
				 -moz-transform: rotateY(-40deg); 
			}
			100% {
				 text-shadow: 1px 1px 1px #CCC;
				 -moz-transform: rotateY(0deg); 
			} 
		}
		@-o-keyframes rotate {
		 	0% {
				 text-shadow: 1px 1px 1px #CCC;
				 -o-transform: rotateY(0deg); 
			} 
		 
			25% {
				  text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC,-4px 1px 1px #CCC,
				 -5px 1px 1px #CCC,-6px 1px 1px #CCC,-7px 1px 1px #CCC,-8px 1px 1px #CCC,-9px 1px 1px #CCC,-10px 1px 1px #CCC,
				 -11px 1px 1px #CCC,-12px 1px 1px #CCC,-13px 1px 1px #CCC,-14px 1px 1px #CCC,-15px 1px 1px #CCC,-16px 1px 1px #CCC,
				 -17px 1px 1px #CCC,-18px 1px 1px #CCC,-19px 1px 1px #CCC,-20px 1px 1px #CCC; 
				 -o-transform: rotateY(40deg); 
			}
			50% {
				 text-shadow: 0px 0px 0px #CCC;
				 -o-transform: rotateY(0deg); 
			} 
		 
			75% {
				  text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC,4px 1px 1px #CCC,
				 5px 1px 1px #CCC,6px 1px 1px #CCC,7px 1px 1px #CCC,8px 1px 1px #CCC,9px 1px 1px #CCC,10px 1px 1px #CCC,
				 11px 1px 1px #CCC,12px 1px 1px #CCC,13px 1px 1px #CCC,14px 1px 1px #CCC,15px 1px 1px #CCC,16px 1px 1px #CCC,
				 17px 1px 1px #CCC,18px 1px 1px #CCC,19px 1px 1px #CCC,20px 1px 1px #CCC; 
				 -o-transform: rotateY(-40deg); 
			}
			100% {
				 text-shadow: 1px 1px 1px #CCC;
				 -o-transform: rotateY(0deg); 
			} 
		}
		 
		@keyframes rotate {
		 	0% {
				 text-shadow: 1px 1px 1px #CCC;
				 transform: rotateY(0deg); 
			} 
		 
			25% {
				  text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC,-4px 1px 1px #CCC,
				 -5px 1px 1px #CCC,-6px 1px 1px #CCC,-7px 1px 1px #CCC,-8px 1px 1px #CCC,-9px 1px 1px #CCC,-10px 1px 1px #CCC,
				 -11px 1px 1px #CCC,-12px 1px 1px #CCC,-13px 1px 1px #CCC,-14px 1px 1px #CCC,-15px 1px 1px #CCC,-16px 1px 1px #CCC,
				 -17px 1px 1px #CCC,-18px 1px 1px #CCC,-19px 1px 1px #CCC,-20px 1px 1px #CCC; 
				 transform: rotateY(40deg); 
			}
			50% {
				 text-shadow: 0px 0px 0px #CCC;
				 transform: rotateY(0deg); 
			} 
		 
			75% {
				  text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC,4px 1px 1px #CCC,
				 5px 1px 1px #CCC,6px 1px 1px #CCC,7px 1px 1px #CCC,8px 1px 1px #CCC,9px 1px 1px #CCC,10px 1px 1px #CCC,
				 11px 1px 1px #CCC,12px 1px 1px #CCC,13px 1px 1px #CCC,14px 1px 1px #CCC,15px 1px 1px #CCC,16px 1px 1px #CCC,
				 17px 1px 1px #CCC,18px 1px 1px #CCC,19px 1px 1px #CCC,20px 1px 1px #CCC; 
				 transform: rotateY(-40deg); 
			}
			100% {
				 text-shadow: 1px 1px 1px #CCC;
				 transform: rotateY(0deg); 
			} 
		}
		
      </style>
  </head>
  <body class="{!!$class_body!!} @yield('body-class')">
   <?php 
   		function formatBytes($size, $precision = 2)
		{
			if( !is_numeric($size) ) return $size;
		    $base = log($size, 1024);
		    $suffixes = array('', 'K', 'M', 'G', 'T');   
		    return round(pow(1024, $base - floor($base)), $precision) .' <small style="font-size: 9px;color: #b6c2c9;">'. $suffixes[floor($base)].'</small>';
		}
		
		$data =  Cache::remember( 'admin - dashboard', 3600, function(){
				function folderSize ($dir)
				{
				    $size = 0;
				    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
				        $size += is_file($each) ? filesize($each) : folderSize($each);
				    }
				    return $size;
				}
				$db_size = [];
				while ( !isset($db_size[0]) ) {
					$db_size = DB::table('information_schema.TABLES')
							->select('table_name as table_info',DB::raw('count(TABLE_SCHEMA) AS total_tables'), DB::raw('SUM(TABLE_ROWS) AS total_tables_row'),DB::raw('ROUND(sum(data_length + index_length)) AS db_size'),DB::raw('ROUND(sum( data_free )) AS free_space'))
							->where('TABLE_SCHEMA',env('DB_DATABASE'))
							->groupBy('TABLE_SCHEMA')
							->get();
				}
				$db_size = $db_size[0];
				 $version = mysqli_get_client_version();
			    $main_version =  intval( $version/10000 );
			    $minor_version = intval (($version - $main_version*10000)/100);
			    $sub_version = $version - $main_version*10000 - $minor_version*100;
			    $mysql_version = $main_version.'.'.$minor_version.'.'.$sub_version;
				// $mysql_version = DB::select( DB::raw("select version() as version") );
				// $mysql_version = $mysql_version[0]->version;
				// $mysql_version = explode('-', $mysql_version);
				// if( isset($mysql_version[1]) ){
				// 	$mysql_version = $mysql_version[0].'<small style="text-align: right;font-size: 9px;color: #b6c2c9;margin: 5px 2px;">'.$mysql_version[1].'</small>';
				// }else{
				// 	$mysql_version = $mysql_version[0].'<br>';
				// }
				
				$laravel = app();
				$laravel_version = $laravel::VERSION;
				if( file_exists($path_cms = cms_path('root','cms.json')) ){
					$info = json_decode(file_get_contents( $path_cms ),true);
					$cms = $info;
				}else{
					$cms = ['version'=>'1.0.0'];
				}
				$capacity = [];
				if( env('CACHE_DRIVER') === 'file' ){
					$configCache = Config::get('cache');
			   		$pathCache = $configCache['stores']['file']['path'];
					$capacity['cache'] = folderSize($pathCache);
				}else{
					$capacity['cache'] = __('(Not Found)');
				}
				$capacity['log'] = folderSize(cms_path('storage').'logs/'.$_SERVER['HTTP_HOST']);
				$capacity['view'] = folderSize(cms_path('storage').'framework/views/');
				$capacity['uploads'] = folderSize(cms_path('public','uploads'));
				$process = [];
				$list = File::directories(Config::get('view.paths')[0].'/plugins/');
	   			$listPlugin = Vn4Model::table(vn4_tbpf().'setting')->whereType('plugin')->where('status','publish')->pluck('key_word')->toArray();
	   			$pluginCount = ['all'=>0,'active'=>0];
			 	foreach ($list as $value) {
	   
					$folder_theme = basename($value);
					$fileName = $value.'/info.json';
					if( !file_exists( $fileName ) ){
					   continue;
					}
					$info = json_decode(File::get($fileName));
					if( array_search($folder_theme,$listPlugin) !== false ){
						$pluginCount['active'] ++;
					}
					$pluginCount['all'] ++;
			   	}
			   	$process['pluginCount'] = $pluginCount;
	            $fileName = cms_path('resource','views/themes/'.theme_name().'/info.json');
	            $themeInfo = [];
	            if( file_exists( $fileName ) ){
	              $themeInfo = json_decode(File::get($fileName), true);
	            }
	            if( !isset($themeInfo['name']) || !isset($themeInfo['version']) ){
	            	$themeInfo = [
	            		'name'=>__('(Not Found)'),
	            		'version'=>__('(Not Found)'),
	            	];
	            }
			   	$process['themeInfo'] = $themeInfo;
			   	$process['backup'] = folderSize(cms_path('storage').'cms/database/'.$_SERVER['HTTP_HOST']);
				$data = [
					'phpversion'=>phpversion(),
					'mysql_version'=>$mysql_version,
					'laravel_version'=>$laravel_version,
					'cms'=>$cms,
					'db_size'=>$db_size,
					'capacity'=>$capacity,
					'pluginCount'=>$pluginCount,
					'themeInfo'=>$themeInfo,
					'process'=>$process
				];
			return $data;
		});
   ?>
    <input type="text" id="laravel-token" value="{!!csrf_token()!!}" hidden>
    <input type="text" id="text-download" value="{{__('Download')}}" hidden>
    <input type="text" id="text-edit" value="{{__('Edit')}}" hidden>
    <input type="text" id="text-remove" value="{{__('Remove')}}" hidden>
    <input type="text" id="is_link_admin_vn4_cms" value="true" hidden>
   	<div class="container body">
        <div class="text-truncate" style="display: grid;grid-column-gap: 25px; grid-auto-flow: column;margin-bottom: 25px;">
        	<?php 
        		$get_admin_object = get_admin_object();
        	 ?>
        	 @foreach($get_admin_object as $key => $p)
        	 @if( isset($p['icon']) )
        	 <?php 
        	 	$count = get_posts($key, ['count'=>true]);
        	  ?>
    	  	<a href="{!!route('admin.show_data',['type'=>$key])!!}">
	        	<div class="posttype-item">
	        		<i class="{!!$p['icon']!!} fa-5 fa-3dicon"></i>
	        		<div class="title">{!!$p['title']!!}</div>
	              	<div class="count counting" data-count="{!!number_format($count)!!}">0</div>
	        	</div>
        	</a>
        	@endif
        	@endforeach
          
        </div>
  		<div style="display: flex;">
  			<div class="col-md-7 card border-0 mb-3 overflow-hidden bg-white" style="margin-right: 25px;">
			   <div class="card-body">
			      <div class="row">
			         <div class="col-md-7 col-lg-8">
			            <div class="mb-3 text-grey">
			               <!-- <b>SYSTEM</b> -->
			            </div>
			           	<br>
			           	<div class="systems" style="display: flex;justify-content: space-between;">
			           		<div class="system-item">
			           			SYSTEM 
			           			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
			           			PHP: {!!$data['phpversion']!!}<br>
			           			Mysql: {!!$data['mysql_version']!!}<br>
			           			Laravel: {!!$data['laravel_version']!!} <br>
			           			Vn4CMS: {!!$data['cms']['version']!!}
			           		</div>
			           		<div class="system-item">
			           			DATABASE
			           			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
			           			Tables: {!!$data['db_size']->total_tables!!} <br>
			           			Total Row: {!!$data['db_size']->total_tables_row!!} <br>
			           			Total Size: {!!formatBytes($data['db_size']->db_size)!!} <br>
			           			Free Space: <span style="">{!!formatBytes($data['db_size']->free_space)!!}</span>
			           		</div>
			           		<div class="system-item">
			           			CAPACITY
			           			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
			           			Cache: <a href="{!!route('admin.page','cache-management')!!}">{!!formatBytes($data['capacity']['cache'])!!}</a> <br>
			           			Log: <a href="{!!route('admin.page','log')!!}">{!!formatBytes($data['capacity']['log'])!!}</a> <br>
			           			View: {!!formatBytes($data['capacity']['view'])!!} <br>
			           			Upload: <a href="{!!route('admin.page','media')!!}">{!!formatBytes($data['capacity']['uploads'])!!}</a>
			           		</div>
			           		<div class="system-item">
			           			PROCESS
			           			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
			           			Plugin: <a href="{!!route('admin.page','plugin')!!}"><span><sup>{!!$data['process']['pluginCount']['active']!!}</sup>/<sub>{!!$data['process']['pluginCount']['all']!!}</sub></span></a><br>
			           			Theme: <a href="{!!route('admin.page','appearance-theme')!!}">{!!$data['process']['themeInfo']['name']!!} <small style="text-align: right;font-size: 9px;color: #b6c2c9;">({!!$data['process']['themeInfo']['version']!!})</small></a> <br>
			           			Backup: <a href="{!!route('admin.page','restore-database')!!}">{!!formatBytes($data['process']['backup'])!!}</a>
			           		</div>
			           	</div>
			           
			         </div>
			         <div class="col-md-5 col-lg-4">
			            <img style="box-shadow: none;height: 175px;" src="{!!asset('admin/images/image-dashboard-1.svg')!!}" class="d-none d-lg-block">
			            <!-- <hr style="opacity: 0;margin: 10px;" class="bg-white-transparent-2">
		            	<a href="" class="text-grey" style="margin-top: 45px;">Design By Vn4CMS.com</a> -->
			         </div>
			      </div>
			   </div>
			</div>
			<div class="col-md-5 card border-0 mb-3 overflow-hidden bg-white">
			   <div class="card-body">
			      <div class="row" style="display: flex; flex-wrap: wrap;justify-content: center;">
			         <div class="col-md-6 col-lg-7">
			            <div class="mb-3 text-grey">
			               <!-- <b>SYSTEM</b> -->
			            </div>
			           	<br>
			           	{!!$data['cms']['title']!!}
			           	<p><small>{!!$data['cms']['description']!!}</small></p>
	           			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
			           	<div class="systems" style="display: flex;justify-content: space-between;">
			           		<?php 
			           			$link_reference = array_chunk($data['cms']['link_reference'],4);
			           		 ?>
			           		 @foreach($link_reference as $links)
			           		<div class="system-item">
			           			@foreach($links as $link)
			           			<a target="_blank" href="{!!$link['link']!!}">{!!$link['title']!!}</a><br>
			           			@endforeach
			           		</div>
			           		@endforeach
			           	</div>
			         </div>
			         <div class="col-md-6 col-lg-5" style="display: flex;flex-wrap: wrap;justify-content: center;">
			            <div style="width: 100%;text-align: center;"><img style="box-shadow: none;height: 145px;" src="{!!asset('admin/images/vn4cms-logo.png')!!}" class="d-none d-lg-block"></div>
		            	<a href="" class="text-grey" style="margin-top: 10px;">Design By Vn4CMS.com</a>
			         </div>
			      </div>
			   </div>
			</div>
  		</div>	
	</div>
  
    <script src="@asset()vendors/jquery/jquery.min.js?v=1"></script>
    <script src="@asset()vendors/bootstrap/js/bootstrap.min.js?v=1"></script>
    <script src="@asset()admin/js/main.js?v=1"></script>
    <script type="text/javascript">
    	$(window).load(function(){
    		var isInIframe = (window.location != window.parent.location) ? true : false;
    		if(!isInIframe){
    			window.location.href = '{!!route('admin.index')!!}';
    		}
    		$(document).on('click','a',function(){
    			if( $(this).attr('target') == 'self' || !$(this).attr('target') ){
	    			window.parent.location.href = $(this).attr('href');
	    			return false;
    			}
    		});
    		$('.counting').each(function() {
			  var $this = $(this),
			      countTo = $this.attr('data-count');
			  
			  $({ countNum: $this.text()}).animate({
			    countNum: countTo
			  },
			  {
			    duration: 3000,
			    step: function() {
			      $this.text(Math.floor(this.countNum));
			    },
			    complete: function() {
			      $this.text(this.countNum);
			      //alert('finished');
			    }
			  });  
			  
			});
    	});
    </script>
  </body>
</html>