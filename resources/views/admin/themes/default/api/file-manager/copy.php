<?php

include __DIR__.'/__helper.php';

if( ($files = $r->get('files')) && ($folder = $r->get('folder')) && ($action = $r->get('action')) ){

    $message = '';

    if( $action === 'copy' ){

        foreach( $files as $file ){
            $index = 1;
            $pathOld = __getPath($file);
            $newPath = __getPath($folder).'/'.$file['basename'];

            while ( file_exists( cms_path('public',$newPath) ) ) {
                
                if( $index > 1 ){
                    $newPath = __getPath($folder).'/'.$file['filename'].' - Copy ('.$index.')';
                }else{
                    $newPath = __getPath($folder).'/'.$file['filename'].' - Copy';
                }

                if( !$file['is_dir'] ){
                    $newPath .= '.'.$file['extension'];
                }

                $index++;

            }
            xcopy(  cms_path('public', $pathOld) , cms_path('public',$newPath) );
        }

        return [
            'success'=>true
        ];

    }else{

        $moveFileResult = [];

        foreach( $files as $key => $file ){
            $moveFileResult[$key] = __moveFileOrFolder(  $file , $folder, $message, true );
        }

        return [
            'message'=>$message,
            $moveFileResult,
            'success'=>true
        ];  
    }

    return [
        'message'=>$message,
        'success'=>false
    ]; 

}

return [
    'message'=>apiMessage('Move File failed','error'),
    'success'=>false
];