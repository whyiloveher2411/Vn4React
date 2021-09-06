<?php

$GLOBALS['backend_theme'] = 'default';

$GLOBALS['vn4_table_prefix'] = config('app.TABLE_PREFIX');

function vn4_tbpf(){
	return $GLOBALS['vn4_table_prefix'] ;
}

function cache_tag( $group , $key , $value = null , $default = null ){

	if( $value === null ){

		$cache = Cache::get($group);

		if( isset($cache[$key]) ) return $cache[$key];

		return $default;

	}else{

		$cache = Cache::get($group,[]);

		if( is_callable($value) ){


			if( isset($cache[$key]) ){
				return $cache[$key];
			}

			$cache[$key] = $value();

			Cache::forever($group,$cache); 

			return $cache[$key];

		}elseif( $value === 'clear' ){

			if( $key === null ){
				Cache::forget($group); 
			}else{
				unset($cache[$key]);
				Cache::forever($group,$cache); 
			}

			
			
			return true;
		}

		
	}

}


function setting($keyword = null , $default = '', $isJson = false ){

	return Cache::rememberForever('setting.'.($keyword??''), function() use( $keyword, $default, $isJson ) {

		if( $keyword === null && isset($GLOBALS['setting']) ){
			return $GLOBALS['setting'];
		}elseif( $keyword === null ){

			$obj = new Vn4Model(vn4_tbpf().'setting');

			$obj = $obj->whereType('setting')->pluck('content','key_word');

			$GLOBALS['setting'] = $obj;

			return $obj;

		}

		if( isset($GLOBALS['setting'][$keyword]) ){

			if( $GLOBALS['setting'][$keyword] !== '' ){ 
				
				if ($isJson ){
					return json_decode( $GLOBALS['setting'][$keyword], true ); 
				}else{
					return $GLOBALS['setting'][$keyword]; 
				}
			}

			return $default;

		} 

		$obj = new Vn4Model(vn4_tbpf().'setting');

		$obj = $obj->where('type','setting')->pluck('content','key_word');

		$GLOBALS['setting'] = $obj;

		if( isset($obj[$keyword]) && $obj[$keyword] !== '' ){

			if ($isJson ){
				return json_decode( $obj[$keyword], true ); 
			}else{
				return $obj[$keyword];
			}

		} 

		return $default;

	});
	
}

function vn4_log($text , $param = array(), $stacktrace = null , $type = 'info', $file = null){




    $list_type = [
        'emergency'=>'EMERGENCY',
        'alert'=>'ALERT',
        'critical'=>'CRITICAL',
        'error'=>'ERROR',
        'warning'=>'WARNING',
        'notice'=>'NOTICE',
        'info'=>'INFO',
        'debug'=>'DEBUG',
    ];

    if( !$file ){
        $file = 'vn4-'.date('Y-m-d').'.log';
    }

    if( !isset($list_type[$type]) ){
        $type = 'info';
    }

    if( is_array($param) ){

        $array_json = '';

        foreach ($param as $key => $value) {
            $array_json .= "\n".$key.': '.$value;
        }

    }else{
        $array_json = '';
    }

    $text .= "\n[stacktrace] $array_json \nForm IP: ".Request::ip()."\nURL: ".url()->full();

    if ( isset( $_SERVER["HTTP_REFERER"] ) ){
    	$text .= "\nURL Referer: $_SERVER[HTTP_REFERER]";
	}

	$text .= "\n".$stacktrace;

    $text_log = '['.date('Y-m-d H:i:s').'] '.config('app.APP_ENV').'.'.$list_type[$type].': '.$text;

    $path = dirname(cms_path('storage').'logs/'.$file);

    File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

    file_put_contents(cms_path('storage').'logs/'.$file, $text_log, FILE_APPEND);

}

function sql_replace($q){
	return vsprintf(str_replace(['?'], ['\'%s\''], $q->toSql()), $q->getBindings());
}

function add_route($url, $name, $hook, $callback, $where = [] ){

	add_action($hook,function() use ($url, $name, $hook, $callback, $where) {

		if(!Route::has($name)){

			Route::any($url,['as'=>$name,'uses'=>function() use ($callback) {

				$arg = func_get_args ();

				array_unshift($arg,request());

				return call_user_func_array ($callback, $arg ) ;

			}])->where($where);
		}

	});

}

function is_admin(){

	if( isset($GLOBALS['is_admin'] )) return $GLOBALS['is_admin'];

	$GLOBALS['is_admin'] = request()->is(setting('security_prefix_link_admin','admin').'/*') || request()->is('api/*');

	return  $GLOBALS['is_admin'];
}

function is_url($str){
	if(filter_var($str, FILTER_VALIDATE_URL)){
		return true;
	}else{
		return false;
	}
}


$GLOBALS['theme_name'] =  setting('general_client_theme','general_client_theme');

function theme_name(){
	return $GLOBALS['theme_name'];
}

function theme_options($group, $key = null, $default = null ){

	$group = do_action('theme_options_function',$group, $key, $default)??$group;

	$theme_name = theme_name();
	$themeOptionsValue =  Cache::rememberForever('theme-options.'.$theme_name.'.'.$group, function() use( $theme_name, $group ) {
		$option = Vn4Model::firstOrAddnew(vn4_tbpf().'theme_option',['key'=>$theme_name.'.'.$group]);
		$content = json_decode($option->content,true);
		if( !is_array($content) ) $content = [];
		return $content;
	});


	if( !$key ) return $themeOptionsValue;

	if( is_array($key) ){

		$result = [];

		foreach ($key as $k => $v) {

			if( isset($themeOptionsValue[$k]) ){
				$result[$k] = $themeOptionsValue[$k];
			}else{
				$result[$k] = $v;
			}
		}

		return $result;

	}

	if( isset($themeOptionsValue[$key]) ) return $themeOptionsValue[$key];

	return $default;

}

function save_theme_options($group, $key, $value ){

	$theme_name = theme_name();

	$option = Vn4Model::firstOrAddnew(vn4_tbpf().'theme_option',['key'=>$theme_name.'.'.$group]);

	$content = json_decode($option->content,true);

	if( !is_array($content) ) $content = [];

	$content[$key] = $value;

	$option->content = json_encode($content);

	return $option->save();
}


function theme_asset($file = ''){
	if( $file === ''){
		return asset('themes/'.theme_name().'/').'/';
	}
	return asset('themes/'.theme_name().'/'.$file);
}

function theme_extends($name = 'master'){
	return 'themes.'.theme_name().'.layout.'.$name;
}



function theme_view($view, $param = [] ){
	return vn4_view('themes.'.theme_name().'.'.$view,$param);
}

function get_date($date, $format = null){

	if( !$format ){
	    $format = setting('general_date_format','d-m-Y');
	}

    return \Carbon\Carbon::parse($date)->format($format);

}

function get_time($time, $format = null){

	if( !$format ){
    	$format = setting('general_time_format','H:i:s');
	}

    return \Carbon\Carbon::parse($time)->format($format);
}

function get_date_time($datetime, $format = null){
    
    if( !$format ){
    	$format_date = setting('general_date_format','d-m-Y');
    	$format_time = setting('general_time_format','H:i:s');
    	$format = $format_date.', '.$format_time;
    }
    return \Carbon\Carbon::parse($datetime)->format($format);
}

function get_admin_object( $name = null ){
    
    if ( isset($GLOBALS['function_helper_get_admin_object']) ){
        $admin_object = $GLOBALS['function_helper_get_admin_object'];
    }else{
        $admin_object = include cms_path('resource','views/admin/themes/'.$GLOBALS['backend_theme'].'/data/object.php');
        $GLOBALS['function_helper_get_admin_object'] = $admin_object;
    }


    if( $name !== null ){

        if ( isset($admin_object[$name]) ) return $admin_object[$name];

        return null;
        
    }

    return $admin_object;
}

/**
Function helper
*/

function title_head($title = null){

	if($title === null){

		$action = do_action('title_head');

		if( $action ) return $action;

		return setting('general_site_title');
	}

	add_action('title_head',function() use ($title) {
		return $title;
	});

	return $title;

}

function use_module($arg, $param = null ){

	if( is_array($arg) ){
		foreach ($arg as $value) {
			include_once __DIR__.'/../module/'.$value.'.php';
		}	
	}elseif( is_string($arg) ){
		return include_once __DIR__.'/../module/'.$arg.'.php';
	}
	
}

function get_media($content, $default = '/img/default.jpg', $thumbnail = null ){

	if( $thumbnail ){

		if( !is_array($content) ){
			$content = json_decode($content,true);
		}

		if( isset($content['thumbnail'][$thumbnail]) ){
			return asset($content['thumbnail'][$thumbnail]);
		}

		if( isset($content['link']) ){
			return asset($content['link']);
		}

		return $default;

	}

	if( is_string($content) ){
		$content = json_decode($content);
	}

	if( $content ){

		if( is_object($content) ){
			if( $content->type_link === 'local' ) return asset($content->link);
			return $content->link;
		}

		if( is_array($content) ){

			if( !is_array($default) ){

				if( isset($content[0]) ){
					$content = $content[0];
				}

				if( $content['type_link'] === 'local' ) return asset($content['link']);
				return $content['link'];

			}else{
				$result = [];

				foreach ($content as $img) {
					if( $img->type_link === 'local' ) $result[] = asset($img->link) ; else $result[] = $img->link;
				}

				return $result;
			}
		}
	}	
	return $default;
}

function get_slug_custom_post_config($type){

	$admin_object = get_admin_object($type);

	if( !$admin_object ){
		return null;
	}

	if( isset($admin_object['slug']) ){
		return $admin_object['slug'];
	}

	return $type;

}

function convert_slug_custom_post_to_name($slug){
	get_admin_object();

	if( isset($GLOBALS['custom_post_slug'][$slug]) ){
		return $GLOBALS['custom_post_slug'][$slug];
	}

	return false;
}


/**
Register Slug
*/

function registerSlug($slug_old, $me_type, $me_id = null, $register = false){
	// dd(debug_backtrace()[1]['function']);
	$slug_old = str_slug($slug_old);

	if( !$me_id ) $me_id = -1;

	$slug_new = $slug_old;
	// dd($slug_new);
	$admin_object = get_admin_object($me_type);

	if(  ($slugDB = Vn4Model::table(vn4_tbpf().'slug')->where('slug',$slug_new)->where('post_id','!=',$me_id)->first() ) || ($slugDB = Vn4Model::table($admin_object['table'])->where('id','!=',$me_id)->where('slug',$slug_new)->first() ) ){

		$index_slug = 2;
		$slug_new = $slug_old.'-'.$index_slug;

		while (  ($slugDB = Vn4Model::table(vn4_tbpf().'slug')->where('slug',$slug_new)->where('post_id','!=',$me_id)->first() ) || ($slugDB = Vn4Model::table($admin_object['table'])->where('id','!=',$me_id)->where('slug',$slug_new)->first() ) ){
			++$index_slug;
			$slug_new = $slug_old.'-'.$index_slug;
		}


	}
	if( $register && $me_id != -1 ){

		if( !$post = Vn4Model::table(vn4_tbpf().'slug')->where('type',$me_type)->where('post_id',$me_id)->first() ){
			$post = new Vn4Model(vn4_tbpf().'slug');
			$post->type = $me_type;
			$post->post_id = $me_id;
		}

		$post->slug = $slug_new;
		$post->setTable(vn4_tbpf().'slug');

		if( !$post->number_update ){
			$post->number_update = 1;
		}else{
			$post->number_update = $post->number_update + 1;
		}

		$post->save([],false);
	}

	return $slug_new;

}

function duplicate_submission($is_check = false){

	if( $is_check ){

		$FORM_SECRET = request()->get('FORM_SECRET',null);
		$FORM_SECRET_SV = session('duplicate_submission', false);

		session()->forget('duplicate_submission');
		
		return $FORM_SECRET !== $FORM_SECRET_SV;

	}else{

		$hash = Hash::make(time().str_random(10));
		session(['duplicate_submission'=>$hash]);
		return '<input type="hidden" value="'.$hash.'" name="FORM_SECRET">';
	
	}
	
}

function check_menu_item($menu_item){

	return $menu_item['posttype'] === 'custom links'
		 || $menu_item['posttype'] === 'page-theme'
		 || $menu_item['posttype'] === 'route-static'
		 || $menu_item['posttype'] === 'menu-items'
		 || get_admin_object($menu_item['posttype']);

}


function errorPage($code, $messages, $messages_real = '(No information)', $exception = null){

	if( Auth::check() ){
		throw new Exception($code .' - ' .$messages.' - '.$messages_real);
	}

	if( !$exception ){
		vn4_log( $code .' - ' .$messages, request()->all() , $messages_real , 'error');
	}

	if( view()->exists( $view = 'themes.'.theme_name().'.errors.'.$code) ){
		return response()->view($view, ['errorCode'=>$code,'messages'=>$messages, 'messages_real'=>$messages_real ],$code );
	} 

	return redirect()->route('index');
}

function plugins($all = false){

    if( isset($GLOBALS['listPlugin']) ) return $GLOBALS['listPlugin'];

     $obj = new Vn4Model(vn4_tbpf().'plugin');

     if( !$all ){
        $listPlugin = $obj->where('status','publish')->orderBy('priority','asc')->take(100)->get();
     }else{
         $listPlugin = $obj->take(100)->orderBy('priority','asc')->get();
     }

     $GLOBALS['listPlugin'] = $listPlugin->keyBy('key_word');
     return $listPlugin;
}

function plugin($name){

  foreach ($GLOBALS['listPlugin'] as $plugin) {
    if( $plugin->key_word === $name ) return $plugin;
  }

  return null;

}

function view_plugin($plugin, $view, $data = array(), $mergeData = array())
{
	$data['plugin'] = $plugin;
     return vn4_view('plugins.'.$plugin->key_word.'.'.$view, $data, $mergeData);
}

function plugin_asset($plugin, $file = ''){
	if( is_string($plugin) ){
    	return  asset('plugins/'.$plugin.'/'.trim($file,'/'));
	}
    return  asset('plugins/'.$plugin->key_word.'/'.trim($file,'/'));
}

function get_parameter_route($arg){
	
    if( is_string($arg) ){
        $return1 = Route::current()->parameters[$arg];
        $return2 = Request::get('param_of_route_'.$arg);

        return vn4_one_or( $return1, $return2 );
    }
    if( is_array($arg) ){

        $return = [];

        foreach ($arg as $name) {

            $result1 = Route::current()->parameters[$name];
            $result2 = Request::get('param_of_route_'.$name);

            $return[$name] =  vn4_one_or($result1, $result2 );
        }

        return $return;

    }

    return null;

}


/**
    POST
*/

function register_custom_post_slug($post_type, $slug){
	add_filter('object_admin_all',function($obj) use ($post_type, $slug) {
		if( isset($obj[$post_type]) ){
			$obj[$post_type]['slug'] = $slug;
		}

		return $obj;
	});
}


function get_posts($post_type, $parameters = [] ){

	if( !is_array($parameters) ){
		$parameters = ['count'=>$parameters];
	}

	$parameters['post_type'] = $post_type;

	if( isset($parameters['cache']) ){

		return Cache::rememberForever('cache_get_posts'.$parameters['cache'], function() use ($parameters) {

			return Vn4Model::getPosts( $parameters );

		});


	}else{
		
		return Vn4Model::getPosts( $parameters );

	}
}

 /**
 * function name: get_post
 * Description: Retrieves post data given a post ID or post object.
 * @param (string) post_type name post type
 * @param (int) id  Post ID
 */
function get_post($post_type = null, $id = null, $select = '*' ){

 	if( $post_type == null ){

        if( isset($GLOBALS['post_current']) ){
            return $GLOBALS['post_current'];
        }

        return null;
    }

    if( $id === null ) return null;

    $admin_object = get_admin_object($post_type);
    
    if(!$admin_object){
        return null;
    }

    if( is_admin() ){

    	if( is_callable($id) ){

			$post = new Vn4Model($admin_object['table']);

			$post = call_user_func_array($id,[$post]);

    		$post = $post->where('type',$post_type)->first();

    	}else{
    		$post = (new Vn4Model($admin_object['table']))->where(Vn4Model::$id,$id)->select($select)->first();
    	}


        return $post; 
    }else{
    	if( is_callable($id) ){

			$post = new Vn4Model($admin_object['table']);

			$post = call_user_func_array($id,[$post]);

    		$post = $post->where('status','publish')->where('visibility','!=','private')->where('type',$post_type)->select($select)->first();

    	}else{

    		$post = Cache::rememberForever($post_type.'_'.$id, function() use( $admin_object, $id, $post_type, $select) {

	            $post = new Vn4Model($admin_object['table']);

            	$post = $post->where(Vn4Model::$id,$id)->where('status','publish')->where('visibility','!=','private')->where('type',$post_type)->select($select)->first();
	            
            	if( $post && $post->slug ){
            		Cache::forever('getPostBySlug_'.$post_type.'##slug##'.$post->slug, $post);
            	}

	            return $post;

	        });

    	}


        return $post;
    }
    
}

function get_permalinks( $post, $slug = null, $deep = null ){
	
    if( is_string($post) ){
        $type = $post;
    }else{
        if( is_array($post) ){
            $type = $post['type'];
            $slug = $post['slug'];
        }else{

        	if( is_object($post) ){

	        	if( isset($post->is_homepage) && $post->is_homepage ){
	        		$action_hook = do_action('get_permalinks',$post->type, $post->slug, $post);
    				if( $action_hook ) return $action_hook;

					$route = json_decode($post->is_homepage, true);
	        		return route($route['route-name'],$route['parameter']);
	        	}
	        	$type = $post->type;

	        	if($post->slug){
		            $slug = $post->slug;
	        	}else{
		            $slug = $post->id;
	        	}
        	}else{
        		return '#';
        	}

        }
    }

    $admin_object = get_admin_object($type);

	if( isset($admin_object['slug']) ){
		$type = $admin_object['slug'];
	}

    $action_hook = do_action('get_permalinks',$type, $slug, $post, $deep);
    
    if( $action_hook ) return $action_hook;

    if( $deep ){
	    return route('post.detail.deep',['custom_post_slug'=>$type,'post_slug'=>$slug,'slug_detail'=>$deep]);
    }

    return route('post.detail',['custom_post_slug'=>$type,'post_slug'=>$slug]);
    
}


function getPostBySlug($post_type, $slug){

	$admin_object = get_admin_object($post_type);
    
    if(!$admin_object){
        return null;
    }

	return Cache::rememberForever('getPostBySlug_'.$post_type.'##slug##'.$slug, function() use( $admin_object, $slug, $post_type) {

        $post = new Vn4Model($admin_object['table']);

    	$post = $post->where(function($q) use ($slug,$admin_object){

    		if( isset($admin_object['fields']['slug']) ){
    			$q->where('slug',$slug);
    		}else{
    			$q->where(Vn4Model::$id,$slug);
    		}
    		
    	})->where('status','publish')->where('visibility','!=','private')->where('type',$post_type)->first();
    	
		if( $post ){
			Cache::forever($post_type.'_'.$post->id, $post);
			return $post;
		}
		return null;
    });
 
}


function get_post_meta( $post, $key = null , $default = null ){

    if( $post ){
    	return $post->getMeta($key, $default);
    }

    return $default;

}

/**
 
    FUNCTION HELPERS

 */

function add_load_javascript_unique($src, $meo, $async = false, $time = 500){
    if(!isset($GLOBALS['javscript_admin'])){
        $GLOBALS['javscript_admin'] = array();
    }

    if(in_array($src,$GLOBALS['javscript_admin'])){
        return;
    }

    $GLOBALS['javscript_admin'][] = $src;
    
    add_action($meo, function() use ($src, $async, $time){

        if($async){
        ?>
            <script>

                $(document).ready(function() {

                  setTimeout(function(){ $.getScript('<?php echo $src ?>'); }, <?php echo $time ?>);
                  
                });

            </script>
        <?php }else{ ?>
            <script type="text/javascript" src="<?php echo $src; ?>" async></script>
        <?php
        }
    },'z');
    
}

function vn4_one_or(){
    $numargs = func_get_args();
    foreach ($numargs as $key => $value) {
        if($value){
            return $value;
        }
    }
}

function add_load_css_unique($src, $meo){

    if(!isset($GLOBALS['css_admin'])){
        $GLOBALS['css_admin'] = array();
    }

    if(in_array($src,$GLOBALS['css_admin'])){
        return;
    }
    $GLOBALS['css_admin'][] = $src;

    add_action($meo, function() use ($src){
        ?>
            <link rel="stylesheet" type="text/css" id="u0" href="<?php echo $src; ?>">
        <?php
    },'z');
    
}

function get_param($arg = null, $only = true){

    if($arg != null && $only){
         $input = Request::only($arg);
    }elseif(!$only){
        $input = Request::except($arg);
    }else{
        $input = Request::all();
    }
    
    return http_build_query($input);

}

/**
	PERMISSION
*/
function check_permission($name)
{
	if(!Auth::check()){
		return false;
	}

	$user = Auth::user();

	if( $user->role === 'Super Admin') return true;

	$permission = $user->permission;

	$permission = explode(', ',  $permission );

	if( is_string($name) ){
		return array_search($name,$permission) !== false;
	}

	if( is_array($name) ){

		foreach ($name as $p) {
			if( array_search($p, $permission) === false ){
				return false;
			}
		}

		return true;

	}

	return false;
}

/**
    IMAGE LAZY LOADING
*/

/* USER-AGENTS
================================================== */
function check_user_agent ( $type = NULL ) {

		if( isset($_SERVER['HTTP_USER_AGENT']) ){
	        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
	        if ( $type == 'bot' ) {
	                // matches popular bots
	                if ( preg_match ( "/googlebot|chrome-lighthouse|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
	                        return true;
	                        // watchmouse|pingdom\.com are "uptime services"
	                }
	        } else if ( $type == 'browser' ) {
	                // matches core browser types
	                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
	                        return true;
	                }
	        } else if ( $type == 'mobile' ) {
	                // matches popular mobile devices that have small screens and/or touch inputs
	                // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
	                // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
	                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
	                        // these are the most common
	                        return true;
	                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
	                        // these are less common, and might not be worth checking
	                        return true;
	                }
	        }
	    }
        return false;
}


function _bot_detected() {

    if( isset($_GET['fb']) && $_GET['fb'] == 1){
        return true;
    }

    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider|facebook|google/i', $_SERVER['HTTP_USER_AGENT'])) {
        return TRUE;
    }
    else {
        return FALSE;
    }

}

/**
	API CURL
*/


function file_get_contents_curl($url,$cookie = null){
	try {

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
		if($cookie){
        	curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
		}

		$data = curl_exec($ch);
		curl_close($ch);

		if( !$data ){
	 		 throw new Exception(curl_error($ch), curl_errno($ch));
	 	} 

		return $data;

	} catch(Exception $e) {

		trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);

	}
}

function file_post_contents_curl($url, $params = [], $cookie = null){
	// init CURL
	$ch = curl_init($url);
	 
	// Has Return
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	// Method POST
	curl_setopt($ch, CURLOPT_POST, count($params));
	 
	// parameter to url
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
	 
	$result = curl_exec($ch);
	 
	curl_close($ch);
	
	return $result;
}


/**
	SHORTCODE
*/
function load_shortcode_posttype(){

	$admin_object = get_admin_object();

	foreach ($admin_object as $object_key => $object) {

		add_shortcode( $object_key, function($param, $content) use ($object_key){

			extract( shortcode_atts([
				'id'=>false,
				'slug'=>false,
				], $param) );

			$param['is_shortcode'] = true;

			if( $id ){

				$post = get_post($object_key, $id);

				if( $post ){
					$param['post'] = $post;
					return get_single_post($post, $param);

				}
			}

			return;

		} );
	}
}


function shortcode_atts( $param_default, $param ){

	foreach ($param_default as $key => $value) {
		if( !isset($param[$key])  ){
			$param[$key] = $value;
		}
	}

	return $param;
}

function do_shortcode($content, $list_short_code = false, $only_content_shortcode = false){

	if( $list_short_code ){
		$all_shortcode = $list_short_code;
	}else{
		$all_shortcode = apply_filter('add_shortcode',[]);
	}

	if( count($all_shortcode) < 1 ){
		return $content;
	}

	preg_match_all( '/\\[(\\[?)('.implode('|', array_keys($all_shortcode)).')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)/', $content, $shortcodes );

	$count = count($shortcodes[0]);

	$array_key = array_keys($all_shortcode);

	$str_result = '';

	for ($i=0; $i < $count; $i++) { 

	//type 1: not tag close, not content
		$string_replace = $shortcodes[0][$i];
		$shortcode_content = $shortcodes[5][$i];
		$shortcode_name = $shortcodes[2][$i];
		$shortcode_param = $shortcodes[3][$i];

		if( $shortcode_param ){

			preg_match_all('/(.+?)="(.+?)"/', $shortcode_param, $parameter_matches);

			$shortcode_param = [];
			$parameter_count = count($parameter_matches[0]);
			for ($j=0; $j < $parameter_count; $j++) { 
				$shortcode_param[trim($parameter_matches[1][$j])] =  trim($parameter_matches[2][$j]);
			}

		}

		if( $only_content_shortcode ){
			$str_result = $str_result.call_user_func_array ($all_shortcode[$shortcode_name], [$shortcode_param,$shortcode_content] );
		}else{
			$content = str_replace($string_replace, call_user_func_array ($all_shortcode[$shortcode_name], [$shortcode_param,$shortcode_content] ) , $content);
		}

	}

	if( $only_content_shortcode ){
		return $str_result;
	}else{
		return $content;
	}

}

function add_shortcode( $name, $callback ){

	add_filter('add_shortcode',function($filter) use ($name, $callback) {

		if( !isset($filter[$name]) ){
			$filter[$name] = $callback;
		}

		return $filter;

	});
}

function image_lazy_loading($src, $class = '', $attr = ''){

    if( !_bot_detected() ){
        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEX6+vqsEtnpAAAACklEQVQI12NgAAAAAgAB4iG8MwAAAABJRU5ErkJggg==" class="image-lazy-loading '.$class.'" data-src="'.$src.'" '.$attr.' /><script>!function(window){var $q=function(q,res){if(document.querySelectorAll){res=document.querySelectorAll(q)}else{var d=document,a=d.styleSheets[0]||d.createStyleSheet();a.addRule(q,\'f:b\');for(var l=d.all,b=0,c=[],f=l.length;b<f;b++)l[b].currentStyle.f&&c.push(l[b]);a.removeRule(0);res=c}return res},addEventListener=function(evt,fn){window.addEventListener?this.addEventListener(evt,fn,!1):(window.attachEvent)?this.attachEvent(\'on\'+evt,fn):this[\'on\'+evt]=fn},_has=function(obj,key){return Object.prototype.hasOwnProperty.call(obj,key)};function loadImage(el,fn){var img=new Image(),src=el.getAttribute(\'data-src\');img.onload=function(){if(!!el.parent){el.parent.replaceChild(img,el)}else{el.src=src}fn?fn():null};img.src=src}function elementInViewport(el){var rect=el.getBoundingClientRect();return(rect.top>=0&&rect.left>=0&&rect.top<=(window.innerHeight||document.documentElement.clientHeight))}var images=new Array(),query=$q(\'img.image-lazy-loading\'),processScroll=function(){for(var i=0;i<images.length;i++){if(elementInViewport(images[i])&&images[i].src != images[i].getAttribute(\'data-src\')){loadImage(images[i],function(){images.splice(i,i)})}}};for(var i=0;i<query.length;i++){images.push(query[i])};setTimeout(function(){processScroll()},400);addEventListener(\'scroll\',processScroll)}(this)</script>';
    }else{
        return '<img class="image-lazy-loading '.$class.'" src="'.$src.'" '.$attr.' />';
    }
}