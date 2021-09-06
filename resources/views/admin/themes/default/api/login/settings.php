<?php

$setting = setting();

return [
    'template'=>[
        'admin_template_logan'=>$setting['admin_template_logan']??'',
        'admin_template_image'=>$setting['admin_template_image']??'',
        'admin_template_color-left'=>$setting['admin_template_color-left']??'',
        'admin_template_headline-right'=>$setting['admin_template_headline-right']??'',
    ],
    'security'=>[
        'security_limit_login_count'=>$setting['security_limit_login_count']??'',
        'security_limit_login_time'=>$setting['security_limit_login_time']??'',
        'security_accept_ip_login'=>$setting['security_accept_ip_login']??'',
        'security_disable_iframe'=>$setting['security_disable_iframe']??'',
        'security_login_on_a_single_machine'=>$setting['security_login_on_a_single_machine']??'',
        'security_active_recapcha_google'=>$setting['security_active_recapcha_google']??'',
        'security_recaptcha_sitekey'=>$setting['security_recaptcha_sitekey']??'',
        'security_active_google_authenticator'=>$setting['security_active_google_authenticator']??'',
        'security_active_signin_with_google_account'=>$setting['security_active_signin_with_google_account']??'',
        'security_google_oauth_client_id'=>$setting['security_google_oauth_client_id']??'',
    ]
];

