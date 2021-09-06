<?php
if( env('EXPERIENCE_MODE') ){
    return experience_mode();
}

if( $r->has('download') ){

	$name = Crypt::decrypt($r->get('download'));
	$dirName = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/'.$name);
	$zipname =  cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/'.$name.'.zip');

    $zip_file = $zipname;
	$zip = new \ZipArchive();
	$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

	$path = $dirName;
	$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
	foreach ($files as $name => $file)
	{
	    // We're skipping all subfolders
	    if (!$file->isDir()) {
	        $filePath     = $file->getRealPath();

	        // extracting filename with substr/strlen
	        $relativePath = 'database/'.$_SERVER['HTTP_HOST'].'/'. substr($filePath, strlen($path) + 1);

	        $zip->addFile($filePath, $relativePath);
	    }
	}
	$zip->close();
	return response()->download($zip_file);

}

if( $r->has('delete') ){
	$path = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/'.Crypt::decrypt($r->get('delete')));


	function delete_restore_database($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            delete_restore_database($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}

	try {
		delete_restore_database($path);

	    vn4_create_session_message('Success','Delete Restore Database File Success!','success');
		return response()->json(['success'=>true]);

	} catch (Exception $e) {
	    vn4_create_session_message('Error','Delete Restore Database File Error!','error');
		return response()->json(['message'=>'Delete Restore Database File Error!']);
	}
}

if( $r->has('restore') ){

	$path = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/'.Crypt::decrypt($r->get('restore'))).'/';
	
	$file = 'database.sql';

	if ( file_exists($path.$file) && env('DB_CONNECTION') === 'mysql' ){

		$filePath = $path.$file;

		function importSqlFile($pdo, $sqlFile, $tablePrefix = null, $InFilePath = null){
	      try {
	        
	        // Enable LOAD LOCAL INFILE
	        $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
	        
	        $errorDetect = false;
	        
	        // Temporary variable, used to store current query
	        $tmpLine = '';
	        
	        // Read in entire file
	        $lines = file($sqlFile);
	        
	        // Loop through each line
	        foreach ($lines as $line) {
	          // Skip it if it's a comment
	          if (substr($line, 0, 2) == '--' || trim($line) == '') {
	            continue;
	          }
	          
	          // Read & replace prefix
	          $line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);
	          
	          // Add this line to the current segment
	          $tmpLine .= $line;
	          
	          // If it has a semicolon at the end, it's the end of the query
	          if (substr(trim($line), -1, 1) == ';') {
	            try {
	              // Perform the Query
	              $pdo->exec($tmpLine);
	            } catch (\PDOException $e) {
	              echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
	              $errorDetect = true;
	            }
	            
	            // Reset temp variable to empty
	            $tmpLine = '';
	          }
	        }
	        
	        // Check if error is detected
	        if ($errorDetect) {
	          return false;
	        }
	        
	      } catch (\Exception $e) {
	        echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
	        return false;
	      }
	      
	      return true;
	    }

	    $servername = env('DB_HOST');
	    $port = env('DB_PORT');
	    $username = env('DB_USERNAME');
	    $password = env('DB_PASSWORD');
	    $database_name = env('DB_DATABASE');

	    try{
	        $pdo = new pdo( 'mysql:host='.$servername.':'.$port.';dbname='.$database_name,
	                        $username,
	                        $password,
	                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	    }catch(PDOException $ex){
	        die(json_encode(array('error' => true, 'message' => 'Unable to connect')));
	    }

	    try {
	    	$pdo->exec("SET FOREIGN_KEY_CHECKS = 0; SET @tables = NULL;SELECT GROUP_CONCAT(table_schema, '.', table_name) INTO @tables  FROM information_schema.tables   WHERE table_schema = '".$database_name."'; SET @tables = CONCAT('DROP TABLE ', @tables); PREPARE stmt FROM @tables; EXECUTE stmt; DEALLOCATE PREPARE stmt; SET FOREIGN_KEY_CHECKS = 1; ");
	    	
	    } catch (Exception $e) {
	    	die(json_encode(array('error' => true, 'message' => 'Can\'t Delete Table.')));
	    }
	    

	    vn4_create_session_message('Success','Restore Database Success!','success');

	    // Import the SQL file
	    $res = importSqlFile($pdo, $filePath);
	    if ($res === false) {
			return response()->json(['error'=>true]);
	    }

		return response()->json(['success'=>true]);

  	}elseif( env('DB_CONNECTION') === 'mongodb' ) {
		return response()->json(['message'=>'Restore on connection mongodb']);
  		dd(1);
  	}

}


if( $r->has('upload') ){
	$upload = json_decode($r->get('upload'),true);

	$link = cms_path('public',$upload['link']);

	$folder = dirname($link);

	$time = filemtime($link);

	File::isDirectory( $folder ) or File::makeDirectory( $folder , 0777, true, true);

	File::copyDirectory( $folder , cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/upload_backup_'.$time));

	return response()->json(['success'=>true]);

}

return response()->json(['error'=>true]);