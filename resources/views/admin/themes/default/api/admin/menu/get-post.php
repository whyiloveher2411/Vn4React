<?php

$r = request();

$input = json_decode($r->getContent(),true);

if( $input['type'] === 'getPostType' ){


	switch ($input['object_type']) {
		case '__page':

			if( file_exists(cms_path('resource','views/themes/'.theme_name().'/page')) ) {
				$files = File::allFiles(cms_path('resource','views/themes/'.theme_name().'/page'));
				$result = [];
				foreach ($files as $page) {
	
					if( strpos($page->getRelativePathname(), '.blade.php') ){
	
						$v = basename($page,'.blade.php');
					  
						$name = explode('/', $page->getFilename());
	
						$name = substr(end($name), 0, -10);
	
						$name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
	
						preg_match( '|Page Name:(.*)$|mi', file_get_contents( $page->getRealPath() ), $header );
	
						if( isset($header[1]) ){
						  $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
						}
	
						$result[] = ['id'=>substr($page->getRelativePathname(), 0, -10),'page-name'=>substr($page->getRelativePathname(), 0, -10), 'title'=>$name ];
					}
				}
	
			}else{
				$result = [];
			}

			return response()->json(['rows'=>$result]);
			# code...
			break;
		default:
			$result = get_posts($input['object_type'],1000);

			$result2 = do_action('appearance_menu_get_object_data',$result, $input['object_type']);
		
			if( $result2 ) $result = $result2;
		
			return response()->json(['rows'=>$result]);
			break;
	}
}
