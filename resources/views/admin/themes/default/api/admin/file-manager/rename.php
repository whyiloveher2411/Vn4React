<?php
include __DIR__.'/__helper.php';

$file = $r->get('file');
$origin = $r->get('origin');

if( $file && $origin ){

    if( !isset($file['filename']) || !$file['filename'] ){
        return [
            'message'=>apiMessage('The name field cannot be left blank','error')
        ];
    }

    $oldLink = cms_path('public',$origin['dirpath'].'/'.$origin['basename']);
    $pathOld = $origin['dirpath'].'/'.$origin['basename'];
    if( isset($origin['is_dir']) && $origin['is_dir'] ){
        $newLink = cms_path('public',$origin['dirpath'].'/'.$file['filename']);
        $pathNew = $origin['dirpath'].'/'.$file['filename'];
    }else{
        $newLink = cms_path('public', $origin['dirpath'].'/'.$file['filename'].'.'.$origin['extension']);
        $pathNew = $origin['dirpath'].'/'.$file['filename'].'.'.$origin['extension'];
    }

    if( !file_exists( $oldLink ) ){
        return [
            'message'=>apiMessage('File does not exist','error')
        ];
    }

    if( file_exists( $newLink ) ){
        return [
            'message'=>apiMessage('File name already exists','error')
        ];
    }
    
    try {
        // dd($oldLink, $newLink );
        $result = rename( $oldLink, $newLink );

        if( $result ){

            __updatePath( $pathOld, $pathNew );

            return [
                'success'=>true
            ];
        }

    } catch (\Throwable $th) {

        $result = rename_win($oldLink, $newLink);

        if( $result ){

            __updatePath( $pathOld, $pathNew );

            return [
                'success'=>true
            ];
        }

    }

}

return [
    'message'=>apiMessage('Re-name failed','error')
];