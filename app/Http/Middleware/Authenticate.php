<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
use Route;
use App;
use Cookie;
use Cache;
use Auth;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		do_action('backend_init',$request,$next);
		
		if ($this->auth->guest())
		{
			// Session::put('url_after_login','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			if ($request->ajax())
			{
				return  response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->route('login',['rel'=>$request->fullUrl()]);
			}
		}

		if( !$n = Cache::get('notify') ){

			if( ($number = Cache::get('number_notify')) && $number > 10 ){
				vn4_create_session_message('Warning','License information is incorrect, please reinstall <a href="'.route('admin.page',['page'=>'setting','vn4-tab-left-'=>'license']).'">here</a>','warning');			
			}else{
				if( !$number ) $number = 1; else $number++;
				Cache::put( 'number_notify', $number, 1440 );
			}
		}
		// dd(Cookie::get('unique_login_time') .' - '.$this->auth->user()->getMeta('unique_login_time') );

		if( setting('security_login_on_a_single_machine') === '["active"]' && Cookie::get('unique_login_time') !== $this->auth->user()->getMeta('unique_login_time') ){
			Auth::logout();
	        return redirect()->route('login');
		}

		$result = do_action('middleware_backend',$request, $next);

		if($result != null){

			return $result;

		}
		
		return $next($request);

		
	}

}
