<?php 
// Template Name: Vn4CMS Links
// Icon: fa-link
 ?>

@if( isset($setting) && $setting )

@else
<?php 
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
<div class="card-body">
  <div class="row" style="display: flex; flex-wrap: wrap;justify-content: center;">
     <div class="col-md-12 col-lg-12">
        <div class="mb-3 text-grey">
           <!-- <b>SYSTEM</b> -->
        </div>
       	<br>
       	{!!$data['cms']['title']!!}
       	<p><small>{!!$data['cms']['description']!!}</small></p>
			<hr style="margin: 10px 0;" class="bg-white-transparent-2">
       	<div class="systems" style="display: flex;justify-content: space-around;">
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
     
  </div>
</div>
@endif