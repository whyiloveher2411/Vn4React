<?php
do_action('blade');

Blade::directive('__', function ($expression) {
    return "<?php echo __($expression); ?>";
});

Blade::directive('__t', function ($expression) {
    return "<?php echo __t($expression); ?>";
});

Blade::directive('__p', function ($expression) {
    return "<?php echo __p($expression); ?>";
});


Blade::directive('id', function ($expression) {
    return Vn4Model::$id;
});

Blade::directive('forif', function ($expression) {
    preg_match('/\( *(.*) +as *(.*)\)$/is', '('.$expression.')', $matches);
    $iteratee = trim($matches[1]);
    $iteration = trim($matches[2]);
    return "<?php if( isset({$iteratee}) && is_array({$iteratee})) foreach({$iteratee} as {$iteration}): if(!{$iteration}['delete']): ?>";
});

Blade::directive('endforif', function ($expression) {
    return "<?php endif; endforeach; ?>";
});

Blade::directive('forisset', function ($expression) {
    preg_match('/\( *(.*) +as *(.*)\)$/is', '('.$expression.')', $matches);
    $iteratee = trim($matches[1]);
    $iteration = trim($matches[2]);
    return "<?php if( isset({$iteratee}) && is_array({$iteratee})) foreach({$iteratee} as {$iteration}): ?>";
});

Blade::directive('endforisset', function ($expression) {
    return "<?php endforeach; ?>";
});



Blade::directive('forswitch', function ($expression) {
    preg_match('/\( *(.*) +as *(.*)\)$/is', '('.$expression.')', $matches);
    $iteratee = trim($matches[1]);
    $iteration = trim($matches[2]);

    $variable = explode('=>', $iteration);
    
    if( isset($variable[1]) ){
        $variable = trim($variable[1]);
    }else{
        $variable = trim($iteration);
    }

   return "<?php if(is_array({$iteratee})) foreach({$iteratee} as {$iteration}): if(!{$variable}['delete']): switch({$variable}['type']):";
});

Blade::directive('is', function ($expression) {
   return " case ({$expression}): ?>";
});

Blade::directive('endis', function ($expression) {
   return "<?php break;";
});


Blade::directive('endforswitch', function ($expression) {
    return " endswitch; endif; endforeach; ?>";
});


Blade::directive('dd', function ($expression) {
    return "<?php dd($expression); ?>";
});


if( !function_exists('get_url_compile') ){
    function get_url_compile($string){
        $url = parse_url( $string );

        if( isset($url['query']) ){
            return $url['path'].'?'.$url['query'];
        }

        return $url['path'];
    }
}

Blade::directive('theme_asset', function ($expression) {
    return get_url_compile( str_replace('public/filemanager/filemanager/dialog.php/', '', theme_asset(trim($expression,"\"'"))));
});

Blade::directive('link',function($expression){


    if( $expression[0] === '\'' || $expression[0] === '"' ){

        $param = explode(',', $expression);

        if( !isset($param[1]) ){

            return get_url_compile( route( trim($expression,"\"'") ) );
            
        }

        $param[1] = trim($param[1]);

        if( $param[1][0]  == '\'' || $param[1][0] == '"' ){

            return get_url_compile( route( trim($param[0],"\"'"), trim($param[1],"\"'") ) );
        } 


        $param = explode(',[', trim($expression,']') );

        $temp = $param[1];

        $temp = explode(',', $temp);

        $parameter = [];

        foreach ($temp as $key => $value) {
            $value = explode('=>', $value);
            $parameter[trim($value[0],"\"'")] = trim($value[1],"\"'");
        }


        return get_url_compile( route( trim($param[0],"\"'"), $parameter ) );

    }


    if( $expression[0] === '$' ){
        return "<?php echo get_permalinks($expression); ?>";
    }


    // dd($expression[0]);
    // dd($expression);
});

Blade::directive('asset', function ($expression) {
    return get_url_compile(asset(trim($expression,'\'')));
});

Blade::directive('footer', function ($expression) {
    return "<?php the_footer($expression); ?>";
});

Blade::directive('header', function ($expression) {
    return "<?php the_header($expression); ?>";
});

Blade::directive('head', function ($expression) {
    return "<?php vn4_head($expression); ?>";
});