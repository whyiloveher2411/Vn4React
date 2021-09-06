<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Vn4Model;

use Hash;


class UserController extends ViewAdminController {

    // public function user(Request $r){

    //     if($r->isMethod('GET')){
    //         return view('admin.user.index');
    //     }

    //     if($r->has('check_email')){
    //         return response()->json(['result'=>$this->existsEmail($r->get('data'))]);
    //     }
    //     if($r->isMethod('POST')){
    //         $input = $r->all();

    //         $input = $this->unsetInput($input);

    //         $input['password'] = Hash::make($input['password']);

    //         $user = new User();

    //         $user->fillDynamic($input);

    //         $user->save();

    //         return redirect()->route('admin.user');
    //     }

    // }

    public function user_new(Request $r){

        if($r->isMethod('GET')){
            
            return vn4_view(backend_theme('user-new'));
        }

        if($r->isMethod('POST')){

            $input = $r->all();

            if($r->has('edit_user')){
                
                $user = Vn4Model::findCustomPost('user',$r->get('post',0));

                if( trim($input['password']) !== ''  && !isset(trim($input['password'])[5]) ){
                    vn4_create_session_message( trans('Fail'), 'Passwords must be greater than 5 characters.', 'fail' , true);

                    return redirect()->back();
                }

                if( trim($input['password']) !== '' ){
                    $user->password = Hash::make(trim($input['password']));
                }

            }else{
                $user = Vn4Model::firstOrAddnew(get_admin_object('user')['table'],['email'=>$r->get('email')]);

                if($user->exists){

                    vn4_create_session_message( trans('Fail'), trans('User email already exists, please select another email.'), 'fail' , true);

                    return redirect()->back();

                }

                if( !isset(trim($input['password'])[5]) ){
                    vn4_create_session_message( trans('Fail'), 'Passwords must be greater than 5 characters.', 'fail' , true);

                    return redirect()->back();
                }

                $user->password = Hash::make(trim($input['password']));
                $user->status = 'publish';
                $user->status_old = 'publish';
                $user->visibility = 'publish';

            }

            if( isset($input['role']) ){
                $user->role = $input['role'];
            }

            $user->slug = registerSlug ( $input [ 'slug' ], 'user', $user->id );

            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];
            $user->type = 'user';
            $user->setTable(get_admin_object('user')['table']);
            
            $user->permission = implode(', ', $r->get('permission',[]));

            $user->save();

            if($r->has('edit_user')){
                vn4_create_session_message( trans('Success'), 'Edit user to success.', 'success' , true);
            }else{
                vn4_create_session_message( trans('Success'), 'Create successful user.', 'success' , true);
            }

            return redirect()->back();


        }


    }

    private function existsEmail($email){
        
        if(User::where('email',$email)->count() > 0){
            return true;
        }

        return false;
    }
}
