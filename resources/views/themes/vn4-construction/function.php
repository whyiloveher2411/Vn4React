<?php

// header('Location: http://localhost/cms_ecommerce/en');
// die();

// if( !isset($_SERVER['HTTP_REFERER']) ){
// 	die('
// <!DOCTYPE html>
// <html lang="en">
// <head>
//   <meta charset="utf-8" />
// </head>
// <body>
//     <noscript>
//       <center>If you’re not redirected soon, please <a href="/">use this link</a>.</center>
//     </noscript>
//     <script>
//       location.replace(location.href.split("#")[0]);
//     </script>                                                                                                                           
// </body>
// </html>
// ');

// }

if( is_admin() ){

	include __DIR__.'/inc/backend.php';

}