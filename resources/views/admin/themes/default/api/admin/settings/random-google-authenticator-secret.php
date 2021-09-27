<?php

    require cms_path('public','../lib/google-authenticator/Authenticator.php');

    $Authenticator = new Authenticator();

    $secret = $Authenticator->generateRandomSecret();
    $qrCodeUrl = $Authenticator->getQR(parse_url(config('app.url'))['host'], $secret);

    return  response()->json(['qrCodeUrl'=>$qrCodeUrl,'secret'=>$secret]);
