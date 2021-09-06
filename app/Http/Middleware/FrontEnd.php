<?php namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Contracts\Auth\Guard;

class FrontEnd{

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

		do_action('frontend_init',$request, $next);

		$result = do_action('middleware_frontend',$request, $next);

		if($result != null){

			return $result;

		}

		return $next($request);
	}

}
