<?php

$r = request();

if( $r->isMethod('POST') ){

    $theme_name = str_slug($r->get('name',false));

    if( !$theme_name ){
        return ['message'=>apiMessage('Please enter theme name','error')];
    }

    $description = $r->get('description','');
    $author = $r->get('author','');
    $author_url = $r->get('author_url','');
    $tags = $r->get('tags','');

    if( !File::exists( cms_path('resource').'views/themes/'.str_slug($theme_name)) ) {

        $success = File::copyDirectory( cms_path('resource').'views/default/theme-struct', cms_path('resource').'views/themes/'.$theme_name);

        $content_json = [
            'name' => $r->get('name',false),
            'description' => $description,
            'author' => $author,
            'author_url' => $author_url,
            'version' => '1.0.0',
            'tags'=>$tags
        ];

        file_put_contents(  cms_path('resource').'views/themes/'.$theme_name.'/info.json', json_encode($content_json, JSON_PRETTY_PRINT) );

        if (!file_exists( $public_folder_theme = cms_path().'themes/'.$theme_name )) {
            mkdir( $public_folder_theme, 0777, true);
        }

        $img = $r->get('screenshot');

        if( $img && isset($img['link']) ){

            if( $img['type_link'] === 'local' ){
                $img = urldecode(cms_path().$img['link']);
            }else{
                $img = urldecode($img['link']);
            }

        }

        if( $img ){
            copy($img, cms_path('resource').'views/themes/'.$theme_name.'/public/screenshot.png');
            copy($img, cms_path().'themes/'.$theme_name.'/screenshot.png');
        }

        include __DIR__.'/_function.php';

        return ['message'=>apiMessage('Create successful theme'),'success'=>1,'rows'=>getThemes()];

    }else{
        return ['message'=>apiMessage('Theme already exists, please choose another theme name','error')];
    }

}