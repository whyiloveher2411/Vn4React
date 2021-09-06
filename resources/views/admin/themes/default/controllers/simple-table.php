<?php

return [
	'get'=>function($r){
		if( !$r->has('iframe')) return redirect()->route('admin.index');

		$type = $r->get('type');

		return vn4_view(backend_theme('particle.post-type.template-table-data-simple'),['r'=>$r,'type'=>$type]);
	}
];