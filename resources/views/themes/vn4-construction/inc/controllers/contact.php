<?php

return [
	'post'=>function($r){

		if( $r->isMethod('POST') ){

			$result = Vn4Model::create('contact', [] , $r->all() );

			if( !$result['error'] ){
				// Send Email
			}
			
			return response()->json($result);

		}

		return redirect()->back();
	}
];