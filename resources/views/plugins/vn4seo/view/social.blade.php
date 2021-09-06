@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'Dashboard - SEO VN4 -' );

 
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

 title_head('Social - SEO Vn4');


 ?>
<div class="">
    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
      <div class="row seo_vn4">
        <div class="col-xs-12 col-md-9">
           <?php 
              vn4_tabs_top([
                  ['id'=>'accounts',
                  'title'=>'Accounts',
                  'content'=>function() use ($plugin){
                    echo view_plugin($plugin,'view.tabs.social_accounts');
                  }],
                  ['id'=>'facebook',
                  'title'=>'<i class="fa fa-facebook" aria-hidden="true"></i> Facebook',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.social_facebook');
                  }],
                  ['id'=>'twitter',
                  'title'=>'<i class="fa fa-twitter" aria-hidden="true"></i> Twitter',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.social_twitter');
                  }],
                  ['id'=>'pinterest',
                  'title'=>'<i class="fa fa-pinterest" aria-hidden="true"></i> Pinterest',
                  'content'=>function() use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.social_pinterest');
                  }],
                  ['id'=>'google-plus',
                  'title'=>'<i class="fa fa-google-plus" aria-hidden="true"></i> Google+',
                  'content'=>function()use ($plugin) {
                    echo view_plugin($plugin,'view.tabs.social_googleplus');
                  }]
                ]);
           ?>
          <br><button class="vn4-btn vn4-btn-blue">Save changes</button>
        </div>
        <div class="col-xs-12 col-md-3">
        </div>
      </div>

    </form>

</div>
@stop
