<?php

$value =  json_decode($value,true);

if( is_array($value) && !empty($value) ){

    $count = count(reset($value));

    foreach ($value as $index => $item) {
        
        foreach ($field['sub_fields'] as $k => $v) {

            if ( !isset($v['view']) )  $v['view'] = 'text';
            
            if( !is_callable($v['view']) ){

                if( isset($item[$k]) ){
                    if( view()->exists( $view = backend_theme('particle.input_field.'.$v['view'].'.view') ) ){
                        $content = vn4_view($view,['post'=>null,'key'=>$k, 'field'=>$v,'value'=>$item[$k]]);
                    }else{
                        $content = e($item[$k]);
                    }

                }else{
                    $content = ''; 
                }

            }else{

                $view = call_user_func($v['view']);

                if( isset($view['view']) ){
                    $content = call_user_func_array($view['view'], ['post'=>null,'key'=>$key, 'field'=>$v,'value'=>$item[$k]]);
                }else{
                    $content = e($item[$k]);
                }

            }

            echo '<strong>'.$v['title'].': </strong> ';
            echo $content.'<br>';
        }

        echo '<hr>';

    }
}


