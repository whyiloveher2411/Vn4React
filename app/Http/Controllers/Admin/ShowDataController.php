<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
class ShowDataController extends ViewAdminController {

    public function index(Request $r, $type){
        // dd(1);
        if( !$this->object ){
            $this->object =  (object) get_admin_object();
            View::share ( 'admin_object', $this->object);
        }

        use_module(['post']);

        if(  $postId = $r->get('post') ){
            $post = get_post($type, $postId);
        }else{
            $post = null;
        }

        $checkPermission = parent::checkPermission($r,$type, $post);

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

            $noSeeDetail = $r->get('noSeeDetail',false);

            $action_post = $r->get('action_post','default');

            if($post && $action_post == 'detail' && check_permission($type.'_detail') && $noSeeDetail === false){
                return redirect()->route('admin.create_data',['type'=>$type,'post'=>$post,'action_post'=>$action_post]);
            }

            if($post && ($action_post == 'edit' || $action_post == 'copy') && check_permission($type.'_edit') && $noSeeDetail === false){
                return redirect()->route('admin.create_data',['type'=>$type,'post'=>$post,'action_post'=>$action_post]);
            }


            if( $r->get('noSeeDetail') === false ){
                return redirect()->route('admin.create_data',['type'=>$type,'edit_id'=>$r->get('edit_id')]);
            }

            $data_view['tag'] = $this->object->{$type};

            $data_view['fields'] = $this->object->{$type}['fields'];

            $data_view['type'] = $type;

            return vn4_view(backend_theme('post-type.show_data'),$data_view);
        }

        if( $r->isMethod('POST') ){

            if( $r->has('live_edit') ){
                return parent::post_live_edit($r);
            }

            if( $r->has('change_fields_show') ){
                return parent::change_fields_show_template_table($r);
            }

            if( $r->has('change_fields_groupby') ){
                return parent::change_fields_groupby_template_table($r);
            }
            

            if( $r->has('getJsonData') ){
                return parent::getDataTable($r,$type);
            }
        }
    }

}
