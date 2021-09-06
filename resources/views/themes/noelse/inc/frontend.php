<?php


Route::view('/{path?}', 'app');

// Route::view('/{path?}', 'app');
/*

add_route('{theme_noelse}','theme_noelse','frontend', function($params){
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <title>ReactAxios</title>
        <!-- Styles -->
        <link href="<?php echo asset('css/app.css') ?>" rel="stylesheet">
    </head>
    <body>
        <div id="app"></div>

        <script src="<?php echo asset('js/app.js') ?>"></script>
    </body>
    </html>

<!--     
    <!DOCTYPE html>
        <html lang="en" dir="ltr">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" href="%PUBLIC_URL%/favicon.ico" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="theme-color" content="#000000" />
            <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
            <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
            <title>Vn4 CMS</title>
            <meta name="description" content="Vn4 CMS" />
            <meta name="keywords" content="react,material,vn4cms,application,dashboard,admin,template" />
            <meta name="author" content="Devias IO" />
        </head>
        <body>
            <noscript>You need to enable JavaScript to run this app.</noscript>
            <div id="root"></div>
        </body>
    </html> -->
    <?php
},[
    'theme_noelse'=>'[\s\S]*'
]);
