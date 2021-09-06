@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'Setting' );

 
 add_action('vn4_head',function(){
    ?>
      <style>
        #seo_vn4 .icon-optimization{
          width: 20px;
        }
        #seo_vn4 .google-title-style{
          color: #1a0dab;
            cursor: pointer;
            font-size: 18px;
            max-width: 600px;
            margin-left: 50px;
        }
        #seo_vn4 .google-title-style:hover{
          text-decoration: underline;
        }
        #seo_vn4 .google-url-style{
          color: #006621;
            font-style: normal;
          margin-left: 50px;
            font-size: 14px;
            cursor: pointer;
            max-width: 600px;
        }

        #seo_vn4 .google-description-style{
          line-height: 1.4;
            word-wrap: break-word;
            font-size: small;
            font-family: arial,sans-serif;
            color: #545454;
          margin-left: 50px;
            max-width: 600px;
        }
      </style>
    <?php
  },'seo_vn4'.'_css',true);



 ?>
  <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
    <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
    <div class="row seo_vn4">
      <div class="col-xs-12 col-md-9" style="margin-bottom: 10px;">
        <div class="seo_vn4">
          <?php 
              vn4_tabs_top([

                 // 'general'=>[
                 //    'title'=>'General',
                 //    'content'=>function() use ($plugin) {
                 //      echo view_plugin($plugin,'view.setting.dashboard_general');
                 //    }
                 //  ],

                  // 'default'=>[
                  //   'title'=>'Default',
                  //   'content'=>function() use ($plugin){

                  //     $value = [];

                  //     $data = [
                  //       'plugin_vn4seo_google_title'=>isset($value['plugin_vn4seo_google_title'])?$value['plugin_vn4seo_google_title']:title_head(),
                  //       'plugin_vn4seo_google_description'=>isset($value['plugin_vn4seo_google_description'])?$value['plugin_vn4seo_google_description']:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam dolor, natus! Tempora facilis quis magni consequatur? Adipisci porro debitis placeat numquam mollitia quos quibusdam, id inventore magnam. Minima, tempora, beatae.',
                  //       'plugin_vn4seo_focus_keyword'=>isset($value['plugin_vn4seo_focus_keyword'])?$value['plugin_vn4seo_focus_keyword']:'',
                  //       'link'=>route('index'),
                  //       'plugin_vn4seo_facebook_title'=>isset($value['plugin_vn4seo_facebook_title'])?$value['plugin_vn4seo_facebook_title']:'',
                  //       'plugin_vn4seo_facebook_description'=>isset($value['plugin_vn4seo_facebook_description'])?$value['plugin_vn4seo_facebook_description']:'',
                  //       'plugin_vn4seo_facebook_image'=>isset($value['plugin_vn4seo_facebook_image'])?$value['plugin_vn4seo_facebook_image']:'',
                  //       'plugin_vn4seo_twitter_title'=>isset($value['plugin_vn4seo_twitter_title'])?$value['plugin_vn4seo_twitter_title']:'',
                  //       'plugin_vn4seo_twitter_description'=>isset($value['plugin_vn4seo_twitter_description'])?$value['plugin_vn4seo_twitter_description']:'',
                  //       'plugin_vn4seo_twitter_image'=>isset($value['plugin_vn4seo_twitter_image'])?$value['plugin_vn4seo_twitter_image']:'',
                  //     ];

                  //     echo view_plugin($plugin,'view.post-type.master', ['plugin_keyword'=>$plugin->key_word,'post'=>null,'data'=>$data]);
                  //   }
                  // ],
                  // 'general'=>[
                  //   'title'=>'General',
                  //   'content'=>function() use ($plugin) {
                  //     echo view_plugin($plugin,'view.tabs.dashboard_general');
                  //   }
                  // ],
                  // 'features'=>[
                  //   'title'=>'Features',
                  //   'content'=>function() use ($plugin) {
                  //     echo view_plugin($plugin,'view.tabs.tab_features');
                  //   }
                  // ],
                  // 'your-info'=>[
                  //   'title'=>'Your Info',
                  //   'content'=>function() use ($plugin) {
                  //     echo view_plugin($plugin,'view.tabs.tab_your_info');
                  //   }
                  // ],
                  'webmaster-tools'=>[
                    'title'=>'Webmaster Tools',
                    'content'=>function()use ($plugin) {
                      echo view_plugin($plugin,'view.setting.dashboard_webmaster_tools');
                    }
                  ],
                  'site-map'=>[
                    'title'=>'Sitemap',
                    'content'=>function() use ($plugin){
                      echo view_plugin($plugin,'view.setting.sitemap');
                    }
                  ]
                  // 'security'=>[
                  //   'title'=>'Security',
                  //   'content'=>function()use ($plugin) {
                  //     echo view_plugin($plugin,'view.tabs.tab_security');
                  //   }
                  // ]
                ],true,'setting');
           ?>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <?php 
          vn4_panel('Action',function(){
            echo '<button class="vn4-btn vn4-btn-blue">Save changes</button>';
          });
         ?>
        
      </div>
    </div>
  </form>
@stop
