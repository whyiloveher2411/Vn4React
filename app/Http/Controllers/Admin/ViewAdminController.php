<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

use AdminSidebar;

use Illuminate\Http\Request;

use Route;
use File;
use Auth;
use Vn4Model;
use Cache;

class ViewAdminController extends BaseController {

	protected $object;

	protected $setting;

    protected function getDataTable(Request $r, $type){

        use_module(['post']);

        return vn4_get_data_table_admin($type, true);

    }
    
	protected function checkPermission(Request $r,$type, $post){

		$routeAray = ['admin.create_and_show_data','admin.create_data','admin.show_data'];

		$action = $r->get('action_post',false);

		$routeName = Route::currentRouteName();

		if(!isset($this->object->$type) && array_search($routeName, $routeAray) !== false){
			vn4_create_session_message( __('Error'), __('Does not exist post type ').$type, 'error' , true);
			return redirect()->route('admin.index');
		}

		if(!check_permission($type.'_delete') && $post && $action == 'delete' && array_search($routeName, $routeAray) !== false){

			vn4_create_session_message( __('Warning'), __('You are not allowed to remove').' '.__($this->object->{$type}['title']), 'warning' , true);

			return redirect()->back();

		}

		if(!check_permission($type.'_detail') && $post && $action == 'detail' && array_search($routeName, $routeAray) !== false){

			vn4_create_session_message( __('Warning'), __('You are not allowed view').' '.__($this->object->{$type}['title']), 'warning' , true);

			return redirect()->back();

		}

		if(!check_permission($type.'_edit') && $post && $action == 'edit' && array_search($routeName, $routeAray) !== false){

			vn4_create_session_message( __('Warning'), __('You are not allowed edit').' '.__($this->object->{$type}['title']), 'warning' , true);

			return redirect()->back();
		}
		
		if(!check_permission($type.'_create') && $routeName != 'admin.show_data' && !$post){

			vn4_create_session_message( __('Warning'), __('You are not allowed create').' '.__($this->object->{$type}['title']), 'warning' , true);

			return redirect()->back();

		}

		if($routeName != 'admin.create_data' && array_search($routeName, $routeAray) !== false){
			if(!check_permission($type.'_list')){

				vn4_create_session_message( __('Warning'), __('You are not allowed watch list').' '.__($this->object->{$type}['title']), 'warning' , true);

				return redirect()->back();

			}
		}

		return true;

	}

	private static function check_unique_input($input, $fields, $type, $post_id, &$message = array() ){

		$post = (new Vn4Model($fields['table']))->where('type',$type)->where(Vn4Model::$id,'!=',$post_id);

		$flag = false;

		foreach ($fields['fields'] as $key => $value) {
			if( isset($value['unique']) ){
				$message[] = $value['unique']; 
				$post->where($key,trim($input[$key]));
				$flag = true;
			}
		}

		if( $flag ){
			$message = implode('\r\n ', $message);
			return  $post->count() < 1;
		}

		return true;

	}

	private static function changeDataInput( $input, $fields, $table, $type, &$taxonomy ){

        $fields['status'] = true;

        foreach ($fields as $key => $value) {

    		if( is_array($value) && !isset($value['view']) ) $value['view'] = 'input';

    		if( is_array($value) && !is_array($value['view']) ){

    			if( isset( $input [ $key ] ) && is_string( $input [ $key ] ) ){
	                $input[ $key ] = trim($input[ $key ]);
	            }

	            if(  File::exists( $resources = backend_resources('particle/input_field/'.$value['view'].'/post.php') ) ){
	                include $resources;
	            }
    		}else{

    			if( isset($value['view']['post']) ){
    				$input = $value['view']['post']($input);
    			}
    			
    		}

        }

        $input = apply_filter('change_data_'.$type,$input,false);
        
        return $input;
        
    }

	private function validate_input($r, $type){

		use_module(['post']);
    
        $admin_object = get_admin_object($type);

        $input = $r->all();

        $fields = $admin_object['fields'];

        $taxonomy = null;

        $input = vn4_unset_input_not_belong_post( $admin_object, $input, $type );

        $input = self::changeDataInput($input, $fields ,$admin_object['table'],$type, $taxonomy);

        // if( $admin_object['public_view'] ){
			$input = array_merge($input,['template'=>$r->get('attributes_template',''),'order'=>$r->get('attributes_order',0)]);
		// }

        $input['type'] = $type;

		return ['input'=>$input,'taxonomy'=>$taxonomy];	

	}


	public function post_add_or_update_post_admin( Request $r, $type ){

		if( config('app.EXPERIENCE_MODE') ){
			return experience_mode();
		}


		if( $r->has('live_edit') ){
			 return $this->post_live_edit($r);
        }

        if( $r->has('change_fields_show') ){
            return $this->change_fields_show_template_table($r);
        }

        if( $r->has('change_fields_groupby') ){
            return self::change_fields_groupby_template_table($r);
        }

        if( $r->get('type_view') === 'custom-fields' ){

        	return self::update_custom_fields($r, $type);

        }
		// if( duplicate_submission(true) ){

  //           vn4_create_session_message( __('Warning'), __('Warning duplicate submission'), 'warning' , true );
		// 	return redirect()->back();
		// }

        $post_id = $r->get('post',false);

        if( $r->get('action_post') === 'edit' && $post_id ){
        	$list_param_find = [Vn4Model::$id=>$post_id];
        }else{
        	$list_param_find = [];
        }
       	//validate input
		$validate = $this->validate_input($r, $type);

		$result = Vn4Model::newOrEdit( $type, $list_param_find, $validate['input'], $validate['taxonomy'], $r );
		
		$routeName =  Route::currentRouteName();

		$routeType = Route::current()->parameters['type'];

		return redirect()->route($routeName, array_merge( $_GET, ['type'=>$routeType,'post'=>$result->id,'action_post'=>'edit'] ) );

	}

	private function update_custom_fields( $r, $type ){


		$metas = $r->get('meta');

		$metaResult = [];

		foreach ($metas as $input) {

			$value = $input['value'];
			$key = $input['key'];

			$string = str_replace('\n', '', $value);
			$string = rtrim($string, ',');
			$string = "[" . trim($string) . "]";
			$json = json_decode($string, true);

			if( isset($json[0]) ) $value = $json[0];

			$metaResult[$key] = $value;

		}

		$post = $r->get('post');
		$action = $r->get('action_post');

		if( $action === 'edit' && $post = get_post($type, $post) ){

			$post->meta = json_encode($metaResult);
        	$post->save([],false);
        	
    		vn4_create_session_message( __('Success'), __('Edit Meta Success!'), 'success' , true );

    		Cache::forget($post->type.'_'.$post->id);

	        if( $post->slug ){
	            Cache::forget('getPostBySlug_'.$post->type.'##slug##'.$post->slug);
	        }

		}else{
    		vn4_create_session_message( __('Error'), __('Edit Meta failed'), 'error' , true );
		}



		$routeName =  Route::currentRouteName();
		$routeType = Route::current()->parameters['type'];
		return redirect()->route($routeName, array_merge( $_GET, ['type'=>$routeType,'post'=>$post,'action_post'=>'edit'] ) );

	}

	protected function change_fields_show_template_table(Request $r){

		$fields = $r->get('fields',[]);

		$post_type = $r->get('type');

		Auth::user()->updateMeta('show_fields_show_template_table_'.$post_type,$fields);

		return response()->json(['success'=>true]);

	}

	protected function change_fields_groupby_template_table($r){

		$fields = $r->get('fields','');

		$post_type = $r->get('type');

		Auth::user()->updateMeta('show_fields_groupby_template_table_'.$post_type,$fields);

		return response()->json(['success'=>true]);
	}

	protected function post_live_edit(Request $r){

		$post = get_post($r->get('post_type'),$r->get('live_edit'));

		$name = $r->get('name');
		$value = $r->get($name);

		if( is_array($value) ){
			$value = json_encode($value);
		}

		if( $value === null ) $value = '';

        $post->{$name} = $value;
        $post->save();
        
        return response()->json(['success'=>true]);

	}


	protected function get_data_view(Request $r, $type){

		$action_post = $r->get('action_post','default');

		$data_view['postTypeConfig'] = $this->object->{$type};

		$data_view['post_type'] = $type;

		if( $action_post == 'detail' ){
			$data_view['detail'] = true;
		}

		return $data_view;
	}
}




