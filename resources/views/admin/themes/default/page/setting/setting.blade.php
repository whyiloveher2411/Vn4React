@extends(backend_theme('master'))

<?php 
  
  if( Request::has('create_new_security') && Request::ajax() ){
    $user = Auth::user();
    require cms_path('public','../lib/google-authenticator/Authenticator.php');

    $Authenticator = new Authenticator();

    $secret = $Authenticator->generateRandomSecret();
    $qrCodeUrl = $Authenticator->getQR(parse_url(env('APP_URL'))['host'], $secret);
    die(json_encode(['qrCodeUrl'=>$qrCodeUrl,'secret'=>$secret]));
  }

  $search = Request::get('q');

 ?>

@section('content')

<?php 

 title_head( __('Setting') );

  add_action('vn4_heading',function(){
    ?>
     <span class="dropdown" style="line-height: 28px;font-size: 14px;">
          <span  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-edit"></i></span>
          <ul class="dropdown-menu dropdown-menu-left" role="menu">
              <li><a href="javascript:void(0)" onclick="window.location.href = replaceUrlParam(window.location.href,'type_view','fields');" class="create_data" ><label>@__('Fields')</a></label></li>
              <li><a href="javascript:void(0)" onclick="window.location.href = replaceUrlParam(window.location.href,'type_view','custom-fields');" class="create_data" ><label>@__('Custom Fields')</a></label></li>
          </ul>
      </span>
    <?php
  });

  add_action('vn4_head',function() {

    $actie_google_capcha = setting('security_active_recapcha_google');
    $actie_google_authenticator = setting('security_active_google_authenticator');
    $signin_with_google_account = setting('security_active_signin_with_google_account');
    ?>
      <style>
        .form-setting .control-label{
            text-align: left;
        }
        .default_input_img_result img{
          max-width: 200px;
        }
        .key-security-recaptcha_sitekey, .key-security-recaptcha_secret, .key-security-google_authenticator_secret, .key-security-google_oauth_client_id, .key-security-google_oauth_client_secret{
          display: none;
        }
        .form-horizontal .control-label, .form-horizontal .checkbox{
          padding-top: 0;
        }
        .create_new_security{
          cursor: pointer;
        }

        @if( $actie_google_capcha === '["active"]' )
          .key-security-recaptcha_sitekey, .key-security-recaptcha_secret{
            display: block;
          }
        @endif 

        @if( $actie_google_authenticator === '["active"]' )
          .key-security-google_authenticator_secret{
            display: block;
          }
        @endif 


        @if( $signin_with_google_account === '["active"]' )
          .key-security-google_oauth_client_id, .key-security-google_oauth_client_secret{
            display: block;
          }
        @endif 
      </style>

      


    <?php
  });
 ?>
<div class="" >
    
    @if( Request::get('type_view') === 'custom-fields')
    <form class="row" action="{!!Request::url()!!}?type_view=custom-fields" method="get" style="margin-bottom: 25px;">
      <div class="col-sm-9 "  >
        <input type="text" class="form-control in-search" name="q" value="{{$search}}">
      </div>
    </form>
    @endif

    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

      <div class="row">
        <div class="col-sm-9">

          @if( Request::get('type_view') === 'custom-fields')
           <div class="warper-meta-field">
            <?php 
                $meta = DB::table(vn4_tbpf().'setting')->orderBy(Vn4Model::$id,'asc')->where('type','setting');

                if( $search ) $meta = $meta->where('key_word','LIKE','%'.$search.'%');

                $meta = $meta->paginate(15)->setPath('setting?type_view=custom-fields');
                // dd($meta);
                // setting();

                $value = [];

                foreach ($meta as $key => $value_meta) {

                  $v = json_decode($value_meta->content,true);

                  if( $v !== null ){
                    $v = json_encode($v,JSON_PRETTY_PRINT);
                  }else{
                    $v = $value_meta->content;
                  }

                  $value[] = [
                    'delete'=>0,
                    'key'=>$value_meta->key_word,
                    'value'=>$v
                  ];
                }
                // echo vn4_view('default.paginate',['paginator'=>$meta]);

                echo get_field('repeater',[
                  'button_label'=>'Add Field',
                  'value'=>$value,
                  'key'=>'setting',
                  'button_remove'=>false,
                  'sub_fields'=>[
                    'key'=>['title'=>'Key'],
                    'value'=>['title'=>'Value','view'=>'textarea','rows'=>6],
                  ]
                ]);
             ?>
            </div>
            <div style="margin-top: 10px;">
              {!!vn4_view(backend_theme('particle.post-type.paginate-simple'),['list_data'=> $meta])!!}
            </div>
          @else
          <?php 
            $list_setting = get_setting_object();
            $list_tab_setting = [];
            $setting_db = setting();

            foreach ($list_setting as $key => $setting) {

              if( check_permission('change_setting_'.$key)){
                 $list_tab_setting[$key] = [
                  'id'=>$key,
                  'title'=>$setting['title'],
                  'content'=>function() use ($setting,$setting_db,$key, $__env){
                       ?>
                         @foreach($setting['fields'] as $key2 => $field)
        
                          <?php 

                            $field['key'] =  $key.'_'.$key2;
                            if( !isset($field['value']) ){

                              if( isset($setting_db[$key.'_'.$key2]) ){
                                $field['value'] = $setting_db[$key.'_'.$key2];
                              }else{
                                $field['value'] = '';
                              }

                            }

                           ?>
                          
                          <div class="form-group key-{!!$key,'-',$key2!!}">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="domain">{!!$field['title']!!}
                            </label>

                            
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              {!!get_field($field['view'],$field)!!}

                               @if(isset($field['note']) && $field['view'] != 'image')
                                <div class="note">{!!$field['note']!!}</div>
                              @endif
                              </div>
                          </div>

                        @endforeach
                    <?php
                  }
                ];
              }
            }

            vn4_tabs_left($list_tab_setting);

           ?>

          @endif
      
        </div>
         <div class="col-sm-3">
        <?php 
          vn4_panel('Action',function(){
            echo '<button class="vn4-btn vn4-btn-blue" data-message="The process is running, please wait a moment">'.__('Save changes').'</button>';
          });
         ?>
        </div>

      </div>
    </form>

</div>
@stop

@section('js')
  <script>
    $(window).load(function(){
      $('input[name="security_active_recapcha_google[]"]').click(function(event) {
          $('.key-security-recaptcha_sitekey, .key-security-recaptcha_secret').slideToggle(200);
      });

      $('input[name="security_active_google_authenticator[]"]').click(function(event) {
          $('.key-security-google_authenticator_secret').slideToggle(200);
      });

       $('input[name="security_active_signin_with_google_account[]"]').click(function(event) {
          $('.key-security-google_oauth_client_id, .key-security-google_oauth_client_secret').slideToggle(200);
      });

       $('.in-search').on('keypress',function(e){
          if(e.keyCode == 13){
            e.preventDefault();

            window.location.href = '{!!route('admin.page','setting')!!}?type_view=custom-fields&q='+$(this).val();
          }
       });

    })
  </script>
@stop
