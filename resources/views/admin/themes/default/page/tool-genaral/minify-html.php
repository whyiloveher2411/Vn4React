<?php
// dd(token_name(382));
function getDirContents($dir, &$results = array()) {

    $files = scandir($dir);

    $views = glob($dir.'/*.blade.php');
    
    $results = array_merge($results, $views);

    $dirs = glob($dir.'/*',GLOB_ONLYDIR );

    foreach ($dirs as $d) {
         getDirContents($d, $results);
    }

    return $results;
}


$views = getDirContents(cms_path('resource').'views');

// $views = [$views[297]];

$blade = app()->make('Illuminate\View\Compilers\BladeCompiler');

foreach ($views as $path) {
	$blade->compile($path);
}


use_module('minify-php');

// Artisan::call('view:cache');

$files = File::allFiles(cms_path('storage','framework/views'));

foreach ($files as $file) {
	if( $file->getExtension() === 'php'){

		$path_file = $file->getRealPath();

		minify_php_and_save($path_file);
		
	}
}

vn4_create_session_message( __('Success'), __('Minify HTML View success'), 'success', true );

$is_acction = true;

