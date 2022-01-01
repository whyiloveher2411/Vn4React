<?php

if( !function_exists('register_post_type') ){

    function register_post_type($callback ){

        add_filter('register_post_type',function($post_type) use ($callback) {

            $add_post_type = $callback($post_type);
                
            if( is_array($add_post_type) ){
                $post_type = array_merge( $post_type, $add_post_type );
            }

            return $post_type;

        });

    }
}

$plugins = plugins();

foreach ($plugins as $plugin) {
  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/post-type.php')) ){
    include $file;
  }
}

$theme_name = theme_name();

if( file_exists( $file = cms_path('resource','views/themes/'.$theme_name.'/inc/post-type.php')) ){
    include $file;
}
