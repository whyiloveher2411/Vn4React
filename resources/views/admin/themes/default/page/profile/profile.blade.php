<?php 
  $user = Auth::user();
?>

@extends(backend_theme('master'))



@section('content')
<style>
  .tab-content .control-label{
    text-align: left;
  }
  .default_input_img_result  {
    max-width: 250px;
  }
  .template, .template option{
    text-transform: capitalize;
  }
  .default_input_img_result{
    max-width: 100%;
  }
  .create_new_security{
    cursor: pointer;
  }
  .disable_event{
    pointer-events: none;
    opacity: .6;
  }
 <?php 
    title_head( __('Profile') );

   ?>
</style>
<form class="form-horizontal form-label-left" method="POST">
  <input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  <div class="row">
    <div class="col-xs-12">
      <div class="row">
      <div class="col-sm-2">
        
        <?php 
            $profile_picture =  [
                                'key'=>'profile_picture',
                                'value'=>$user->profile_picture,
                                'title'=>'Hình đại diện',
                                'thumbnail'=>[
                                    'nav-top'=>['title'=>'Nav Top','type'=>1,'width'=>74,'height'=>74]
                                ]
                            ];


         ?>

         {!!get_field('image', $profile_picture)!!}

       

        <h3 class="title">{!!$user->first_name!!} {!!$user->last_name!!}</h3>

        <div><button type="submit" name="save_change" class="vn4-btn vn4-btn-blue"> @__('Update Profile')</button></div>

      </div>
      <div class="col-sm-10">

        <?php 
          $tabs = [
              'personal_info' => ['title'=>__('Personal Info'),'content'=>function()  use ($user) {
                  ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('First Name')</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="first_name" value="{!!$user->first_name!!}" placeholder="First Name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Last Name')</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="last_name" value="{!!$user->last_name!!}" placeholder="Last Name">
                      </div>
                    </div>
                  <?php
              }],
              'personal_setting'=>['title'=>__('Personal Setting'),'content'=>function()  use ($user) {

                $user_mode = $user->getMeta('admin_mode',['light-mode','Light Mode']);

                ?>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Show the toolbar on the front end')</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ckb" style="margin-top: 7px;">
                          <input type="checkbox" class="form-control" value="1" name="active_show_toolbar" @if($user->getMeta('active_show_toolbar') ) checked="checked" @endif >
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Admin Template Mode')</label>
                        <div class="col-md-5 col-sm-5 col-xs-12 ckb" style="margin-top: 7px;">
                          <select class="form-control" name="admin-mode">
                            <option value="light-mode" @if($user_mode[0] === 'light-mode' ) selected="selected" @endif>Light Mode</option>
                            <option value="dark-mode" @if($user_mode[0] === 'dark-mode' ) selected="selected" @endif>Dark Mode</option>
                          </select>
                        </div>
                      </div>

                <?php
              }],
              'personal_contact'=>['title'=>__('Contact'),'content'=>function() use ($user) {
                ?>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Email')</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <span style="font-size: 19px;line-height: 33px;"><code>{!!$user->email!!}</code><small> (@__('Can\'t change'))</small></span>
                          </div>
                        </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Phone number')</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="number_phone" value="{!!$user->getMeta('number_phone')!!}" placeholder="Number Phone">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Social Network')</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            {!!get_field('repeater',[
                              'title'=>'Social Network',
                              'value'=>$user->getMeta('url_social_network'),
                              'key'=>'url_social_network',
                              'name'=>'url_social_network',
                              'sub_fields'=>[
                                'title'=>['title'=>'Title'],
                                'link'=>['title'=>'Link']
                              ]
                            ])!!}
                          </div>
                        </div>
                      
                <?php

              }],
              'personal_message'=>['title'=>__('About Yourself'),'content'=>function()  use ($user) {
                ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Biographical Info')</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php 
                            $description = [
                                              'key'=>'description',
                                              'value'=>$user->getMeta('description'),
                                              'height'=>300,
                                              'view' =>'editor',
                                              'required'=>true,
                                          ];

                         ?>

                         {!!get_field('editor',$description)!!}

                     
                      </div>
                    </div>

                <?php
              }],
              'personal_manager'=>['title'=>__('Account Management'),'content'=>function()  use ($user) {
                  ?>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Username')</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <span style="font-size: 19px;line-height: 33px;"><code>{!!$user->email!!}</code><small> (@__('Can\'t change'))</small></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Current Password')</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" autocomplete="off" class="form-control" name="old_password">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('New Password')</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" autocomplete="off" class="form-control" name="password_{!!Auth::user()->id!!}" id="text_password">
                          <br>
                          <div class="vn4-btn-white btn-create-password">
                              @__('Generate Password')
                          </div>
                        </div>
                      </div>

                      @if( setting('security_active_google_authenticator') === '["active"]' )

                      <?php 
                          require cms_path('root','lib/google-authenticator/Authenticator.php');

                          $Authenticator = new Authenticator();

                            if( !(Request::has('create_new_security') && Request::ajax()) ){

                              if( $user && $secret = $user->getMeta('security_google_authenticator_secret') ){

                              }else{
                                  $secret = $Authenticator->generateRandomSecret();
                              }
                            
                            $qrCodeUrl = $Authenticator->getQR(parse_url(URL::full())['host'], $secret);
                            
                          }
                       ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">@__('Google Authenticator Secret')</label>
                        <div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">
                          <div class="input-group">
                              <input type="text" class="form-control" name="security_google_authenticator_secret" id="secret" value="<?php echo $secret; ?>" placeholder="Security">
                              <div class="input-group-addon create_new_security" style="cursor: pointer;">Create new Key</div>
                          </div>
                          <br>
                          <img id="qrCodeUrl" data-src="<?php echo $qrCodeUrl; ?>">
                        </div>
                      </div>
                      @endif

                     
                  <?php
              }]
            ];


            if( check_permission('user-new_view') ){
              
              $tabs['permission'] = [
                'title'=>__('Permission'),
                'content'=>function() use ($user,$__env) {

                    $me_permission = $user->permission;

                    $me_permission = array_flip(explode(', ', $me_permission));

                    $obj = Vn4Model::firstOrAddnew(vn4_tbpf().'setting',['key_word'=>'list_role','type'=>'option_permission']);

                    $list_role = $obj->meta;

                    $list_role = json_decode($list_role, true);

                    $role_selected = Request::get('post_role','' );

                    vn4_panel(__('Select Role and change its capabilities').':',function() use ($role_selected , $list_role,$me_permission,$__env) {

                      echo vn4_view(backend_theme('page.user-role-editor.template-create-edit-user'),['role_selected'=>$role_selected,'list_role'=>$list_role,'me_permission'=>$me_permission]);

                    },false,null, ['callback_title'=>function() use ($role_selected , $list_role, $__env) {
                      ?>

                      @if( $list_role )
                      <select style="width: auto;display: inline;height:26px;padding:0px;font-weight: 100;"  class="form-control change-role-name">

                       <option value="none">@__('-- Select --')</option>
                       @foreach($list_role as $key => $role )  
                        <?php 
                          $count = json_decode($role['list_permission'],true);
                          if( is_array($count) ) $count = count($count); else $count = 0;
                         ?>
                       <option @if( $role_selected === $key ) selected @endif value="{!!$key!!}">{!!$role['title'],' (',$count!!} Permission )</option>
                       @endforeach

                     </select>
                     @endif

                     <?php
                   }]);
                }
              ];
            }

            $tabs['history'] = [
                'title'=>'History',
                'content'=>function() use ($user) {

                  use_module('log');

                  LaravelLogViewer::setStorage('logs/'.$_SERVER['HTTP_HOST'].'/user/'.Auth()->id());

                  $request = request();

                  if ($request->input('l')) {
                      LaravelLogViewer::setFile(Crypt::decrypt($request->input('l')));
                  }

                  if ($request->input('dl')) {
                    $pathToFile = LaravelLogViewer::pathToLogFile(Crypt::decrypt($request->input('dl')));
                  } elseif ($request->has('del')) {
                      app('files')->delete(LaravelLogViewer::pathToLogFile(Crypt::decrypt($request->input('del'))));
                  } elseif ($request->has('delall')) {
                      foreach(LaravelLogViewer::getFiles(true) as $file){
                          app('files')->delete(LaravelLogViewer::pathToLogFile($file));
                      }
                  }

                  $data = [
                      'logs' => LaravelLogViewer::all(),
                      'files' => LaravelLogViewer::getFiles(true),
                      'current_file' => LaravelLogViewer::getFileName()
                  ];

                  echo vn4_view(backend_theme('page.profile.history-user'), $data);
                }
              ];

            vn4_tabs_top($tabs,false,'profile');
        ?>
      </div>
      </div>
      

    </div>
    
    
  </div>
</form>
  
@stop

@section('js')
  
  <script>
    $(window).load(function(){
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

       $(document).on('click','.create_new_security',function(){
        $.ajax({
          url: '{!!route('admin.page','setting')!!}',
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
         
    });
  </script>

@stop

