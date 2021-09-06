@extends(backend_theme('master'))

@section('content')
<?php 

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

if( env('CACHE_DRIVER') === 'file' ){
  $configCache = Config::get('cache');
  $pathCache = $configCache['stores']['file']['path'];
  $cache = folderSize($pathCache);
}else{
  $cache = __('(Not Found)');
}



title_head( __('Cache Management').' ['.formatBytes($cache).']' );

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

 ?>
<style>
  .img_over_1{
    margin: -1px -1px 0 -1px;
    height: 180px;
    overflow: hidden;
    position: relative;
}
.img_over_1 img{
    position: absolute;
    top:50%;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    -o-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);;
}
.profile_details .profile_view{
    padding:0;
    width: 100%;
}
.page-title .title_right .pull-right, .list_status .post-status{
  margin: 0;
}
.list_status .post-status:not(.active){
    background-color: buttonface;
    color: black;
    font-weight: normal;
}
.page-title .title_right, .page-title .title_left{
  width: auto;
}
.notify-plugin{
  padding: 10px;
  border-left: 5px solid;
  background: #fff8e5;
  margin-bottom: 10px;
  color: black;
}
.tr_notify td{
  border-top: none !important;
  padding: 0;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
  line-height: 28px;
}
</style>

<div class="">

  <div class="row">
  

  <div class="col-md-12">


<div class="x_panel">
  <div class="x_title">
    <h2>@__('Cache list')</h2>
    <div class="clearfix"></div>
</div>

<div class="x_content">


    <form method="POST">
          <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
          <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-xs-3">@__('Title')</th>
                    <th >@__('Description')</th>
                    <th >@__('Type')</th>
                    <th >@__('Creator')</th>
                    <th >@__('Status')</th>
                    <th >@__('Action')</th>
                </tr>
            </thead>
            <tbody>
            @foreach($caches as $k => $c)
              <tr>
                <td>
                  {!!$c['title']!!}
                </td>
                <td>
                  {!!$c['description']!!}
                </td>
                <td>
                  {!!$c['type']!!}
                </td>
                <td>
                  {!!$c['creator']!!}
                </td>
                <td>
                  @if( Cache::has($k) )
                  ENABLED
                  @endif
                </td>
                <td>
                  <button data-image="{!!asset('admin/images/image-loading-clear-cache.svg')!!}" data-message="Clearing cache, please wait a moment" type="submit" name="flush" value="{!!$k!!}"  class="vn4-btn vn4-btn-blue">@__('Flush Cache')</button>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
    </form>
</div>
</div>
</div>
</div>
</div>
@stop
