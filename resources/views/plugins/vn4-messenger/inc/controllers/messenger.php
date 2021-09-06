<?php

return [
	'index'=>function($r, $plugin){
		return view_plugin($plugin, 'views.messenger.index');
	}
];