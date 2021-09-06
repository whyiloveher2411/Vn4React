@extends(backend_theme('master'))

@section('content')

<?php 
  title_head( __('Add New User') );

  $me_permission = [];

  $user = null ;
 if( Request::has('post') ){

 	$user = Vn4Model::findCustomPost('user',Request::get('post',0));

 	if($user){

	 	$me_permission = $user->permission;

		$me_permission = array_flip(explode(', ', $me_permission));
 	}

 }

 View::share('postDetail',$user);

 ?>
 <style>
  #input_slug__slug{
    line-height: 34px;
  }
  .disable_event{
    pointer-events: none;
    opacity: .6;
  }
 </style>
<div class="" >
    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
		@if($user)
			<input type="text" hidden name="edit_user" value="true" >
		@endif
      		<p class="note">@__('Create a brand new user and add them to this site')</p>

            <div class="form-group">
              	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title" style="text-align:left;">@__('Email'): </label>
              	<div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">
	          		@if( $user )
						<h4><code>{!!$user->email!!}</code><small> (@__('Can not change'))</small></h4>
	          		@else
                  		<input name="email" required="" value="" type="email" class="form-control col-md-7 col-xs-12">
                  	@endif
                </div>
            </div>

            <div class="form-group">
              	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title" style="text-align:left;">@__('First Name')</label>
              	<div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">
              		
                  <input name="first_name" required="" value="@if( $user ){!!$user->first_name!!}@endif" type="text" class="form-control col-md-7 col-xs-12">
                </div>
            </div>

            <div class="form-group">
              	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title" style="text-align:left;">@__('Last Name')</label>
              	<div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">
                  <input name="last_name" id="last_name" required="" value="@if( $user ){!!$user->last_name!!}@endif" type="text" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
			
			<div class="form-group">
              	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title" style="text-align:left;">@__('Slug')</label>
              	<div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">
              		<?php 
              			$slug = '';

              			if( $user ) $slug = $user->slug;
              		 ?>
                  {!!get_field('slug', ['key'=>'slug','value'=>$slug,'key_slug'=>'last_name','type_post'=>'user'])!!}
                </div>
                <p class="note"></p>
            </div>




			       
             <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align:left;" >@__('Password')</label>
              <div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0">

                <div class="input-group">
                  <input name="password" autocomplete="off" @if(!$user) required="" @endif value="" type="text" id="text_password" class="form-control col-md-7 col-xs-12">
                  <div class="input-group-addon btn-create-password" style="cursor: pointer;">@__('Generate Password')</div>
                </div>
                
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align:left;">@__('Role')</label>
              <div class="col-md-6 col-sm-6 col-xs-12 vn4-pd0" style="margin-top: 7px;">
                <select class="form-control" name="role">
                  <option value=""  >--Select--</option>
                  <option value="Super Admin" @if( $user && $user->role === 'Super Admin') selected="selected" @endif>Super Admin</option>
                </select>
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
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align:left;" >@__('Google Authenticator Secret')</label>
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
		          $obj = Vn4Model::firstOrAddnew(vn4_tbpf().'setting',['key_word'=>'list_role','type'=>'option_permission']);

		          $list_role = $obj->meta;

		            $list_role = json_decode($list_role, true);

		            $role_selected = Request::get('post_role','' );

		            vn4_panel(__('Select Role and change its capabilities').':',function() use ($role_selected , $list_role,$me_permission) {

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
		       ?>
		      @if( (!$list_role && !json_decode($list_role,true) ) || Request::has('add_new_role') )
		      <p><button name="create_role" value="true" class="vn4-btn vn4-btn-blue">@__('Save changes')</button></p>
		      @else
		      <p><button class="vn4-btn vn4-btn-blue vn4-btn-save">{!!$user?__('Save changes'):__('Add New')!!}</button></p>
		      @endif
    </form>
</div>
@stop

@section('js')
  
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

    $('#qrCodeUrl').attr('src',$('#qrCodeUrl').data('src'));

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
