@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'Dashboard' );

 
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
      <div class="col-xs-12 col-md-9">
        <div class="seo_vn4">
          <?php 
              vn4_tabs_top([
                  ['id'=>'dashboard',
                  'title'=>'Dashboard',
                  'content'=>function() use ($plugin){
                    echo view_plugin($plugin,'view.tabs.dashboard_index');
                  }],
                  ['id'=>'general',
                  'title'=>'General',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.dashboard_general');
                  }],
                  ['id'=>'features',
                  'title'=>'Features',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.tab_features');
                  }],
                  ['id'=>'your-info',
                  'title'=>'Your Info',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.tab_your_info');
                  }],
                  ['id'=>'webmaster-tools',
                  'title'=>'Webmaster Tools',
                  'content'=>function()use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.dashboard_webmaster_tools');
                  }],
                  ['id'=>'security',
                  'title'=>'Security',
                  'content'=>function()use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.tab_security');
                  }]
                ]);
           ?>
        </div>
        <br><button class="vn4-btn vn4-btn-blue">Save changes</button>
      </div>
    </div>
  </form>
@stop
