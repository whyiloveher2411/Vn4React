<?php

function getSettingAdmin(){

    $__settings = Cache::rememberForever('setting.', function(){
        
        $__settings = new Vn4Model(vn4_tbpf().'setting');

        $__settings = $__settings->whereType('setting')->pluck('content','key_word');

        return $__settings;
    });

    unset($__settings['security_recaptcha_secret']);
    unset($__settings['security_google_authenticator_secret']);
    unset($__settings['security_google_authenticator_secret_img']);

    return $__settings;

}