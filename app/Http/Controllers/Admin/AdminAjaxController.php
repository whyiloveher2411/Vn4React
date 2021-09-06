<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use File;
use Vn4Model;


class AdminAjaxController extends ViewAdminController {

    public function index(Request $r, $function){

        $action = do_action('ajax'.$function, $r);

    	if( $r->isMethod('POST') && $r->ajax() ){

    		if( $action ) return $action;

        	return $this->$function($r);
        }

        if( $r->isMethod('get') ){

            if( $action ) return $action;

            return $this->$function($r);

        }

    }

    private function setUserModeView(Request $r){
        $mode = $r->get('mode');

        if( file_exists( cms_path('public','admin/css/mode/'.$mode.'.css') ) ){
            \Illuminate\Support\Facades\Auth::user()->updateMeta('admin_mode',[$mode, $r->get('name')]);
            return response()->json(['reload'=>true]);
        }

        return response()->json(['message'=>'Not Found Mode.']);

    }

    private function search( Request $r){

        $admin_object = get_admin_object();

        $search = trim($r->get('search'));

        $stringSearchArray = explode(':', $search);

        $keySearch = mb_strtolower( str_replace(' ', '', preg_replace( '/[^ \w]+/', '', $stringSearchArray[0])));

        $searchArray = include backend_resources('page/search/search.php');

        $channel = 'default';

        if( $stringSearchArray[0] !== 'post' ){

            if( isset($searchArray[$keySearch]) && isset($stringSearchArray[1]) ){
                $channel = $keySearch;
            }elseif( isset($searchArray[$keySearch]) ){
                $channel = $keySearch;
            }

        }


        $data = [];

        if( is_array($searchArray[$channel]) && isset($searchArray[$channel]['callback']) ){

            if( is_callable($searchArray[$channel]['callback']) ){
                $data = $searchArray[$channel]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
            }elseif( isset( $searchArray[$searchArray[$channel]['callback']] ) ){
                $data = $searchArray[$searchArray[$channel]['callback']]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
            }

        }

        return response()->json(['data'=>$data,'learn_more'=>['title'=>__t('Learn More'),'link'=>route('admin.page',['page'=>'search','vn4-tab-left-keyword'=>$channel,'q'=>$stringSearchArray[1]??''])]]);

    }

    private function getFormatDateTime(Request $r){
        return response()->json(['result'=>date($r->get('data'))]);
    }

    private function validateHTML(Request $r){

    	if( !$r->has('code') ) dd('error!!');

		$data = array('fragment' => '<!DOCTYPE html><html lang="en"><head><title>Title of the document</title></head><body>'.$r->get('code').'</body></html>');

		$data['output'] = 'soap12';

		$resource = curl_init('http://validator.w3.org/check');
		curl_setopt($resource, CURLOPT_USERAGENT, 'curl');
		curl_setopt($resource, CURLOPT_POST, true);
		curl_setopt($resource, CURLOPT_POSTFIELDS, $data);
		curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($resource);

		return response()->json(['html'=>$response.'<script type="text/javascript" src="'.asset('public/admin/js/validate-html.js').'"></script>']);
    }

    private function getPageOfSettingHomepage(Request $r){

    	$post_type = $r->get('post-type','page');

		$page_home = get_posts($post_type,[
            'count'=>1000,
            'order'=>['created_at','asc'],
            'select'=>[\App\Vn4Model::$id,'title']
        ]);

		return response()->json(['items'=>$page_home]);

    }

    private function registerSlug(Request $r){

        $slug = registerSlug($r->get('slug','slug'), $r->get('post_type','PostController_line_40'), $r->get('me_id',-1) );

        return response()->json(['slug'=>$slug,'permalinks'=>get_permalinks($r->get('post_type'), $slug)]);

    }

    private function getPublicViewPost(Request $r){

        $type = $r->get('type');

        if( !$type ) return response()->json(['message'=>'type is request']);

        $admin_object = get_admin_object($type);

        if( !$admin_object ) return response()->json(['message'=>'None Post Type '.$type]);

        if( !$admin_object['public_view'] ) return response()->json(['message'=>'Post Type not design to view public']);

        $id = $r->get(Vn4Model::$id);

        if( !$id ) return response()->json(['message'=>'id is request']);

        $post = get_post($r->get('type'), $r->get(Vn4Model::$id));

        if( !$post ) return response()->json(['message'=>'Don\'t find post id: '.$id ]);

        return vn4_redirect(get_permalinks($post));

    }

    private function getCategory(Request $r){

        $data = do_action('getCategory',$r);

        $type = $r->get('type');
        
        if( !$data ) $data = get_posts($type,10000);

        return response()->json(['data'=>$data]);
    }

    private function filemanagerCreateThumbnail( Request $r){

        $result = $r->get('value');

        if(  File::exists( $resources = backend_resources('particle/input_field/image/thumbnail.php') ) ){
            include $resources;
        }

        return response()->json(['value'=>$result]);
    }

    private function filemanagerUploadFileDirect(Request $r){

        if( $r->hasFile('file') ){

            $public_path = cms_path();

            if( $r->has('type') && $admin_object = get_admin_object($r->get('type')) ){
                $folder =  'uploads/'.str_slug($admin_object['title']);
            }else{
                $folder = 'uploads/upload-direct/'.date('d-m-Y');
            }

            File::isDirectory($public_path.$folder) or File::makeDirectory($public_path.$folder, 0777, true, true);

            $file = $r->file('file');

            $result = [];

            if( is_array($file) ){

                foreach ($file as $image) {
                    $name = str_random(10).'_'.time().'_'.$image->getClientOriginalName();
                    $destinationPath = $public_path.$folder.'/';
                    $image->move($destinationPath, $name);
                    $result[] = asset($folder.'/'.$name);
                }
            }else{

                $image = $file;

                $name = str_random(10).'_'.time().'_'.$image->getClientOriginalName();
                $destinationPath = $public_path.$folder;
                $image->move($destinationPath, $name);
                $result[] = asset($folder.'/'.$name);
            }

            return response()->json(['files'=>$result]);

        }
    }

}




