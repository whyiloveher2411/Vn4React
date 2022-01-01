<?php


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

return [
    [
        'fields'=>[
            'reading_homepage'=>[
                'title'=>__('Homepage'),
                'view'=>'custom',
                'component'=>'components/ReadingSetting',
                'readingPageStatic'=>$reading_page_static,
                'adminObject'=>$admin_object,
            ],
        ]
    ],
];