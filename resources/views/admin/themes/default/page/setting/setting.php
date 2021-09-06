<?php 

$info = json_decode(file_get_contents( cms_path('root','cms.json') ),true);

$setting['general'] = [
    'title'=>__('General'),
    'fields'=>[
        'status'=>[
            'title'=>__('Status'),
            'view'=>'select',
            'list_option'=>['dev'=>'Developing','production'=>'Production'],
            'toggle'=>true,
            'note'=>'Some functions will be activated when the website is ready, the view will automatically minify, so please check javascript, css, html before turning on.',
        ],
        'site_title'=>[
            'title'=>__('Site Title'),
            'view'=>'input',
        ],
        'description'=>[
            'title'=>__('Description'),
            'view'=>'input',
            'note'=>__('In a few words, explain what this site is about'),
        ],
        'email_address'=>[
            'title'=>__('Email Address'),
            'view'=>'input',
            'type'=>'email',
            'note'=>__('This address is used for admin purposes, like new user notification'),
        ],
        'timezone'=>[
            'title'=>__('Timezone'),
            'view'=>'select',
            'select_group'=>true,
            'list_option'=> include(__DIR__.'/timezone2.php'),
        ],
        'date_format'=>[
            'title'=>__('Date Format'),
            'view'=>[
                'form'=>function($arg){
                    return vn4_view(backend_theme('page.setting.input_date_format'),$arg);
                }
            ],
            'type'=>'radio',
            'list_option'=>['F j, Y'=>date('F j, Y'),'Y-m-d'=>date('Y-m-d'),'m/d/Y'=>date('m/d/Y'),'d/m/Y'=>date('d/m/Y')],
        ],
        'time_format'=>[
            'title'=>__('Time Format'),
            'view'=>[
                'form'=>function($arg){
                    return vn4_view(backend_theme('page.setting.input_date_format'),$arg);
                }
            ],
            'list_option'=>['g:i a'=>date('g:i a'),'g:i A'=>date('g:i A'),'H:i'=>date('H:i')],
        ],
    ]
];

$setting['license'] = [
    'title'=>'License (Api)',
    'fields'=>[
        'secret'=>[
            'title'=>'Secret',
            'view'=>'text',
        ],
        'token'=>[
            'title'=>'Token',
            'view'=>'textarea',
            'note'=>'<a class="vn4-btn vn4-btn-blue" style="margin:5px 0;" href="'.$info['url_license'].'?access_token='.\Firebase\JWT\JWT::encode( ['time'=>time(), 'url'=>route('admin.controller',['controller'=>'license','method'=>'setting'])], 'vn4cms_api').'" onclick="return !window.open(this.href, \'Vn4CMS Auth\', \'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top=\'+(window.screen.height/2-290)+\', left=\'+(window.screen.width/2-320))" >Get License</a>'
        ]
    ]
];


$setting['reading'] = [
    'title'=>__('Reading Settings'),
    'fields'=>[
        'homepage'=>[
            'title'=>'Homepage',
            'key'=>'reading_homepage',
            'view'=>[
                'form'=>function($arg){
                    return vn4_view(backend_theme('page.setting.input_reading_homepage'),$arg);
                }
            ],
            'save'=>function($input, $not_customize = true ){

                $value = $input['reading_homepage'];
                $admin_object = get_admin_object();

                foreach ($admin_object as $v) {
                    DB::table($v['table'])->where('is_homepage','like','%"route-name":"index"%')->update(['is_homepage'=>0]);
                }

                if( $value['type'] === 'static-page' ){

                    if( !view()->exists('themes.'.theme_name().'.page.'.$value['static-page']) ){
                        $value['type'] = 'default';
                    }

                }elseif ( $value['type'] === 'custom') {
                    
                    if( $page = get_post($value['post-type'],$value['post-id']) ){
                        $page->is_homepage = json_encode(['route-name'=>'index','parameter'=>[],'title'=>'Home Page']);
                        $page->save();
                    }else{
                        $value['type'] = 'default';
                    }

                }
                // if($not_customize) return save_option('reading_homepage',$value);

                return $value;

            }
        ],
    ]
];

$setting['admin_template'] = [

    'title'=>__('Admin Template'),
    'fields'=>[
        'logo'=>[
            'title'=>__('Logo (login)'),
            'view'=>'image',
        ],
        'logan'=>[
            'title'=>__('Slogan'),
            'view'=>'text',
        ],
        'color-left'=>[
            'title'=>'Color Section Left',
            'view'=>'color',
        ],
        'headline-right'=>[
            'title'=>__('Headline Right'),
            'view'=>'text',
        ],
        'color-right'=>[
            'title'=>'Color Section Right',
            'view'=>'color',
        ],
    ]

];

$setting['security'] = [
    'title'=>__('Security'),
    'fields'=>[    
        'prefix_link_admin'=>[
            'title'=>__('Prefix Link Admin'),
            'view'=>'input',
            'value_default'=>'admin',
            'note'=>__('Do not use the following words: {admin}, {backend}, {user} .... keep it secret only you and the site administrator know')
        ],
        'link_login'=>[
            'title'=>__('Link Sign In'),
            'view'=>'input',
            'value_default'=>'login',
            'note'=>__('Do not use the following words: {login}, {signin},.... keep it secret only you and the site administrator know')
        ],
        'limit_login_count'=>[
            'title'=>__('Limit Sign In Count'),
            'view'=>'number',
            'note'=>__('Limit number of wrong logins'),
        ],
        'limit_login_time'=>[
            'title'=>__('Limit Sign In Time'),
            'append'=>__('Seconds'),
            'view'=>'number',
            'note'=>__('Lock time when user log in too many times allowed'),
        ],
        'accept_ip_login'=>[
            'title'=>'IP allowed to access login page',
            'view'=>'textarea',
        ],
        'disable_iframe'=>[
            'title'=>__('Disable Iframe'),
            'view'=>'checkbox',
            'toggle'=>true,
            'list_option'=>['active'=>''],
            'note'=>'You will not be able to use theme customization when disabling iframes',
        ],
        'login_on_a_single_machine'=>[
            'title'=>__('Sign In on device'),
            'view'=>'checkbox',
            'toggle'=>true,
            'list_option'=>['active'=>''],
            'note'=>'Only one device login limit',
        ],
        'active_recapcha_google'=>[
            'title'=>'Active Recapcha',
            'view'=>'checkbox',
            'toggle'=>true,
            'list_option'=>['active'=>''],
            'note'=>__('Enable captcha checking in the login form into the admin area'),
        ],
        'recaptcha_sitekey'=>[
            'title'=>'Site Key Recapcha Google',
            'view'=>'input',
            'type'=>'text',
            'note'=>'Site Key Recapcha Google is the key capcha of your website used to authenticate recapcha used on login, you can get the key <a href="https://www.google.com/recaptcha/admin" target="_blank"> here </a>. learn more here'
        ],
        'recaptcha_secret'=>[
            'title'=>'Recapcha secret',
            'view'=>'input',
            'type'=>'text',
            'note'=>'Recapcha secret is the capcha code of your website used to authenticate recapcha used on login, you can get the key <a href="https://www.google.com/recaptcha/admin" target="_blank"> here </a>. learn more here'
        ],


        'active_google_authenticator'=>[
            'title'=>'Two Step Authentication',
            'view'=>'checkbox',
            'toggle'=>true,
            'list_option'=>['active'=>''],
        ],
        'google_authenticator_secret'=>[
            'title'=>'Google Authenticator Secret',
            'view'=>[
                'form'=>function($fields,$post){

                    $user = Auth::user();
                      
                      require cms_path('public','../lib/google-authenticator/Authenticator.php');

                      $Authenticator = new Authenticator();

                      if( !(Request::has('create_new_security') && Request::ajax()) ){

                        if( !$secret = setting('security_google_authenticator_secret') ){
                          $secret = $Authenticator->generateRandomSecret();
                        }
                        if( isset(parse_url(env('APP_URL'))['host']) ){
                            $qrCodeUrl = $Authenticator->getQR(parse_url(env('APP_URL'))['host'], $secret);
                        }else{
                          $qrCodeUrl = $Authenticator->getQR($user->email, $secret);
                        }
                        
                      }


                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" name="security_google_authenticator_secret" id="secret" value="<?php echo $secret; ?>" placeholder="Security">
                        <div class="input-group-addon create_new_security">Create new Key</div>
                    </div>
                    <br>
                    <img id="qrCodeUrl" data-src="<?php echo $qrCodeUrl; ?>">
                    <p class="note"><?php echo __('Each user will have a unique secret code, for users who have previously been created without a private code can use this shared secret code.'); ?></p>
                    <?php

                    add_action('vn4_footer',function(){
                        ?>
                        <script>
                            $(window).load(function(){

                              if( $('#active_google_authenticator').prop('checked') ){
                                $('#google_authenticator_security').removeClass('disable_event');
                              }else{
                                $('#google_authenticator_security').addClass('disable_event');
                              }

                              $(document).on('click','#active_google_authenticator',function(){
                                if( $(this).prop('checked') ){
                                  $('#google_authenticator_security').removeClass('disable_event');
                                }else{
                                  $('#google_authenticator_security').addClass('disable_event');
                                }
                              });

                              $('#qrCodeUrl').attr('src',$('#qrCodeUrl').data('src'));
                              $(document).on('click','.create_new_security',function(){
                                $.ajax({
                                  dataType:'Json',
                                  type:'GET',
                                  data:{
                                    _token:"<?php echo csrf_token(); ?>",
                                    create_new_security:true,
                                  },
                                  success:function(data){
                                    $('#secret').val(data.secret);
                                    $('#qrCodeUrl').attr('src',data.qrCodeUrl);
                                  }
                                });
                              });
                              $(document).on('click','.btn-create-password',function(event) {
                                var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz!@#$%^&*()_+<>?~";
                                var string_length = 24;
                                var randomstring = '';
                                for (var i=0; i<string_length; i++) {
                                    var rnum = Math.floor(Math.random() * chars.length);
                                    randomstring += chars.substring(rnum,rnum+1);
                                }

                                $('#text_password').val(randomstring);
                              });

                            });
                          </script>
                        <?php
                    });
                }
            ],
        ],

        'active_signin_with_google_account'=>[
            'title'=>'Sign In With Google',
            'view'=>'checkbox',
            'toggle'=>true,
            'list_option'=>['active'=>''],
            'note'=>__('Accounts using google email will be mapped to google accounts to help you sign in faster and more securely (registration not included).'),
        ],
        'google_oauth_client_id'=>[
            'title'=>'Google OAuth Client ID',
            'view'=>'input',
            'type'=>'text',
        ],
        'google_oauth_client_secret'=>[
            'title'=>'Google OAuth Client Secret',
            'view'=>'input',
            'type'=>'text',
        ],
        


    ]
];

// $setting['security']['fields']['recaptcha_sitekey'] = [
    
// ];

// $setting['security']['fields']['recaptcha_secret'] = [
    
// ];


$setting = apply_filter('setting',$setting);

return $setting;