<?php

namespace CMS\Commands\SetupCompile;

class Hook extends Compile{

    protected $messageSuccess = 'Compile hook successful!';
    protected $messageError = 'Compile hook error!';

    public function handle(){

        $plugins = plugins();

        $result = [];

        try {
            
            $dirPaths = [];

            foreach( $plugins as $keyWord => $plugin ){
                
                
                if( file_exists( $dir = cms_path('root','resources/views/plugins/'.$keyWord.'/inc/hook') ) ){

                    $hooks = scandir($dir);

                    foreach( $hooks as $hook ){

                        $info = pathinfo($hook);

                        if( $info['extension'] === 'php' ){
                            
                            if( !isset($result[ $info['filename']]) ){
                                $result[ $info['filename']] = [];
                            }

                            $result[ $info['filename']][] = 'resources/views/plugins/'.$keyWord.'/inc/hook/'.$hook;

                        }
                    }
                }
            }

            $theme_name = theme_name();

            if( file_exists( $dir = cms_path('root','resources/views/themes/'.$theme_name.'/inc/hook') ) ){

                $hooks = scandir($dir);

                foreach( $hooks as $hook ){

                    $info = pathinfo($hook);

                    if( $info['extension'] === 'php' ){
                        
                        if( !isset($result[ $info['filename']]) ){
                            $result[ $info['filename']] = [];
                        }

                        $result[ $info['filename']][] = 'resources/views/themes/'.$theme_name.'/inc/hook/'.$hook;

                    }
                }
            }

            file_put_contents(cms_path('root','cms/core/hook_maps.php'), '<?php return ' . var_export($result, true) . ';');

            return true;
       
        } catch (\Throwable $th) {

            return false;
            
        }
    }
}