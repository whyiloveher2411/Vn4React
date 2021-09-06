<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if( is_callable('vn4_log') ){
            vn4_log( $exception->getMessage(), null , $exception->__toString() , 'error');
        }else{
            parent::report($exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {   

        if( $exception instanceof  \Illuminate\Session\TokenMismatchException ){

            if( is_admin() ){
                vn4_create_session_message( __('Error'), __('The page has expired due to inactivity. <br> Please refresh and try again.'), 'error' , true );
            }
            
            return redirect()->back();
        }

        // if( Auth::check() ){
            return parent::render($request, $exception);
        // }
        
        if( $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ){
            return errorPage(404,'Page Not Found.','NotFoundHttpException', $exception);
        }

        return errorPage(500,'Server Error.','Exception', $exception);
       
    }
}
