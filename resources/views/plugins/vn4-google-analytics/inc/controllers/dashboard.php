<?php

return [
	'realtime'=>function($r, $plugin){
		return view_plugin($plugin,'views.realtime',['plugin'=>$plugin]);
	}
];