<?php

if( $r->has('get_info_theme') ){
	
	$theme = $r->get('get_info_theme');

	$fileName = Config::get('view.paths')[0].'/themes/'.$theme.'/info.json';

	$img = file_exists( cms_path().'themes/'.$theme.'/screenshot.png' ) ? asset('themes/'.$theme.'/screenshot.png') : asset('admin/images/no-image-available.jpg') ;

	$result = ['img'=>$img];

	if( file_exists( $fileName ) ){

 		$info = json_decode(File::get($fileName), true);

 		$result['info'] = $info;

	}else{
		$no_info = __('No information');
		$result['info'] = [
			'description'=>$no_info,
			'author'=>$no_info,
			'version'=>'('.$no_info.')',
			'name'=>$theme,
			'author_url'=>'#',
			'tags'=>$no_info,
		];
	}


	if( file_exists( cms_path('resource').'views/themes/'.$theme.'/data-sample' ) && $theme === theme_name()  ){
		$result['data_sample'] = true;
	}

	return response()->json($result);

}

if( $r->has('data_sample') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$theme = $r->get('data_sample');

	if( !file_exists( cms_path('resource').'views/themes/'.$theme.'/data-sample' ) || $theme !== theme_name() ){

		return response()->json(['message'=>[
			'title'=>'Error',
			'content'=>'Import Data Sample Error.',
			'icon'=>'fa-times-circle',
			'color'=>'#CA2121'
		]]);

	}

	File::copyDirectory(cms_path('resource').'views/themes/'.$theme.'/public/', cms_path().'themes/'.$theme.'/');

	if( file_exists( $folder_upload_sample = cms_path('resource').'views/themes/'.$theme.'/data-sample/uploads' ) ){
		File::isDirectory( cms_path('public').'uploads' ) or File::makeDirectory( cms_path('public').'uploads' , 0777, true, true);
		File::copyDirectory( $folder_upload_sample , cms_path('public').'uploads/' );
	}

	if( file_exists( $filePath = cms_path('resource').'views/themes/'.$theme.'/data-sample/database.sql' )  && env('DB_CONNECTION') === 'mysql' ){

		use_module('import_data_sample');
		$users = DB::table(vn4_tbpf().'user')->get()->toArray();
		
		foreach ($users as $key => $value) {
			$users[$key] = (array) $value;
		}

		// Import the SQL file
		$import = importSqlFile($filePath);
		DB::table(vn4_tbpf().'user')->delete();
		DB::table(vn4_tbpf().'user')->insert($users);

		if ($import !== true) {

			return response()->json(['message'=>[
				'title'=>'Error',
				'content'=>'Import Data Sample Error.',
				'icon'=>'fa-times-circle',
				'color'=>'#CA2121'
			]]);
		}
	}

	return response()->json(['message'=>[
		'title'=>'Success',
		'content'=>'Import Data Sample Success.',
		'icon'=>'fa-check-circle',
		'color'=>'#29B87E'
	]]);
}

if( $r->has('ftp_server') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$ftp_server    = $r->get('ftp_server');
	$user_ftp    = $r->get('user_ftp');
	$password_ftp    = $r->get('password_ftp');
	$root_ftp    = $r->get('root_ftp');

	$conn_id = @ftp_connect($ftp_server);

	if ($conn_id) {
		$login_result = @ftp_login($conn_id, $user_ftp, $password_ftp);

		if ($login_result) {

			setting_save(Auth::id().'_user_ftp',$user_ftp);
			setting_save(Auth::id().'_password_ftp',$password_ftp);
			setting_save(Auth::id().'_ftp_server',$ftp_server);
			setting_save(Auth::id().'_root_ftp',$root_ftp);

			return response()->json(['success'=>true]);

			return ftp_nlist ($conn_id,$root_ftp);

		} else {
			return response()->json(['message'=>__('login to server failed!')]);
		}

	} else {
		return response()->json(['message'=>__('Connection to server failed!')]);
	}


}
if( $r->has('delete_ftp_account') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	setting_save(Auth::id().'_user_ftp','');
	setting_save(Auth::id().'_password_ftp','');
	setting_save(Auth::id().'_ftp_server','');
	return response()->json(['success'=>true]);
}

if( $r->has('get_folder_ftp') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$ftp_server    = setting(Auth::id().'_ftp_server');
	$user_ftp    = setting(Auth::id().'_user_ftp');
	$password_ftp    = setting(Auth::id().'_password_ftp');

	$conn_id = @ftp_connect($ftp_server);

	if ($conn_id) {
		$login_result = @ftp_login($conn_id, $user_ftp, $password_ftp);

		if ($login_result) {


		    $files = array();
		    $folders = array();
		    $contents = ftp_rawlist($conn_id, setting(Auth::id().'_root_ftp').'/'.$r->get('get_folder_ftp'));

		    if (count($contents)) {
		        foreach($contents as $index => $line) {
		            $line = substr($line, 10);

		            preg_match("#([\s]+)([0-9]+)([\s]+)([0-9]+)([\s]+)([a-zA-Z0-9\.]+)([\s]+)([0-9]+)([\s]+)([a-zA-Z]+)([\s]+)([0-9]+)([\s]+)([[a-zA-Z0-9\:]*)([\s]+)([a-zA-Z0-9\.\-\_ ]+)#si", $line, $out);
		            if (isset($out[2])) {
		                if ($out[16] == "." || $out[16] == "..") {

		                } else {
		                    $type = $out[2] == 1 ? "file" : "folder";

		                    if ($type === 'folder') {
		                        $folders[] = [
		                            'rights' => $out[0],
		                            'type' => $type,
		                            'owner_id' => $out[4],
		                            'owner' => $out[6],
		                            'date_modified' => $out[10].
		                            " ".$out[12].
		                            " ".$out[12].
		                            ":".$out[15].
		                            "",
		                            'name' => $out[16]
		                        ];
		                    } else {
		                        $files[] = [
		                            'rights' => $out[0],
		                            'type' => $type,
		                            'owner_id' => $out[4],
		                            'owner' => $out[6],
		                            'date_modified' => $out[10].
		                            " ".$out[12].
		                            " ".$out[12].
		                            ":".$out[15].
		                            "",
		                            'name' => $out[16]
		                        ];
		                    }
		                }
		            }
		        }
		    }

		    usort($folders, function($a, $b) {
		        return strcmp(strtolower($a['name']), strtolower($b['name']));
		    });
		    usort($files, function($a, $b) {
		        return strcmp(strtolower($a['name']), strtolower($b['name']));
		    });
		    return response()->json(['success' => true, 'files' => $files,'folders'=>$folders]);

		}

	}

	return response()->json(['message'=>__('Connection to server failed!')]);
}

if( $r->has('ftp_sync') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$names = $r->get('ftp_sync');

	function ftp_sync($conn_id, $dir) {

	  $files = array();
	  $folders = array();
	  $contents = ftp_rawlist ($conn_id, $dir);
	  $theme_name = theme_name();

	  $dir2 = explode('/', $dir);
	  $dir3 = [];

	  foreach ($dir2 as $d) {
	    $dir3[] = $d;
	    if(!File::exists(cms_path('resource','views/themes/'.$theme_name.'/public/').implode('/', $dir3))) {
	      File::makeDirectory(cms_path('resource','views/themes/'.$theme_name.'/public/').implode('/', $dir3));
	    }
	  }

	  if(count($contents)){
	      foreach($contents as $index => $line){
	          $line =  substr($line, 10);

	          preg_match("#([\s]+)([0-9]+)([\s]+)([0-9]+)([\s]+)([a-zA-Z0-9\.]+)([\s]+)([0-9]+)([\s]+)([a-zA-Z]+)([\s]+)([0-9]+)([\s]+)([[a-zA-Z0-9\:]*)([\s]+)([\w\W]+)#si", $line, $out);
	          if( isset($out[2]) ){
	            if($out[16] == "." || $out[16] == ".."){

	            } else {
	                $type = $out[2] == 1 ? "file":"folder";

	                if( $type === 'folder'){
	                  $folders[] = [
	                    'rights' => $out[0],
	                    'type' => $type,
	                    'owner_id' => $out[4],
	                    'owner' => $out[6],
	                    'date_modified' => $out[10]." ".$out[12] . " ".$out[12].":".$out[15]."",
	                    'name' => $out[16]
	                  ];
	                }else{
	                  $files[] = [
	                    'rights' => $out[0],
	                    'type' => $type,
	                    'owner_id' => $out[4],
	                    'owner' => $out[6],
	                    'date_modified' => $out[10]." ".$out[12] . " ".$out[12].":".$out[15]."",
	                    'name' => $out[16]
	                  ];
	                }
	            }
	          }
	      }
	  }
	  foreach ($files as $f) {
	    try {
	      ftp_get($conn_id, cms_path('resource','views/themes/'.$theme_name.'/public/'.$dir).'/'.$f['name'],$dir.'/'.$f['name'], FTP_BINARY);
	    } catch (Exception $e) {
	    dd($f);    
	    }
	  }
	  foreach ($folders as $f) {
	    ftp_sync($conn_id,$dir.'/'.$f['name']);
	  }

	}

	$ftp_server    = setting(Auth::id().'_ftp_server');
	$user          = setting(Auth::id().'_user_ftp');
	$password      = setting(Auth::id().'_password_ftp');
	$sync_path     = setting(Auth::id().'_root_ftp').'/';

	$conn_id = ftp_connect($ftp_server);
	if ($conn_id) {
	  $login_result = ftp_login($conn_id, $user, $password);
	  if ($login_result) {
	    ftp_chdir($conn_id, $sync_path);
	    foreach ($names as $name) {
	      ftp_sync($conn_id, $name);
	    }
	    ftp_close($conn_id);
	  } else {
	    echo 'login to server failed!' . PHP_EOL;
	  }
	} else {
	  echo 'connection to server failed!';
	}

	return response()->json(['message'=>__('Synchronization Success!')]);

}

if( $r->has('theme_delete') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}

	$theme_delete = $r->get('theme_delete');

	if( $theme_delete === theme_name() ){
		return response()->json(['message'=>__('Sorry, can not delete the theme being used')]);
	}
	
	$result = File::deleteDirectory(cms_path('resource','/views/themes/'.$r->get('theme_delete')));

	if( $result ){
		return response()->json(['reload'=>true]);
	}

	return response()->json(['message'=>__('Sorry, can not delete theme')]);

}

if( $r->has('general_client_theme') ){

	if( env('EXPERIENCE_MODE') ){
		return experience_mode();
	}
		
	$theme = $r->get('general_client_theme');

	if( file_exists( $file = cms_path('resource').'views/themes/'.$theme.'/inc/activate.php') ){
		$install = include $file;
		if( $install !== 1 ) return $install;
	}

	setting_save('general_client_theme', $r->get('general_client_theme') );

	return redirect()->back();
}
return redirect()->back();