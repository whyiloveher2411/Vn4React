<?php

include '__function.php';

$input = $r->all();

$webmaster_tools = [];

if( isset($input['metaTag']) && $input['metaTag'] ){

    $google = _vn4seo_get_string_between($input['metaTag'],'content="','"')?_vn4seo_get_string_between($input['metaTag'],'content="','"'):$input['metaTag'];

    $webmaster_tools['google']['tag'] = $google;

}

if( isset($input['htmlFIle']) && $input['htmlFIle'] ){

    if( !is_array($input['htmlFIle']) ){
        $file = json_decode($input['htmlFIle'],true);
    }else{
        $file = $input['htmlFIle'];
    }

    if( isset($file['link']) ){
        $file_info = pathinfo(cms_path('public',$file['link']));
        copy(cms_path('public',$file['link']), cms_path('public',$file_info['basename']));
        $webmaster_tools['google']['file'] = $input['htmlFIle'];
    }else{

        $file_veri = $plugin->getMeta('webmaster-tools');

        if( isset($file_veri['google']['file']) ){

            $file = $file_veri['google']['file'];

            if( !is_array($file) ){
                $file = json_decode($file,true);
            }


            if( isset($file['link']) ){
                $file_info = pathinfo(cms_path('public',$file['link']));

                try {
                    unlink(cms_path('public',$file_info['basename']));
                } catch (Exception $e) {
                    
                }
            }
        }
    }
}

$metaUpdate = [
    'webmaster-tools'=>$webmaster_tools,
];

$plugin->updateMeta($metaUpdate);

return [
    'code'=>200,
    'success'=>true,
    'plugin'=>$plugin,
    'message'=> apiMessage('Verify Success.')
];