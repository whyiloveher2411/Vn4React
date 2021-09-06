<?php

return [
	'index'=>function($r,$plugin){
		
		if( $r->isMethod('GET') ){
			return view_plugin($plugin, 'views.translate');
		}

		if( env('EXPERIENCE_MODE') ){
		    return experience_mode();
		}
		
		if( $r->isMethod('POST') ){

			$tool = include(__DIR__.'/tool.php');

			$key = $r->get('key');

			$translates = $r->get('translates');
			$languages = languages();

			$data = [];

			foreach ($languages as $k => $lang) {
				if( isset($translates[$k]) ){
					$data[$k][$key] = $translates[$k];
				}else{
					$data[$k][$key] = '';
				}
			}

			$result = $tool['refesh-translate']($r, $plugin, 'translate', $data);

			return response()->json(['success'=>true]);
		}

	}
];