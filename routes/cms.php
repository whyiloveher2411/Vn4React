<?php

$router->group(['prefix'=>setting('security_prefix_link_admin','admin'),'middleware'=>'auth', 'namespace'=>'Admin'],function() use ($router) {

    do_action('backend');

    $router->any('/',['as'=>'admin','uses'=>function(){
        return redirect()->route('admin.index');
    }]);

    $router->any('dashboard',['as'=>'admin.index','uses'=>'PageController@getViewIndex']);

    $router->any('logout',['as'=>'logout','uses'=>'LoginController@logout']);

    $router->post('/get-data-table',['as'=>'admin.get_data_table','uses'=>'ShowDataController@getDataTable']);

    $router->any('/create_data/{type}',['as'=>'admin.create_data','uses'=>'CreateDataController@index']);

    $router->any('/create_and_show_data/{type}',['as'=>'admin.create_and_show_data','uses'=>'CreateAndShowDataController@index']);

    $router->any('/show_data/{type}',['as'=>'admin.show_data','uses'=>'ShowDataController@index']);

    $router->any('/get_json_data/{type}',['as'=>'admin.get_json_data','uses'=>'ViewAdminController@getJsonData']);

    $router->any('/get_url',['as'=>'admin.get_url','uses'=>'PageController@get_url']);

    $router->any('/setting',['as'=>'admin.setting','uses'=>'SettingController@setting']);

    $router->any('/controller/{controller}/{method}',['as'=>'admin.controller','uses'=>'PageController@controller']);

    $router->any('/page/{page}',['as'=>'admin.page', 'uses'=>'PageController@getPage']);

    $router->any('/theme/{page}',['as'=>'admin.theme', 'uses'=>'PageController@getPageTheme']);

    $router->any('plugin/{plugin}/{controller}/{method}',['as'=>'admin.plugin.controller','uses'=>'PageController@pluginController']);

});

$router->any(setting('security_link_login','login'),['as'=>'login','middleware' => 'guest','uses'=>'Admin\LoginController@index']);

$router->any('preview-email',['as'=>'preview-email','uses'=>'PageController@previewEmail']);

$router->group(['middleware'=>'front-end'],function()  use ($router){
    
    do_action('frontend');

    $router->get('/',['as'=>'index','uses'=>'PageController@index']);

    $router->any('get-post/{controller}/{method}',['as'=>'post','uses'=>'PageController@anyControllerFrontend']);

    $router->get('{page}',['as'=>'page', 'uses'=>'PageController@getPage']);

    $router->any('/{custom_post_slug}/{slug_post}',['as'=>'post.detail','uses'=>'PageController@postDetail']);

    $router->any('/{any_error}',['as'=>'error', 'uses'=>'PageController@getPage404'])->where(['any_error'=>'[\s\S]*']);
    
});
