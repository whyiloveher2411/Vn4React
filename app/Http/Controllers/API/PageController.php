<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller {

	public function __construct(){
		$this->response = response();
	}

	public function index(Request $request, $page){
		$request = request();

		// if($request->isMethod('GET')){

			$theme = theme_name();

			if( file_exists( $getFile = 'resources/views/themes/'.$theme.'/api/page/'.$page.'.php') ){

				return include($getFile);

		        // $custom = include('resources/views/themes/'.$theme.'/backend/'.$page.'/get.php');
	      	}

			return [
				'error' => [
					'code'=>404,
					'message' => 'Not Found',
				]
			];

		// }

	}

}