<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use View;
class CreateDataController extends ViewAdminController{

    public function index(Request $r,$type){

        if( !$this->object ){
            $this->object =  (object) get_admin_object();
            View::share ( 'admin_object', $this->object);
        }

        if(  $postId = $r->get('post') ){
            $data_view['post'] = get_post($type, $postId);
        }else{
            $data_view['post'] = null;
        }

        $checkPermission = parent::checkPermission($r,$type, $data_view['post']);

        if($checkPermission !== true){
            return $checkPermission;
        }

        $data_view['post_data'] = $this->object->{$type};

        $data_view['post_type'] = $type;

        if($r->isMethod('get')){

            $data_view = array_merge($data_view,$this->get_data_view( $r, $type ));

            if( $r->get('action_post',false) === 'detail' &&  $data_view['post']){
                return vn4_view(backend_theme('post-type.detail'),$data_view);
            }

            return vn4_view(backend_theme('post-type.create_data'),$data_view);
        }

        if($r->isMethod('POST')){

             return $this->post_add_or_update_post_admin( $r, $type );

        }
    }

}
