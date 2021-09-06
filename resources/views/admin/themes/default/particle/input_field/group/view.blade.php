<?php

if( is_string($value) ){
    $value =  json_decode($value,true);
}

if( is_array($value) ){


    foreach ($field['sub_fields'] as $k => $v) {

        if( !isset($v['view']) ) $v['view'] = 'input';
        
        if( !is_callable($v['view']) ){

            if( isset($value[$k]) ){
                if( view()->exists( $view = backend_theme('particle.input_field.'.$v['view'].'.view') ) ){
                    $content = vn4_view($view,['post'=>null,'key'=>$k, 'field'=>$v,'value'=>$value[$k]]);
                }else{
                    $content = e($value[$k]);
                }

            }else{
                $content = ''; 
            }

        }else{

            $view = call_user_func($v['view']);

            if( isset($view['view']) ){
                $content = call_user_func_array($view['view'], ['post'=>null,'key'=>$key, 'field'=>$v,'value'=>$value[$k]]);
            }else{
                $content = e($value[$k]);
            }

        }

        echo '<strong>'.$v['title'].':</strong>';
        echo $content.'<br>';
    }

}


