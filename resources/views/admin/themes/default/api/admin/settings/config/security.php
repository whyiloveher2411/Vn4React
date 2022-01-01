<?php

return [
    [
        'fields'=>[
            'security_prefix_link_admin'=>[
                'title'=>__('Link to admin page'),
                'view'=>'text',
                'note'=>__('The default admin page path is admin, change it to a secret word that only you and a few people know to be able to access the webmaster'),
                'saveCallback'=>function($value){
                    if( !$value ){
                        return 'admin';
                    }
                    return $value;
                }
            ],
            'security_link_login'=>[
                'title'=>__('Link Sign In'),
                'view'=>'text',
            ],
        ]
    ],
    [
        'fields'=>[
            'security_token_expiration_time'=>[
                'title'=>__('Token expiration time (Seconds)'),
                'view'=>'number',
            ],
            'security_limit_login_count'=>[
                'title'=>__('Limit the number of times you enter the wrong password'),
                'view'=>'number',
            ],
            'security_accept_ip_login'=>[
                'title'=>__('Limit ip can login admin page'),
                'view'=>'textarea',
                'saveCallback'=>function($ipAccess){
                    preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $ipAccess, $ip_matches);
                    if( count($ip_matches[0]) ){
                        array_unshift($ip_matches[0], '127.0.0.1');
                        $ip_matches = array_flip($ip_matches[0]);
                        $ip_matches = array_flip($ip_matches);
                        return implode("\r\n",$ip_matches);
                    }else{
                        return '';
                    }
                }
            ],
            'security_signin_on_single_machine'=>[
                'title'=>__('Sign in on a single machine'),
                'view'=>'select',
                'list_option'=> [
                    [ 'title'=> __('Optional'), 'description'=> __('User may not enable or enable it depending on the user') ],
                    [ 'title'=> __('Obligatory'), 'description'=> __('All users are only allowed to login on a single machine at a time') ]
                ]
            ],
        ]
    ],
    [
        'fields'=>[
            'security_disable_iframe'=>[
                'title'=>__('Disable Iframe'),
                'note'=> __('Turn off embedding my website on other websites'),
                'view'=>'true_false',
            ],
            'security_login_on_a_single_machine'=>[
                'title'=>__('Sign In on one device'),
                'note'=> __('Only one device login limit'),
                'view'=>'true_false',
            ],
            'security_enable_remember_me'=>[
                'title'=>__('Enable Remember Me'),
                'note'=> __('User will not need to sign in after each token expiration, this function is usually used with personal computers'),
                'view'=>'true_false',
            ],
        ]
    ],
    [
        'fields'=>[
            'security_active_recaptcha_google'=>[
                'title'=>__('Activate Recaptcha'),
                'note'=> __('Enable captcha checking in the login form into the admin area'),
                'view'=>'true_false',
            ],
            'security_recaptcha_sitekey'=>[
                'title'=>__('Site Key Recaptcha Google'),
                'note'=> __('Site Key Recaptcha Google is the key capcha of your website used to authenticate recaptcha used on login, you can get the key here . learn more here'),
                'active'=>'security_active_recaptcha_google',
                'view'=>'text',
            ],
            'security_recaptcha_secret'=>[
                'title'=>__('Recaptcha secret'),
                'note'=> __('Recaptcha secret is the capcha code of your website used to authenticate recaptcha used on login, you can get the key here . learn more <a href="https://www.google.com/recaptcha/admin" target="_blank"> here </a>'),
                'active'=>'security_active_recaptcha_google',
                'view'=>'text',
            ],
        ]
    ],
    [
        'fields'=>[
            'security_active_google_authenticator'=>[
                'title'=>__('2-Step Authentication'),
                'view'=>'true_false',
            ],
            'security_google_authenticator_secret'=>[
                'title'=>__('Google Authenticator Secret'),
                'note'=> __('Scan the image below with Google Authenticator or an alternative application.'),
                'active'=>'security_active_google_authenticator',
                'view'=>'custom',
                'component'=>'components/GoogleAuthenticatorSecretImg',
            ]
        ]
    ],
    [
        'fields'=>[
            'security_active_signin_with_google_account'=>[
                'title'=>__('Sign In With Google'),
                'note'=>__('Accounts using google email will be mapped to google accounts to help you sign in faster and more securely (registration not included).'),
                'view'=>'true_false',
            ],
            'security_google_oauth_client_id'=>[
                'title'=>__('Google OAuth Client ID'),
                'active'=>'security_active_signin_with_google_account',
                'view'=>'text',
            ],
            'security_google_oauth_client_secret'=>[
                'title'=>__('Google OAuth Client Secret'),
                'active'=>'security_active_signin_with_google_account',
                'view'=>'text',
            ],
        ]
    ]
];