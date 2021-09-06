<?php

$input = json_decode($r->getContent(),true);


$file_congig = __DIR__ . '/../client_secret_app.json';
			
require_once cms_path('public','../lib/google-client/vendor/autoload.php');

if( isset($input['action']) && $input['action'] === 'getDataScreen' ){
	return include 'settings-screen-data.php';
}

switch ($input['step']) {
	case 'getSetting':
		return [
			'success'=>true,
			'value'=>$plugin->getMeta()
		];

		break;
	case 'setEmbedCode':

		

		break;
	case 'settingAccount':
			

			
		break;

	case 'settingAuthorizationToken':

		


	case 'settingWebproperties':

		

		break;
	default:
		# code...
		break;
}
