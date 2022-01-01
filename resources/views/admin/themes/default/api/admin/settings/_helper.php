<?php

function getSettingAdmin(){

    $__settings = setting();

    unset($__settings['security_recaptcha_secret']);
    unset($__settings['security_google_authenticator_secret']);
    unset($__settings['security_google_authenticator_secret_img']);

    return $__settings;

}

function getDataSetting($group, $subGroup = null){
    
    $fileConfigField = __DIR__.'/config/'.$group;

    if( $subGroup ){
        $fileConfigField .= '/'.$subGroup.'.php';
    }else{
        $fileConfigField .= '.php';
    }

    if( file_exists( $fileConfigField ) ){
        $config = include $fileConfigField;
    }else{
        $config = [];
    }

    $data = [
        // 'row'=>setting(),
        'tabs'=>[
            'general'=>[
                'title'=>__('General'),
                'icon'=>'PublicOutlined',
            ],
            'reading-settings'=>[
                'title'=>__('Reading Settings'),
                'icon'=>'HomeOutlined',
            ],
            'admin-template'=>[
                'title'=>__('Admin Template'),
                'icon'=>'SupervisorAccountOutlined',
            ],
            'security'=>[
                'title'=>__('Security'),
                'icon'=>'SecurityOutlined',
            ],
            'media'=>[
                'title'=>__('Media'),
                'icon'=>'FolderOpenOutlined',
            ],
        ],
        'config'=>$config,
    ];

    $data = do_action('setting_filter_get', $data, $group, $subGroup);

    return $data;
}