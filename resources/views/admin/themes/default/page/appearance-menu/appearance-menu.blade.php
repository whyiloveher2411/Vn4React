@extends(backend_theme('master'))

<?php 

$plugins = plugins();

foreach ($plugins as $plugin) {

  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/appearance.php')) ){
    include $file;
  }

}

if( file_exists($file = cms_path('resource','views/themes/'.theme_name().'/inc/appearance.php') )) {
   include $file;
}

title_head(__('Menus'));
?>

@if(!check_permission('appearance-menu_view'))
{!!dd('Bạn không có quyền xem quản lý menu')!!}
@endif

@section('css')
   <style>
      .vn4_tabs_top .content-bottom{
         padding: 10px 0 10px 0;
         background-color: transparent;
         border: none;
         border-top: 1px solid #ddd;
      }
   </style>
@stop

@section('content')
   <div class="">
      <?php 
         echo vn4_view(backend_theme('page.appearance-menu.tab-edit-menu'));
       ?>
	</div>
@stop
