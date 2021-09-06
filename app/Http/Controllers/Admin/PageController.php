<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Vn4Model;
use File;
use DB;
use Hash;
use Auth;
use View;

class PageController extends ViewAdminController {

   public function getPage(Request $r, $page){

      if( !$this->object ){
          $this->object =  (object) get_admin_object();
          View::share ( 'admin_object', $this->object);
      }

      if($r->isMethod('GET')){

          $custom = false;

          if( file_exists( $file = backend_resources('page/'.$page.'/get.php') ) ){
            $custom = include($file);
          }

          if($custom && $custom !== 1) return $custom;
          

          $checkPermission = check_permission($page.'_view');

          if(!$checkPermission){
            vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
            return redirect()->route('admin.index');
          }

          $page = str_replace('_','.',$page);

          $data_view['obj'] = new Vn4Model();

          $data_view['request'] = $r;

          return vn4_view(backend_theme('page.'.$page.'.'.$page),$data_view);

      }
      
      if($r->isMethod('POST')){

          $checkPermission = check_permission($page.'_view');

          if(!$checkPermission){
            vn4_create_session_message( __('Error'), __('Sorry, you are not allowed to access this page'), 'error' , true );
            return redirect()->route('admin.index');
          }

          if( file_exists( $file = backend_resources('page/'.$page.'/post.php') ) ){
            return include($file);
          }else{
            vn4_create_session_message( __('Error'), __('Not Exits Method Post'), 'error' , true );
            return redirect()->back();
          }
      }
             
   }

   public function getPageTheme(Request $request, $page){

      $theme = theme_name();

      if($request->isMethod('GET')){

          $page = str_replace('_','.',$page);

          $view_share = [];

          $view_share['page'] = $page;

          $custom = false;

          if( file_exists('resources/views/themes/'.$theme.'/backend/'.$page.'/get.php') ){
            $custom = include('resources/views/themes/'.$theme.'/backend/'.$page.'/get.php');
          }

          if($custom && $custom !== 1) return $custom;

          return vn4_view(backend_theme('master-theme-options'),$view_share);

      }
      
      if($request->isMethod('POST')){

          if( file_exists('resources/views/themes/'.$theme.'/backend/'.$page.'/post.php') ){
            return include_once('resources/views/themes/'.$theme.'/backend/'.$page.'/post.php');
          }else{
            vn4_create_session_message( __('Error'), __('Not Exits Method Post'), 'error' , true );
            return redirect()->back();
          }
      } 

   }

    public function pluginController(Request $r, $plugin,  $controller, $method){

        $plugin = plugin($plugin);

        if( !$plugin ){
          return redirect()->route('admin.index');
        }

        $result = include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/controllers/'.str_slug($controller).'.php');

        if( $result ){

          if( is_array($result) ){

            if( isset($result[$method]) ){
              return $result[$method]( $r, $plugin,  $controller, $method );
            }

            vn4_create_session_message( __('Error'), __('Missing method').' '.$method, 'error' , true );

            return redirect()->back();

          }

          if( $result !== 1 ){
            return $result;
          }

        }

        vn4_create_session_message( __('Error'), __('Missing controller').' '.$controller, 'error' , true );
        return redirect()->back();

    }


     public function controller(Request $r, $controller, $method){

        if( !file_exists($file = cms_path('resource','views/admin/themes/default/controllers/'.$controller.'.php')) ){
          vn4_create_session_message( __('Error'), __('Missing controller').' '.$controller, 'error' , true );
          return redirect()->back();
        }

        $result = include $file;

        if( $result ){

          if( is_array($result) ){

            if( isset($result[$method]) ){
              return $result[$method]( $r, $controller, $method );
            }

            vn4_create_session_message( __('Error'), __('Missing method').' '.$method, 'error' , true );

            return redirect()->back();

          }

          if( $result !== 1 ){
            return $result;
          }

        }

        vn4_create_session_message( __('Error'), __('Missing controller').' '.$controller, 'error' , true );

        return redirect()->back();

    }

   public function getViewIndex(){
      return vn4_view(backend_theme('index'));
   }
}
