<?php

// $checkPermission = check_permission($page.'_view');

// if(!$checkPermission){
//     vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
//     return redirect()->route('admin.index');
// }

use_module('log');

$request = request();

LaravelLogViewer::setStorage('logs');


if ($request->input('dl')) {

	$pathToFile = LaravelLogViewer::pathToLogFile(Crypt::decrypt($request->input('dl')));
	return response()->download($pathToFile);

} elseif ($dels = $request->get('del')) {

    if( config('app.EXPERIENCE_MODE') ){
        return experience_mode();
    }

    if( !is_array($dels) ){
        $dels = [$dels];
    }

    foreach( $dels as $file ){
        app('files')->delete(LaravelLogViewer::pathToLogFile(Crypt::decrypt($file)));
    }

} elseif ($request->has('delall')) {

     if( config('app.EXPERIENCE_MODE') ){
        return experience_mode();
    }
    
    foreach(LaravelLogViewer::getFiles(true) as $file){
        app('files')->delete(LaravelLogViewer::pathToLogFile($file));
    }
    return redirect($request->url());
}


if ($request->input('l')) {
    try {
        LaravelLogViewer::setFile(Crypt::decrypt($request->input('l')));
    } catch (\Throwable $th) {
        //throw $th;
    }
}
// LaravelLogViewer::all(null,$levelResult);
// dd($levelResult);

// \Illuminate\Support\Facades\Crypt::encrypt(

$files = LaravelLogViewer::getFiles(true);

foreach( $files as $key => $f){
    $files[$key] = ['crypt'=> \Illuminate\Support\Facades\Crypt::encrypt( $f ), 'title'=>$f, 'date'=>date('F j, Y', filectime( cms_path('storage','logs/'. $f) )) ];
}

$data = [
    'logs' => LaravelLogViewer::all(null, $levelResult),
    'levelResult'=>$levelResult,
    // 'files' => LaravelLogViewer::getFiles(true),
    'files'=>$files,
    'current_file' => LaravelLogViewer::getFileName() ,
    'path'=>\Illuminate\Support\Facades\Crypt::encrypt(LaravelLogViewer::getFileName()),
];

return $data;



