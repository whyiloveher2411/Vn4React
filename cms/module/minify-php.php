<?php

function minify_remove_comment_html($content){
	$pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
	$arg1 = array(
			'/ {2,}/',
			'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
			);
	$arg2 = array(
			' ',
			''
			);

	$content = preg_replace($pattern, '', $content);
		
	$content = preg_replace($arg1, $arg2 , $content );

	$content = str_replace('<?php', '<?php ' , $content );
	$content = str_replace('<?php  ', '<?php ' , $content );

	return $content;
}

function minify_remove_whitespace($content){

	if($content !== ' '){
		return '';
	}

	return ' ';

	if( trim($content) ){
		return str_replace(['\r', '\n', '\t'], '', $content);
	}
	return $content;
}

function minify_php_and_save($path_file){

	$commentTokens = array(T_COMMENT);

	$htmlTokens = array(T_INLINE_HTML,T_CLOSE_TAG);

	if (defined('T_DOC_COMMENT'))
	    $commentTokens[] = T_DOC_COMMENT; // PHP 5
	if (defined('T_ML_COMMENT'))
	    $commentTokens[] = T_ML_COMMENT;  // PHP 4

	$content = File::get($path_file);

	$fileStr = $content;

	$newStr  = '';

	$tokens = token_get_all($fileStr);

// if( strpos($path_file, '00d0319ebe78f65669982806e026fad6dacbd1d4.php') ){
// 		dd($tokens);
// 	}
	// dd($tokens);
	foreach ($tokens as $token) {    
	    if (is_array($token)) {
	        if (in_array($token[0], $commentTokens))
	            continue;


	        if( in_array($token[0], $htmlTokens) ){
		    	$token[1] = minify_remove_comment_html($token[1]);
		    }

		    if( $token[0] === T_WHITESPACE ){
		    	$token[1] = minify_remove_whitespace($token[1]);
		    }

		    $token = $token[1];

	    }

	    $newStr .= $token;
	}
	// dd($newStr);
	// $content = $newStr;
	
	return File::put($path_file, $newStr);

}
