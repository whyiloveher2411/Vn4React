<?php 

$checkPermission = check_permission($page.'_view');

if(!$checkPermission){
    vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
    return redirect()->route('admin.index');
}

use_module('log');

$request = request();

LaravelLogViewer::setStorage('logs/'.$_SERVER['HTTP_HOST']);

if ($request->input('l')) {
    LaravelLogViewer::setFile(Crypt::decrypt($request->input('l')));
}

if ($request->input('dl')) {

	$pathToFile = LaravelLogViewer::pathToLogFile(Crypt::decrypt($request->input('dl')));
	return response()->download($pathToFile);

} elseif ($request->has('del')) {

    if( env('EXPERIENCE_MODE') ){
        return experience_mode();
    }

    app('files')->delete(LaravelLogViewer::pathToLogFile(Crypt::decrypt($request->input('del'))));
    return redirect($request->url());
} elseif ($request->has('delall')) {

     if( env('EXPERIENCE_MODE') ){
        return experience_mode();
    }
    
    foreach(LaravelLogViewer::getFiles(true) as $file){
        app('files')->delete(LaravelLogViewer::pathToLogFile($file));
    }
    return redirect($request->url());
}
// LaravelLogViewer::all(null,$levelResult);
// dd($levelResult);
$data = [
    'logs' => LaravelLogViewer::all(null, $levelResult),
    'levelResult'=>$levelResult,
    'files' => LaravelLogViewer::getFiles(true),
    'current_file' => LaravelLogViewer::getFileName()
];

if ($request->wantsJson()) {
    return $data;
}

return vn4_view(backend_theme('page.log.log'),$data);
