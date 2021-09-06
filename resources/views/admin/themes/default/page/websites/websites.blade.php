@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'Websites' );


  add_action('vn4_head',function() {

    $actie_google_capcha = json_decode(setting('security_active_recapcha_google'),true);

    ?>
      <style>
        .form-setting .control-label{
            text-align: left;
        }
        .default_input_img_result img{
          max-width: 200px;
        }
        .key-security-recaptcha_sitekey, .key-security-recaptcha_secret{
          display: none;
        }
        .form-horizontal .control-label, .form-horizontal .checkbox{
          padding-top: 0;
        }
        .panel_toolbox .fa-trash-o{
            display: none;
        }
        /*label{
              position: absolute;
            z-index: 1;
            padding: 0px 5px;
            color: #5f6368;
            transform: translate(0%, -50%);
            background: white;
            margin-left: 9px;
        }
        .form-horizontal .form-group{
          margin-bottom: 25px;
        }*/

      </style>
    <?php
  });
 ?>
<div class="" >
    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

        
      <div class="row">
        <div class="col-sm-9">
        <?php 

            $value = [];

            $dirs = array_filter(glob(cms_path('public','../site/*')), 'is_dir');
            $site = [];
            foreach ($dirs as $w) {

                $info = json_decode(file_get_contents($w.'/info.json'),true);

                $key = basename($w);

                $value[] = [
                    'delete'=>0,
                    'name'=>$info['name'],
                    'domain'=>$key,
                    'admin'=>$info['admin'],
                    'https'=>$info['https']??0,
                ];
            }


            echo get_field('repeater',[
                'title'=>'Website',
                'key'=>'websites',
                'value'=>$value,
                'sub_fields'=>[
                    'name'=>['title'=>'Title','view'=>'text'],
                    'domain'=>['title'=>'Domain','view'=>'text','readonly'=>true],
                    'admin'=>['title'=>'Admin','view'=>'text'],
                    'https'=>['title'=>'Https','view'=>'true_false','label'=>'Https'],
                ]
            ]);

       ?>
        </div>
         <div class="col-sm-3">
        <?php 
          vn4_panel('Action',function(){
            echo '<button class="vn4-btn vn4-btn-blue">'.__('Save changes').'</button>';
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
          // if( $(this).is(":checked") ){

          // }else{
          // }
      });
    })
  </script>
@stop
