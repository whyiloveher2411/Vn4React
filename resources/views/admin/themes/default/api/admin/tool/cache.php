<?php
$r = request();

$input = json_decode($r->getContent(),true);

if( !isset($input['action']) ) $input['action'] = 'get';

$result = [];

if( $input['action'] === 'clear' ){
        
    if( $key = $input['key'] ){

        if( config('app.EXPERIENCE_MODE') ){
            return experience_mode();
        }
        
        $caches = include cms_path('resource','views/admin/themes/'.$GLOBALS['backend_theme'].'/page/cache-management/cache-default.php');

        $plugins = plugins();

        foreach ($plugins as $plugin) {
        if( file_exists( $file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/cache-management.php')) ){
            $serach = include $file;
            if( is_array($serach) ){
                $caches = array_merge($caches, $serach);
            }
        }
        }

        $theme_name = theme_name();
        if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/cache-management.php')) ){
            $serach = include $file;
            if( is_array($serach) ){
                $caches = array_merge($caches, $serach);
            }
        }


        if( isset($caches[$key]) ){

            if( isset($caches[$key]['flush']) ){
                $result = $caches[$key]['flush']();
            }else{
                Cache::forget($key);
                $result = false;
            }

            try {

                function getRedirectUrl ($url) {
                    stream_context_set_default(array(
                        'http' => array(
                            'method' => 'HEAD'
                        )
                    ));
                    $headers = get_headers($url, 1);
                    if ($headers !== false && isset($headers['Location'])) {
                        return $headers['Location'];
                    }
                    return false;
                }

                @file_get_contents( getRedirectUrl(  route('index')) )  || @file_get_contents( getRedirectUrl(str_replace('https', 'http', route('index'))) );
            } catch (Exception $e) {

            }

            if( $result ){
                return  $result;
            }
            $result['message'] = apiMessage('Clear cache success');

        }else{
            $result['message'] = apiMessage('Sorry, No cache found','warning');
        }

    }

}


function folderSize ($dir)
{
    $size = 0;

    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }

    return $size;
}

function formatBytes($size, $precision = 2)
{

  if( !is_numeric($size) ) return $size;

    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

if( config('cache.default') === 'file' ){
  $configCache = Config::get('cache');
  $pathCache = $configCache['stores']['file']['path'];
  $cache = folderSize($pathCache);
}else{
  $cache = __('(Not Found)');
}


$caches = include cms_path('resource','views/admin/themes/'.$GLOBALS['backend_theme'].'/page/cache-management/cache-default.php');

$plugins = plugins();

foreach ($plugins as $plugin) {
  if( file_exists( $file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/cache-management.php')) ){
    $cache = include $file;
    if( is_array($cache) ){

        foreach ($cache as $k => $v) {
          $cache[$k]['creator'] = 'Plugin';
        }

        $caches = array_merge($caches, $cache);
    }
  }
}

$theme_name = theme_name();
if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/cache-management.php')) ){
    $cache = include $file;
    if( is_array($cache) ){

        foreach ($cache as $k => $v) {
          $cache[$k]['creator'] = 'Theme';
        }

        $caches = array_merge($caches, $cache);
    }
}

$result['rows'] = $caches;
$result['totalSize'] = formatBytes($cache);

return $result;