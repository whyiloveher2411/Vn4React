<?php
$_SESSION['FM']['verify'] = 'vn4-file-manage';

include __DIR__.'/__helper.php';
include __DIR__.'/utils.php';

$root = 'uploads';

$uploadsPath = $r->get('path',$root);

$publicUploadPath = cms_path('public',$uploadsPath);

if( !file_exists($publicUploadPath) ){

    $uploadsPath = $root;
    $publicUploadPath = cms_path('public',$uploadsPath);
    // return [
    //     'message'=>apiMessage('Folder does not exist','erro')
    // ];
}

$files = __getDirContents($publicUploadPath);

$filesResult = [];
$foldersResult = [];
$result = [];

$thumbnailSize = [150, 150];

$extensionImageNotNeedThumbnail = ['svg'=>1, 'webp'=>1];

$listPathKey = [];

foreach($files as $k=>$file){

    if( $file !== '.' && $file !==  '..' ){

        if( is_dir( $file ) ){
            
            // $foldersResult[] = $file;
            $pathinfo = pathinfo($file);
            $foldersResult[] = array_merge(
                pathinfo($file),
                [
                    'filesize'=>__formatSizeUnits(filesize($file)),
                    'dirpath'=>$uploadsPath,
                    'is_dir'=>true,
                    'filemtime'=>date("m/d/Y H:i:s",filemtime($file)),
                    'filectime'=>date("m/d/Y H:i:s",filectime($file)),
                ]
            );

            $listPathKey[] = $uploadsPath.'/'.$pathinfo['basename'];

            // $date=filemtime($config['current_path'].$rfm_subfolder.$subdir. $file);
            // $current_folders_number++;
            // if($config['show_folder_size']){
            //     list($size,$nfiles,$nfolders) = folder_info($config['current_path'].$rfm_subfolder.$subdir.$file,false);
            // } else {
            //     $size=0;
            // }
            // $file_ext=trans('Type_dir');
            // $sorted[$k]=array(
            //     'is_dir'=>true,
            //     'file'=>$file,
            //     'file_lcase'=>strtolower($file),
            //     'date'=>$date,
            //     'size'=>$size,
            //     'permissions' =>'',
            //     'extension'=>fix_strtolower($file_ext)
            // );
            // if($config['show_folder_size']){
            //     $sorted[$k]['nfiles'] = $nfiles;
            //     $sorted[$k]['nfolders'] = $nfolders;
            // }
        }else{

            $pathinfo = pathinfo($file);

            $is_image = __is_image($file, $pathinfo);
            
            if( $is_image) {

                if( isset($extensionImageNotNeedThumbnail[ strtolower($pathinfo['extension']) ]) ){
                    $thumbnail = $uploadsPath.'/'.$pathinfo['basename'];
                }else{
                    $thumbnail = 'thumbnails/'.$uploadsPath.'/'.$thumbnailSize[0].'x'.$thumbnailSize[1].'-'.$pathinfo['basename'];

                    if( !file_exists($realPathThumbnail = cms_path('public',$thumbnail)) ){

                        if (!file_exists(dirname($realPathThumbnail))) {
                            mkdir(dirname($realPathThumbnail), 0755, true);
                        }

                        if(!create_img(cms_path('public',$uploadsPath.'/'.$pathinfo['basename']), $realPathThumbnail, $thumbnailSize[0], $thumbnailSize[1],'crop')){
                            $thumbnail=$mini_src = '';
                        }
                    }
                }
            }else{
                if( isset($pathinfo['extension']) ){
                    $thumbnail = 'admin/fileExtension/ico/'. strtolower($pathinfo['extension']).'.jpg';
                }else{
                    continue;
                }
            }

            $filesResult[] = array_merge(
                $pathinfo,
                [
                    'filesize'=>__formatSizeUnits(filesize($file)),
                    'dirpath'=>$uploadsPath,
                    'is_dir'=>false,
                    'is_image'=>__is_image($file, $pathinfo),
                    'thumbnail'=>asset($thumbnail),
                    'public_path'=>asset($uploadsPath.'/'.$pathinfo['basename']),
                    'filemtime'=>date("m/d/Y H:i:s",filemtime($file)),
                    'filectime'=>date("m/d/Y H:i:s",filectime($file)),
                ]
            );

            $listPathKey[] = $uploadsPath.'/'.$pathinfo['basename'];

            // $current_files_number++;
            // $file_path=$config['current_path'].$rfm_subfolder.$subdir.$file;
            // $date=filemtime($file_path);
            // $size=filesize($file_path);
            // $file_ext = substr(strrchr($file,'.'),1);
            // $sorted[$k]=array(
            //     'is_dir'=>false,
            //     'file'=>$file,
            //     'file_lcase'=>strtolower($file),
            //     'date'=>$date,
            //     'size'=>$size,
            //     'permissions' =>'',
            //     'extension'=>strtolower($file_ext)
            // );
        }

    }
}


$files = array_merge($foldersResult, $filesResult);

if( isset($listPathKey[0]) ){
    
    $infoFromChange = DB::table('vn4_filemanage')->whereIn('path',$listPathKey)->get()->keyBy('path');

    foreach( $files as $key => $file ){
        if( isset($infoFromChange[ $file['dirpath'].'/'.$file['basename']]) ){
            $files[$key]['data'] = $infoFromChange[ $file['dirpath'].'/'.$file['basename']];
        }else{
            $files[$key]['data'] = [];
        }
    }
}


$uploadsPaths = explode('/',$uploadsPath);

$dataBreadcrumbs = [];

if( isset($uploadsPaths[0]) ){

    $count = count($uploadsPaths);

    $paths = [];

    for ($i = 0; $i < $count; $i++) { 
        $temp = [];
        for ($j=0; $j <= $i; $j++) { 
            $temp[] = $uploadsPaths[$j];
        }
        $paths[] = join('/',$temp);
    }
    $dataBreadcrumbs = __getDataBreadcrumbs($paths);
}

$pathinfo = pathinfo($publicUploadPath);

$pathinfo = array_merge(
    $pathinfo,
    [
        'filesize'=>__formatSizeUnits(filesize($publicUploadPath)),
        'dirpath'=>$uploadsPath === $root ? '' : dirname($uploadsPath) ,
        'is_dir'=>true,
        'filemtime'=>date("m/d/Y H:i:s",filemtime($publicUploadPath)),
        'filectime'=>date("m/d/Y H:i:s",filectime($publicUploadPath)),
        'data'=>__getDataBreadcrumbs([$uploadsPath])[$uploadsPath]
    ]
);

$dataBreadcrumbs[ $uploadsPath ]->infoDetail = $pathinfo;

$result['files'] = $files;
$result['config'] = __getConfig();
$result['version'] = $r->get('version',0);
$result['dataBreadcrumbs'] = $dataBreadcrumbs;

// if( $r->get('loadLocation') ){
//     $result['location'] = [
//         [
//             'key'=>'uploads',
//             'title'=>'Local',
//             'avatar'=>asset('admin/fileExtension/ico/folder3.png'),
//             'selected'=>true,
//         ],
//         [
//             'key'=>'google-drive',
//             'title'=>'Google drive',
//             'avatar'=>asset('admin/fileExtension/ico/Google_Drive2.png'),
//         ],
//         [
//             'key'=>'dropbox',
//             'title'=>'Dropbox',
//             'avatar'=>asset('admin/fileExtension/ico/Dropbox_Icon.svg.webp'),
//         ],
//     ];
// }


return $result;