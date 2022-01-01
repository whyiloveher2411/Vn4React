<?php

$router->group(['middleware'=>'front-end'],function()  use ($router){
    
    do_action('frontend');

    $router->get('/',['as'=>'index','uses'=>'PageController@index']);

    $router->any('get-post/{controller}/{method}',['as'=>'post','uses'=>'PageController@anyControllerFrontend']);

    $router->get('{page}',['as'=>'page', 'uses'=>'PageController@getPage']);

    $router->any('/{custom_post_slug}/{slug_post}',['as'=>'post.detail','uses'=>'PageController@postDetail']);

    $router->any('/{any_error}',['as'=>'error', 'uses'=>'PageController@getPage404'])->where(['any_error'=>'[\s\S]*']);
    
});
