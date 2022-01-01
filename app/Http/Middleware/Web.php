<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use App;
use Route;

class Web {

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
		// dd(request()->segments());
		$GLOBALS['route_name'] = Route::currentRouteName();
		$GLOBALS['route_current'] = Route::current();
		$GLOBALS['url_current'] = url()->current();
		
       	$request = do_action('middleware_web',$request, $next);
		
		// return $next($request);
		$response = $next($request);

		if( !is_admin() && !Auth::check() ){
			//Enable cache
			$response->headers->set('Cache-Control', 'max-age=2628000, public');
				// ->header('X-Frame-Options', 'SAMEORIGIN')
				$response->headers->set('X-XSS-Protection', '1; mode=block');
				$response->headers->set('X-Permitted-Cross-Domain-Policies', 'master-only');
				$response->headers->set('X-Content-Type-Options', 'nosniff');
				$response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
				$response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
				//->header("Content-Security-Policy", "default-src 'self' www.googleadservices.com ssl.google-analytics.com www.google-analytics.com googleads.g.doubleclick.net sealserver.trustwave.com; style-src 'self' fonts.googleapis.com; object-src 'none';");
		}else{

			//Clear cache
			$response->headers->set('Expires', '0');
				// ->header('X-Frame-Options', 'SAMEORIGIN')
			$response->headers->set('Last-Modified', gmdate("D, d M Y H:i:s") . " GMT");
			$response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');
			$response->headers->set('Cache-Control', 'post-check=0, pre-check=0');
			$response->headers->set('Pragma', 'no-cache');

		}

	    return $response;

	    
	}

}



