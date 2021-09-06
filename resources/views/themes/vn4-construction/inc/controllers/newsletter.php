<?php

return [
	'post'=>function($r){

		if( $r->isMethod('POST') ){

			$result = Vn4Model::create('newsletters', ['title'=>$r->get('email')] , [] );

			if( !$result['error'] ){
				// Send Email
			}
			
			return response()->json($result);

		}

		return redirect()->back();
	}
];