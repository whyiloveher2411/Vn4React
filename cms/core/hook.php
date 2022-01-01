<?php
/**
 Action
 */

/**
 * do action
 */

$actionMaps = file_exists( __DIR__.'/hook_maps.php' ) ? include __DIR__.'/hook_maps.php' : [];

function do_action($action_name)
{

    global $actionMaps;

    if( isset($actionMaps[$action_name]) ){
        foreach( $actionMaps[$action_name] as $hook){
            require_once( cms_path('root', $hook ) );
        }
    }
   
    $listParam = array_slice(func_get_args(), 1,10);

    $value = isset($listParam[0]) ? $listParam[0] : null;

    if( isset($GLOBALS['action_hook'][$action_name]) ){

        $action_hook = $GLOBALS['action_hook'][$action_name];

        ksort( $action_hook );
        
        // $callback = null;
        foreach( $action_hook as $hook){
            
            $value2 = call_user_func_array ($hook, array_merge($listParam, [$value]) );

            if( $value2 ){
                $value = $value2;
            }
        }
    }

    return $value;

}


function add_action($action_name, $func_name, $priority = 'a', $unique = false )
{   

    if(is_array($action_name)){

        $list_action_hook = $action_name;

        foreach ($list_action_hook as $action_name) {
            
            if( !isset($GLOBALS['action_hook'][$action_name]) ){
               $GLOBALS['action_hook'][$action_name] = array();
            }

            $name = $priority;

            if( $unique == false){

                while( isset($GLOBALS['action_hook'][$action_name][$name]) ){
                    $name = $name.$priority;
                }

                $GLOBALS['action_hook'][$action_name][$name] = $func_name;

            }else{

                $GLOBALS['action_hook'][$action_name][$name] = $func_name;

            }
            
        }

    }else{

        if( !isset($GLOBALS['action_hook'][$action_name]) ){
           $GLOBALS['action_hook'][$action_name] = array();
        }

        $name = $priority;

        if( $unique == false){

            while( isset($GLOBALS['action_hook'][$action_name][$name]) ){
                $name = $name.$priority;
            }

            $GLOBALS['action_hook'][$action_name][$name] = $func_name;

        }else{

            $GLOBALS['action_hook'][$action_name][$name] = $func_name;

        }

    }
    
}


/**
 Filter
 */

 $GLOBALS['filter'] = [];
/**
 * apply filter
 */
function apply_filter($filter_name, $content = null)
{  

    if( $content === null ) $content = [];

    if( isset($GLOBALS['filter'][$filter_name]) ){

        $filter_hook = $GLOBALS['filter'][$filter_name];

        ksort($filter_hook);

        $index = 1;

        foreach($filter_hook as $value){

           $content = call_user_func_array($value,[$content]) ;

        }
    }

    return $content;
    
}

/**
 * add filter
 */
function add_filter($filter_name, $func_name, $priority = 'a')
{

    if(!isset($GLOBALS['filter'][$filter_name])){
        $GLOBALS['filter'][$filter_name] = array();
    }

    $name = $priority;

    while(isset($GLOBALS['filter'][$filter_name][$name])){
        $name = $name.$priority;
    }

    $GLOBALS['filter'][$filter_name][$name] = $func_name;

}



function call_function( $func_name ){

    if( is_callable( $func_name ) ){

         return call_user_func_array ($func_name, array_slice(func_get_args(), 1,10) );

    }

}

