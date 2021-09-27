<?php

if( config('app.EXPERIENCE_MODE') ){
    return experience_mode();
}

use_module('log');

LaravelLogViewer::setStorage('logs');

app('files')->delete(LaravelLogViewer::pathToLogFile(Crypt::decrypt($r->input('del'))));
return redirect($request->url());

