<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Session;
use URL;
use Hash;
use Vn4Model;

class LoginController extends Controller {

    public function index(Request $r){

        // dd($r->ip());

        include cms_path('public','../cms/backend.php'); 
        

        $ipAccess = setting('security_accept_ip_login');

        if( !is_string($ipAccess) ) $ipAccess = '';

        preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $ipAccess, $ip_matches);

        if( count($ip_matches[0]) ){
            $ip_matches = array_flip($ip_matches[0]);

            $ip_matches['127.0.0.1'] = true;

            $ip = $r->ip();

            if( !isset($ip_matches[$ip]) ){
                return redirect()->route('index');
            }
        }

        if($r->isMethod('GET')){
            return vn4_view(backend_theme('particle.login'));
        }

        if($r->isMethod('POST')){

            $time_login = Vn4Model::firstOrAddnew(vn4_tbpf().'login_time',['ip'=>$r->ip()]);

            $limit_login_count =  setting('security_limit_login_count',false);
            $limit_login_time =  setting('security_limit_login_time',false);
            $active_signin_with_google_account =  setting('security_active_signin_with_google_account',false);

            if( $limit_login_count && $time_login->count >= $limit_login_count  ){

                if( time() < $time_login->time ){
                    return response()->json(['message'=>'You have logged in more than '.$limit_login_count.' times, Please wait '. $limit_login_time.' seconds later']);
                }else{
                    $time_login->count = 0;
                }
            }

            $rememberme = $r->get('rememberme',false);

            if( $active_signin_with_google_account === '["active"]' && $r->get('login_by_google_rq') ){

                try {
                    $content = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$r->get('access_token')),true);

                    $email = $content['email'];

                    $user = get_posts('user',['count'=>1,'callback'=>function($q) use ($email) {
                        $q->where('email',$email)->where('status','publish');
                    }]);

                    if( isset($user[0]) ){
                        Auth::loginUsingId($user[0]->id, $rememberme);
                        return response()->json(['url'=>route('admin.index')]);
                    }else{
                        return response()->json(['message'=>'Sign-in error: the account is not mapped with the existing account in the system.']);
                    }

                } catch (Exception $e) {
                    return response()->json(['message'=>'Error sign in with google.']);
                }

            }



            $input = $r->all();

            if( setting('security_active_recaptcha_google') === '["active"]' && setting('security_recaptcha_sitekey') && setting('security_recaptcha_secret') ){

                $url = 'https://www.google.com/recaptcha/api/siteverify';

                $data = array(
                    'secret' => setting('security_recaptcha_secret'),
                    'response' => $r->get('g-recaptcha-response')
                );
                $options = array(
                    'http' => array (
                        'header'=>'Content-Type: application/x-www-form-urlencoded\r\n'."Content-Length: ".strlen(http_build_query($data))."\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);

                $verify = file_get_contents($url, false, $context);
                $captcha_success=json_decode($verify);

                if ($captcha_success->success === false) {
                    $time_login->count += 1;
                    $time_login->time =  time() + $limit_login_time;

                    $time_login->save();

                     return response()->json(['message'=>'Captcha website validation failed.']);
                }

            }

            if( $user = User::where('email',trim($input['username']))->where('status','publish')->first() ){
                

                if (Hash::check( $input['password'] , $user->password)) {
                    
                    if( setting('security_active_google_authenticator') === '["active"]' && $secret_google_authenticator = $user->getMeta('security_google_authenticator_secret',setting('security_google_authenticator_secret')) ){
                        
                        if( $r->get('google_authenticator') ){

                            require cms_path('public','../lib/google-authenticator/Authenticator.php');

                            $Authenticator = new \Authenticator();

                            $checkResult = $Authenticator->verifyCode($secret_google_authenticator, $r->get('google_authenticator'), 2);

                            if( !$checkResult ){
                                return response()->json(['message'=>'Authentication code incorrect.']);
                            }

                        }else{
                            return response()->json(['active_google_authenticator'=>true]);
                        }

                    }

                }

                if ( Auth::attempt(['email' => $input['username'], 'password' => $input['password']], $rememberme) ){

                    vn4_log('Login',null,null,'info','user/'.Auth::id().'/vn4-'.date('Y-m-d').'.log');

                    $time_login->count = 0;
                    $time_login->time =  0;
                    $time_login->save();

                    $unique_login_time = time().microtime();

                    Auth::user()->updateMeta('unique_login_time',$unique_login_time);


                    if( $r->has('rel') ){
                        return response()->json(['url'=>$r->get('rel')])->withCookie(cookie('unique_login_time', $unique_login_time));
                    }
                    return response()->json(['url'=>route('admin.index')])->withCookie(cookie('unique_login_time', $unique_login_time));
                    
                }

            }

            $time_login->count += 1;
            $time_login->time =  time() + $limit_login_time;
            $time_login->save();

            if( $limit_login_count && $time_login->count > $limit_login_count - 1  ){
                return response()->json(['message'=>'You are logged in too '.$limit_login_count.' times, Please wait '.$limit_login_time.' seconds later','url'=>route('login')]);
            }

            return response()->json(['message'=>'Username or Password is incorrect.','time_login'=>$time_login->count]);
        }
    }
 
}
