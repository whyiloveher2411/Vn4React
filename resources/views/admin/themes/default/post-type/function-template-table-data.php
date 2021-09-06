<?php

if( !function_exists('register_post_type') ){
    function register_post_type($callback ){

        add_filter('register_post_type',function($post_type) use ($callback) {

            $add_post_type = $callback($post_type);
                
            if( isset($add_post_type[0]) ){

                if( is_array($add_post_type[0]) ){

                    foreach ($add_post_type as $p) {

                        list($id,$stt,$arg) = $p;

                        if(!isset($post_type[$id])){

                            if ( is_int($stt) ){

                                $post_type1 = array_slice($post_type, 0 , $stt - 1);
                                $post_type2 = array_slice($post_type,$stt - 1);

                                $post_type1[$id] = $arg;

                                $post_type = array_merge($post_type1, $post_type2);

                            }else{
                                $post_type[$id] = $arg;
                            }

                        }
                    }
                }else{

                    list($id,$stt,$arg) = $add_post_type;

                    if(!isset($post_type[$id])){

                        if ( is_int($stt) ){

                            $post_type1 = array_slice($post_type, 0 , $stt - 1);
                            $post_type2 = array_slice($post_type,$stt - 1);

                            $post_type1[$id] = $arg;

                            $post_type = array_merge($post_type1, $post_type2);

                        }else{
                            $post_type[$id] = $arg;
                        }

                    }

                }
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
