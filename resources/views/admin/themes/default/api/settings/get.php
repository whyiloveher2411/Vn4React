<?php



$r = request();

$input = json_decode($r->getContent(),true);

if( isset($input['renderDate']) ){
	return [
		'date'=>date($input['renderDate'])
	];
}


$reading_page_static = [];

$file_page =  file_exists(cms_path('resource').'views/themes/'.theme_name().'/page') ? File::allFiles(cms_path('resource').'views/themes/'.theme_name().'/page'):[];
foreach($file_page as $page){

      $v = basename($page,'.blade.php');

      $name = $v;

      $name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
      preg_match( '|Template Name:(.*)$|mi', file_get_contents( $page ), $header );

      if( isset($header[1]) ){
          $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
      }

      $reading_page_static[$v] = ['title'=>$name];

}

$admin_object = get_admin_object();

$admin_object = array_filter( $admin_object, function($item){
	return isset($item['public_view']) && $item['public_view'];
});

// $admin_object = [];

// foreach ($list_get_admin_object as $key => $value) {
// 	$admin_object[$key] = ['title'=>$value['title']];
// }


$result = [
	'date'=>[
		'F j, Y'=>date('F j, Y'),
		'Y-m-d'=>date('Y-m-d'),
		'm/d/Y'=>date('m/d/Y'),
		'd/m/Y'=>date('d/m/Y'),
	],
	'time'=>[
		'g:i a'=>date('g:i a'),
		'g:i A'=>date('g:i A'),
		'H:i'=>date('H:i'),
	],
	'admin_object'=>$admin_object,
	'reading_page_static'=>$reading_page_static,
	'row'=>setting()
];

if( isset($result['row']['security_google_authenticator_secret']) && $result['row']['security_google_authenticator_secret'] ){

	require cms_path('public','../lib/google-authenticator/Authenticator.php');

	$Authenticator = new Authenticator();

	$qrCodeUrl = $Authenticator->getQR( parse_url(config('app.url'))['host'].' - Setting - Biong CMS', $result['row']['security_google_authenticator_secret']);

	$result['row']['security_google_authenticator_secret_img'] = $qrCodeUrl;
}

return $result;