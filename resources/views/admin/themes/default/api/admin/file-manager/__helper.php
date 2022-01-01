<?php


function __formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}


function __is_image($path, $pathinfo)
{
    $extensions= __getConfig()['extension']['ext_image'];

    if( isset($pathinfo['extension']) 
        && isset($extensions[  strtolower( str_replace( '-','', str_slug($pathinfo['extension']) ) )]) 
        ){
        return true;
    }
    return false;
}

function __getDirContents($dir, &$results = array(), $getStruct = false, &$resultFolders = array(), &$resultFiles = array() ) {

    $files = scandir($dir);

    foreach ($files as $key => $value) {

        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

        if (!is_dir($path)) {

            $results[] = $path;
            $resultFiles[] = $path;
        } else if ($value != "." && $value != "..") {
            $results[] = $path;
            $resultFolders[] = $path;

            if( $getStruct ){
                __getDirContents($path, $results, $getStruct, $resultFolders, $resultFiles);
            }
        }
    }
    return $results;
}

function __getConfig(){
    
    return [
        'extension' => [
            'ext_file' => array('doc'=>1,'docx'=>1,'json'=>1,'rtf'=>1,'pdf'=>1, 'xls'=>1, 'xlsx'=>1, 'txt'=>1, 'csv'=>1, 'html'=>1 ),
            'ext_image' => array('jpeg'=>1,'jpg'=>1,'png'=>1,'svg'=>1,'gif'=>1, 'ico'=>1, 'bmp'=>1, 'webp'=>1, ),
            'ext_misc' => array('zip'=>1,'rar'=>1,'gz'=>1,'tar'=>1,'iso'=>1, 'dmg'=>1 ),
            'ext_video' => array('mov'=>1,'mpeg'=>1,'m4v'=>1,'mp4'=>1,'avi'=>1, 'mpg'=>1, 'wma'=>1, 'flv'=>1, 'webm'=>1 ),
            'ext_music' => array('mp3'=>1,'mpga'=>1,'m4a'=>1,'ac3'=>1,'aiff'=>1, 'mid'=>1, 'ogg'=>1, 'wav'=>1 ),
        ],
        'extensionFilter'=>[
            ['key'=>'ext_file', 'title'=>'File','icon'=>'InsertDriveFileOutlined','iconActive'=>'InsertDriveFile'],
            ['key'=>'ext_image', 'title'=>'Image','icon'=>'ImageOutlined','iconActive'=>'Image'],
            ['key'=>'ext_misc', 'title'=>'Archive','icon'=>'ArchiveOutlined','iconActive'=>'Archive'],
            ['key'=>'ext_video', 'title'=>'Video','icon'=>'VideocamOutlined','iconActive'=>'Videocam'],
            ['key'=>'ext_music', 'title'=>'Music','icon'=>'MusicNoteOutlined','iconActive'=>'MusicNote'],
        ]
    ];
    
}

function __updateColor($file, $color ){
    
    $path = __getPath($file);

    if( $path ){
        return DB::table('vn4_filemanage')->updateOrInsert(
            ['path'=>$path],
            [
                'color'=>$color
            ]
        );
    }

    return false;
}



function __removeFile($file, $value){

    $path = __getPath($file);

    if( $path ){

        return DB::table('vn4_filemanage')->updateOrInsert(
            ['path'=>$path],
            [
                'is_remove'=>$value
            ]
        );
    }

    return false;
}


function __getDataBreadcrumbs($paths){

    $results = DB::table('vn4_filemanage')->whereIn('path',$paths)->get()->keyBy('path');

    $pathNotFound = [];

    foreach( $paths as $path ){

        if( !isset($results[$path]) ){
            $pathNotFound[] = ['path'=>$path,'is_remove'=>0];
        }
    }

    if( isset($pathNotFound[0]) ){
        DB::table('vn4_filemanage')->insert($pathNotFound);

        $results = DB::table('vn4_filemanage')->whereIn('path',$paths)->get()->keyBy('path');
    }

    return $results;

}

function __changeDescriptionFile($file, $description, &$message){

    $path = __getPath($file);

    if( $path ){

        return DB::table('vn4_filemanage')->updateOrInsert(
            ['path'=>$path],
            [
                'description'=>$description
            ]
        );

    }

    $message = apiMessage('Change Descirption failed','error');
    return false;
}

function __moveFileOrFolder($file, $folder, &$message, $acceptChangeName = false){

    if( $file['is_dir'] ){
        if( __moveFolder($file, $folder, $message, $acceptChangeName ) ){
           return true;
        }
    }else{
        if( __moveFile($file, $folder, $message, $acceptChangeName ) ){
            return true;
        }
    }

    return false;
}

function __moveFile( $file, $folder, &$message, $notChangeName = true ){

    $oldFilePath = __getPath($file);
    $folderPath = __getPath($folder);

    $message = apiMessage('File move failed','error');

    if( $oldFilePath && $folderPath ){

        $newFilePath = $folderPath.'/'.$file['basename'];

        if( __movePath($oldFilePath, $newFilePath, $message, $notChangeName) ){
            return true;
        }
    }

    return false;
}

function __movePath($oldFilePath, $newFilePath, &$message, $acceptChangeName = true){

    $fullOldFilePath = cms_path( 'public', $oldFilePath);
    $fullNewFilePath = cms_path( 'public', $newFilePath);

    if( $acceptChangeName ){
        $pathinfo = pathinfo( $fullNewFilePath );
        
        $index = 2;

        while ( file_exists( $fullNewFilePath ) ) {
            $fullNewFilePath = $pathinfo['dirname'].'/'.str_slug($pathinfo['filename'].'-'.$index).'.'.$pathinfo['extension'];
            $newFilePath = __getPathFromFullPath( $fullNewFilePath );
            ++$index;
        }
    }else{
        if( file_exists( $fullNewFilePath ) ){
            $message = apiMessage('The new folder already exists this file (folder), please change the file (folder) name before moving','error');
            return false;
        }
    }
    
    if( rename($fullOldFilePath, $fullNewFilePath) ){
        __updatePath( $oldFilePath, $newFilePath);
        return true;
    }

    return false;
}


function __moveFolder($file, $folder, &$message, $acceptChangeName = false){

    $oldFilePath = __getPath($file);
    $folderPath = __getPath($folder);

    if( strpos( $folderPath.'/', $oldFilePath.'/') !== false ){
        $message = apiMessage('the destination folder is a subfolder of the source folder','error');
        return false;
    }

    if( $oldFilePath && $folderPath ){

        $newFilePath = $folderPath.'/'.$file['basename'];

        $fullOldFilePath = cms_path( 'public', $oldFilePath);
        $fullNewFilePath = cms_path( 'public', $newFilePath);
        

        if( !file_exists($fullNewFilePath) ){
            $created = mkdir( $fullNewFilePath , 0755, true);
            if( $created ){
                __updatePath($oldFilePath, $newFilePath);
            }
        }


        $onlyfolder = [];
        $onlyFiles = [];
        $allFiles = [];

        $files = __getDirContents( $fullOldFilePath, $allFiles , true, $onlyfolder, $onlyFiles);

        foreach( $onlyfolder as $f ){
            $oldPath = __getPathFromFullPath($f);
            $newPath = str_replace($oldFilePath, $newFilePath, $oldPath);
            
            if( $newPath !== $oldPath ){
                if( !file_exists( $filePathTemp = cms_path('public', $newPath ) ) ){
                    $created = mkdir( $filePathTemp , 0755, true);
                    if( $created ){
                        __updatePath($oldPath, $newPath);
                    }
                }
            }
        }
        
        foreach($onlyFiles as $f){
            $oldPath = __getPathFromFullPath($f);
            $newPath = str_replace($oldFilePath, $newFilePath, $oldPath);
            
            __movePath($oldPath, $newPath, $message, $acceptChangeName);
        }

        __deleteDir($oldFilePath);

        return true;

    }

    $message = apiMessage('File move failed','error');
    return false;
}

function __getPathFromFullPath($fullPath){
    $explodePath = explode('public',$fullPath);
    if( isset($explodePath[1]) ){
        $pathPrefix = $explodePath[1];
        $pathPrefix = trim( str_replace('\\','/', $pathPrefix),'/') ;
        return $pathPrefix;
    }
    return false;
}

function copyfiles($source_folder, $target_folder, $move=false) {
    $source_folder=trim($source_folder, '/').'/';
    $target_folder=trim($target_folder, '/').'/';
    $files = scandir($source_folder);
    foreach($files as $file) {
        if($file != '.' && $file != '..') {
            if ($move) {
                rename($source_folder.$file, $target_folder.$file);
            } else {
                copy($source_folder.$file, $target_folder.$file);
            }
        }
    }
    
    return true;
}

function movefiles($source_folder, $target_folder) {
    copyfiles($source_folder, $target_folder, $move=true);
}


function __updatePath( $pathOld, $pathNew ){

    DB::table('vn4_filemanage')->where('path',$pathNew)->delete();

    return DB::table('vn4_filemanage')->updateOrInsert(
        ['path'=>$pathOld],
        [
            'path'=>$pathNew
        ]
    );

}


function __updateStarred($file, $starred ){
    $path = __getPath($file);

    if( $path ){
        return DB::table('vn4_filemanage')->updateOrInsert(
            ['path'=>$path],
            [
                'starred'=>$starred
            ]
        );

    }
    return false;
}

function __getPath($file){

    if( isset($file['dirpath']) && isset($file['basename']) ){
        return  $file['dirpath'].'/'.$file['basename'];
    }

    if( isset($file['basename']) ){
        return $file['basename'];
    }

    return null;
}

function __deleteFile($file,&$message){

    $path = __getPath($file);
    $is_dir = $file['is_dir'] ?? false;

    if( $path ){

        $filePath = cms_path('public', $path);

        if( !file_exists($filePath) ){
            $message = apiMessage('File does not exist', 'error');
            return false;
        }

        $dataDB = Vn4Model::table('vn4_filemanage')->where('path', $path)->first();

        $removeFIle = false;
        if( $dataDB ){
            if( !$dataDB->is_remove ){
                $message = apiMessage('You need to put the file in the trash before actually deleting it', 'error');
                return false;
            }
        }

        if( $is_dir ){
            $removeFIle =  __deleteDir( $filePath );
        }else{
            $removeFIle = unlink( $filePath );
        }

        if( $removeFIle ){
            $dataDB->setTable('vn4_filemanage');
            $dataDB->delete();
        }

        return true;
    }

    $message = apiMessage('Delete folder failed', 'error');
    return false;

}

function __deleteDir($dirPath) {
    try {

        $result = true; 

        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
               $result = __deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);

        return $result;

    } catch (\Throwable $th) {

        return false;
    }
}

function __createDataDefaultForFile( $path, $isDir = 1 ){
    return DB::table('vn4_filemanage')->updateOrInsert(
        ['path'=>$path],
        [
            'starred'=>0,
            'is_remove'=>0,
            'is_dir'=>$isDir
        ]
    );
}

function __createFolder($folder, $name, &$message){
    $path = __getPath( $folder );

    if( !file_exists( cms_path('public', $path) ) ){
        $message = apiMessage('Parent folder does not exist', 'error');
        return false;
    }

    $pathName = $path.'/'.str_slug($name);

    if( file_exists( cms_path('public', $pathName ) ) ){
        $message = apiMessage('Folder already exists, please choose another name', 'error');
        return false;
    }


    try {
        $created = mkdir( cms_path('public', $pathName ) , 0755, true);

        if( $created ){
            
            __createDataDefaultForFile($pathName);
            
            return true;
        }
    } catch (\Throwable $th) {

        $message = apiMessage($th->getMessage(), 'error');
        return false;

    }

    return false;
}

function rename_win($oldfile,$newfile) {
    if (!rename($oldfile,$newfile)) {
        if (copy ($oldfile,$newfile)) {
            unlink($oldfile);
            return TRUE;
        }
        return FALSE;
    }
    return TRUE;
}

function __downloadFile($user, $file, &$message, &$pathDownload){

    $path = __getPath($file);

    if( $path ){

        $publicPath = cms_path('public', $path);

        if( !file_exists( $publicPath ) ){
            $message = apiMessage('File does not exist','error');
            return false;
        }

        $token = createToken($user, [
            'file'=>$file,
        ],5);

        if( $file['is_dir'] ){
            $message = apiMessage('The server is zipping files, this may take a long time, please wait until it\'s done','info');
        }

        $pathDownload = route('api_group',['group'=>'file-manager','file'=>'downloader']).'?access_token='.$token;

        return true;
    } 

    $message = apiMessage('Download failed','error');
    return false;

}

function __downloader(){
    $access_token = request()->get('access_token');

    $data = decodeToken($access_token);

    if( $data && $data->file ){
        if( $data->file->is_dir ){

            return __downloadFolder($data->file->dirpath.'/'.$data->file->basename, $data->file);

        }else{

            $file = cms_path('public', $data->file->dirpath.'/'.$data->file->basename);

            if( !file_exists($file) ){
                return ['message'=>'File does not exist'];
            }

            return Response::download($file);
            
        }
        
    }

    return ['message'=>'Invalid access'];
}

function xcopy($source, $dest, $permissions = 0755)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest, $permissions);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        xcopy("$source/$entry", "$dest/$entry", $permissions);
    }

    // Clean up
    $dir->close();
    return true;
}

function __downloadFolder($dir, $file){
    
    if( !file_exists( cms_path('storage','downloader' ) ) ){
        mkdir( cms_path('storage','downloader' ) , 0755, true);
    }
    
    $zip_file = cms_path('storage','downloader/'.$file->basename.'.zip');

    // Get real path for our folder
    $rootPath = realpath($dir);

    // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();

            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zip_file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);

    return true;
}