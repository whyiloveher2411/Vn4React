<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Vn4Model;
use Auth;
use DB;
use View;

class PostController extends ViewAdminController {

    public function trash(Request $r){
        
        if($r->ajax()){

            $input = $r->only('post_type','id');

            if( !$this->object ){
                $this->object =  (object) get_admin_object();
                View::share ( 'admin_object', $this->object);
            }

            if( !$input['post_type'] || !$input['id'] ){
                return response()->json(['message'=>trans('post.trash_post_message_not_input')]);
            }

            if( !isset($this->object->{$input['post_type']}) ){
                return response()->json(['message'=>trans('post.trash_post_not_isset_post_type')]);
            }

            use_module(['post']);
            
            vn4_trash_post($input['post_type'], $input['id']);

            vn4_create_session_message(trans('post.trash_post_title_success'), trans('post.trash_post_content_success'),'success', true);

            return response()->json(['url_redirect'=>route('admin.show_data',['type'=>$input['post_type']])]);
        }

        return '';

    }

    public function registerSlug(Request $r){
        
        $slug = registerSlug($r->get('slug','slug'), $r->get('me_type','PostController_line_40'), $r->get('me_id',-1) );
        
        return response()->json(['slug'=>$slug]);

    }

    public function get_post(Request $r, $type){

        if( !$r->ajax() ){
            return redirect('/');
        }

        $data = do_action('get_post_controller',$r,$type);

        if( !$data ) $data = get_posts($type,10000);
        // if( $r->get('type_get',false) === 'relationship_mm' ){
        //     return response()->json(['data'=>get_posts_not_paginate($type,100, function($q){
        //         return $q->where('language',Auth::user()->getMeta( 'lang', 'en' ));
        //     })]);
        // }
        return response()->json(['data'=>$data]);

    }
}
