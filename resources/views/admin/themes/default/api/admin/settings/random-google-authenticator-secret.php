<?php

$action = $r->get('action');

require cms_path('public','../lib/google-authenticator/Authenticator.php');

$Authenticator = new Authenticator();

if( $action === 'RANDOM_SECRET' ){
    $secret = $Authenticator->generateRandomSecret();
}else{
    $secret = $r->get('secret');
}

$qrCodeUrl = $Authenticator->getQR( parse_url(config('app.url'))['host'].' - Setting - '.setting('general_site_title'), $secret);

return  response()->json(['qrCodeUrl'=>$qrCodeUrl,'secret'=>$secret]);

