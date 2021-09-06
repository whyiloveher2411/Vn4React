<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use File;

use Vn4Model;

class PageController extends Controller {

	public function getPage404(Request $r){
		return errorPage(404,'Page note found');
	}


	public function index(Request $r){

		$action = do_action('index',$r);
		if( $action ) return $action;


  		$theme_option = json_decode(setting('reading_homepage', false),true);

  		if( !isset($theme_option['type']) ) $theme_option = ['type'=>'default','static-page'=>'none','post-type'=>'page','post-id'=>0];

  		$theme = theme_name();

		if( $theme_option['type'] === 'custom' && $page = get_post($theme_option['post-type'],$theme_option['post-id']) ){
			return view_post($page);
		}elseif( $theme_option['type'] === 'static-page' && view()->exists( $view = 'themes.'.$theme.'.page.'.$theme_option['static-page']) ){

		}else{
			$view = 'themes.'.theme_name().'.index';
		}

		title_head(setting('general_description',__('A simple website using Vn4CMS')));

		return vn4_view($view);

	}
	
	public function getPage(Request $r, $page){

		$action = do_action('getPage',$page);
		if( $action ) return $action;

		if( $post = getPostBySlug('page',$page) ){
			return view_post($post);
		}

		// return errorPage(404,'Page note found');

		$theme = theme_name();
		
		$theme_option = json_decode(setting($theme.'_reading_'.$page, false),true);
		
		if( !isset($theme_option['type']) ) $theme_option = ['type'=>'default','static-page'=>'none','post-type'=>'page','post-id'=>0];

  		$theme = theme_name();

  		if( $theme_option['type'] === 'custom' && $page = get_post($theme_option['post-type'],$theme_option['post-id']) ){
			return view_post($page);
		}

		$view = 'themes.'.$theme.'.page.'.$page;

		if( view()->exists( $view ) ){

			title_head(ucwords( preg_replace('/-/', ' ', str_slug(str_replace('.blade.php', '', $page)) )  ));

			if(  File::exists( cms_path('resource','views/themes/'.$theme.'/page/'.$page.'-post.php') ) ){
				
               $result = include cms_path('resource','views/themes/'.$theme.'/page/'.$page.'-post.php');

               if( $result !== 1 ) return $result;
            }

			return vn4_view($view);

		}

		return errorPage(404,'Page note found');

	}

	
	public function postDetail(Request $r, $custom_post_slug, $post_slug, $slug_detail = null){

		$admin_object = get_admin_object();

		if( isset($GLOBALS['custom_post_slug'][$custom_post_slug]) ){

			if( $post = getPostBySlug($GLOBALS['custom_post_slug'][$custom_post_slug],$post_slug) ){

				$action = do_action('postDetail',$post, $custom_post_slug, $post_slug, $slug_detail);
				if( $action ) return $action;

				if( $post ){

					if( $post->is_homepage ){
						$route = json_decode($post->is_homepage, true);
	        			return route($route['route-name'],$route['parameter']);
					}
					return view_post($post, $slug_detail);
				} 
			}
		}

		return errorPage(404,'Not found post');
	}

	public function anyControllerFrontend(Request $r, $controller, $method){

		$theme = theme_name();

       	$result = include cms_path('resource','views/themes/'.$theme.'/inc/controllers/'.str_slug($controller).'.php');

       	if( $result ){

   		 	if( is_array($result) ){

	            if( isset($result[$method]) ){
       				return $result[$method]($r);
	            }

	            return redirect()->route('index');

          	}

          	if( $result !== 1 ){
	            return $result;
          	}

       	}

        return redirect()->route('index');

	}


	public function previewEmail(){
	 	return vn4_view('default.emails.temp');
	}

}
