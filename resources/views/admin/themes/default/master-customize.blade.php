<!DOCTYPE html>
<html lang="{!!App::getLocale()!!}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{!!__('Customize'),': ',setting('general_site_title','Site title')!!}</title>
    <?php do_action('vn4_head'); ?>
    <link href="{!!asset('vendors/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
    <link href="{!!asset('')!!}admin/css/custom.min.css" rel="stylesheet">
    <link href="{!!asset('')!!}admin/css/page-customize.css" rel="stylesheet">

    <meta name="domain" content="{!!url('/')!!}">
    
    <meta name="url_create_thumbnail" content="{!!route('admin.controller',['controller'=>'image','method'=>'filemanager-create-thumbnail'])!!}">
    <meta name="url_filemanagerUploadFileDirect" content="{!!route('admin.controller',array_merge(['controller'=>'image','method'=>'filemanager-upload-file-direct'],Route::current()->parameters()))!!}">
      
  </head>

  <body>
    <input type="hidden" name="_token" id="laravel-token" value="{!!csrf_token()!!}">
    <body>
      
      @yield('content')
           
    <script src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>
    <script src="{!!asset('')!!}admin/js/main.js?v=1"></script>

    <?php do_action('vn4_footer'); ?>
    @yield('js')
  </body>
</html>
