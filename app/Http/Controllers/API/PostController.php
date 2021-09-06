<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vn4Model;

class PostController extends Controller {

	public function __construct(){
		$this->response = response();
	}

	public function index($post_type){
		// return ['data'=>$_SERVER];
		// return ['data'=>get_posts($post_type)];

	}

}