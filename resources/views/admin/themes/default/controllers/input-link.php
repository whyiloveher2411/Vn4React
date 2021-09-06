<?php

return [
	'get-link'=>function($r){
		if( $r->isMethod('GET') ){
			return vn4_view(backend_theme('particle.input_field.link.iframe'));
		}

		dd($r->all());
	}
];