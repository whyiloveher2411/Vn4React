<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class CreateAndShowDataController extends ViewAdminController {

    public function index(Request $r, $type){

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

        if( isset($this->object->{$type}['heading_callback']) ){

            $function = $this->object->{$type}['heading_callback'];

            add_action('vn4_heading',function($type) use ($function) {
                $function($type);
            });
        }


        if($r->isMethod('get')){

            $data_view = array_merge($data_view,$this->get_data_view( $r, $type ));

            return vn4_view(backend_theme('post-type.create_and_show_data'),$data_view);
        }



        if($r->isMethod('POST')){

            if( $r->has('getJsonData') ){
                 return parent::getDataTable($r,$type);
            }

           return $this->post_add_or_update_post_admin( $r, $type );

        }
    }
}




