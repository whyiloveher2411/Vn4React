<?php

if( env('EXPERIENCE_MODE') ){
	return experience_mode();
}

if( $r->has('view_visual') ){

  	$emails = [];

	if( file_exists( $file = cms_path('resource','views/themes/'.theme_name().'/emails/emails.php')) ){
    	$emails = include $file;
  	}

  	if( !is_array($emails) ){
	    $emails = [];
  	}
  
	$parameters = $emails[$r->get('view_visual')]['parameters'];

	$parametersTest = $r->get('parameters');

	$content = '<?php ';
	foreach ($parameters as $key => $value) {
		if( isset($parametersTest[$key]) ){
			$content .= "\$$key = '$parametersTest[$key]';";
		}else{
			$content .= "\$$key = '$value[default]';";
		}
	}

	$content .= ' ?>';

	$content .= $r->get('content');

	file_put_contents(cms_path('resource','views/default/emails/temp.blade.php'), $content);

	$content = @file_get_contents( route('preview-email') ) ?: @file_get_contents( str_replace('https', 'http', route('preview-email')) );

	return response()->json(['content'=>$content]);

}


if( $r->has('update_template') ){

	$emails = include cms_path('resource','views/themes/'.theme_name().'/emails/emails.php');

	$template = $emails[$r->get('update_template')]['template'];

	$content = $r->get('content');

	file_put_contents( cms_path('resource','views/themes/'.theme_name().'/emails/'.$template.'.blade.php') , $content);

	return response()->json(['message'=>['content'=>'Update Email Template Success.','title'=>'Success','icon'=>'fa-check-circle','color'=>'#29B87E']]);

}

if( $r->has('test_email') ){

	$emails = include cms_path('resource','views/themes/'.theme_name().'/emails/emails.php');

	$parameters = $emails[$r->get('select-template')]['parameters'];

	$title_default = '[Test] '.$emails[$r->get('select-template')]['title'];

	$parametersTest = $r->get('parameters');

	$content = '<?php ';

	foreach ($parameters as $key => $value) {
		if( isset($parametersTest[$key]) ){
			$content .= "\$$key = '$parametersTest[$key]';";
		}else{
			$content .= "\$$key = '$value[default]';";
		}
	}

	$toEmail = $r->get('to');

	$content .= ' ?>';

	$content .= $r->get('content');

	file_put_contents(cms_path('resource','views/default/emails/temp.blade.php'), $content);

	$content = file_get_contents(route('preview-email'));

	Mail::send('default.emails.dynamic', ['content' => $content], function($message) use ($toEmail, $r, $title_default) {

        $message->from( env('MAIL_USERNAME'), 'Vn4CMS');

        $message->subject($r->get('subject')??$title_default);

        foreach ($toEmail as $key => $value) {
        	if( $value['type'] === 'to' ){
        		$message->to($value['email'], $value['name']);
        	}elseif( $value['type'] === 'cc' ){
        		$message->cc($value['email'], $value['name']);
        	}elseif( $value['type'] === 'bcc' ){
        		$message->bcc($value['email'], $value['name']);
        	}
        }
    });

	return response()->json([
		'content'=>$content,
		'message'=>['content'=>'Send Email Success!.','title'=>'Success','icon'=>'fa-check-circle','color'=>'#29B87E']
	]);
}

if( $r->has('save_email_test_address') ){
	setting_save('email_test_address',$r->get('to'));
	return response()->json([
		'message'=>['content'=>'Save Email Success.','title'=>'Success','icon'=>'fa-check-circle','color'=>'#29B87E']
	]);

}