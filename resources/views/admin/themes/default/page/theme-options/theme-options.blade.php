@extends(backend_theme('master'))

@section('content')
<?php 
  title_head( __('Theme Options') );

  $user = Auth::user();

  $edit = Request::get('edit');
 ?>
<form class="form-horizontal form-label-left" method="POST">
  <input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  <div class="row">
    <?php 
        if( file_exists($file = cms_path('resource','views/themes/'.theme_name().'/inc/theme-option.php')) ){
            include $file;
        }
        $fields = apply_filter('theme_options',[
            'definition'=> [
              'fields'=>[
                'title'=>'text',
                'favicon'=>'image'
              ]
            ]
        ]);
        
        if( !is_array($fields) ) $fields = [];

        $tabs = [];

        foreach ($fields as $key => $value) {
          $tabs[$key] = [
            'title'=>$value['title']??capital_letters($key),
            'content'=>function() use ($value,$__env,$key) {

              ?>
              @foreach($value['fields'] as $key2 => $field)

                <?php 

                  if( is_string($field) ) $field = ['view'=>$field];

                  $field['title'] = $field['title']??capital_letters($key2);
                  
                  if( !isset($field['view']) ) $field['view'] = 'input';
                  $field['key'] =  $key.'_'.$key2;
                  $field['name'] =  'theme-option['.$key.']['.$key2.']';

                  $value = do_action('admin.page.theme-options.get-value',$key,$key2);

                  if( $value === null ) $value = theme_options($key,$key2);

                  $field['value'] = $value;
                ?>

                <div class="form-group form-field form-{!!$key2!!}">
                  <label class="label-input" for="{!!$key2!!}"> {!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif
                    </label>
                    {!!get_field($field['view'], $field)!!}
                </div>
                @endforeach
              <?php
            }
          ];
        }
     ?>

    @if( count($tabs) > 0 )
      <div class="col-sm-9">
        <?php vn4_tabs_left($tabs,true,'theme-option'); ?>
      </div>
      <div class="col-sm-3">
      <?php 
        do_action('admin.page.theme-options');
        
        vn4_panel('Action',function(){
          echo '<button class="vn4-btn vn4-btn-blue">Update</button>';
        });
       ?>
      </div>
    @else
    <div class="col-xs-12">
      <h4 style="font-size:18px;text-align: center;">
        <img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}">
        <strong>@__('Theme option not found')<br> 
          <span style="color:#ababab;font-size: 16px;">@__('Seems like no theme options have been created yet.')</span>
        </strong>

      </h4>
    </div>
    @endif
  </div>
</form>
@stop
@section('js')
  <script>
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

    $(document).on('click','.folder',function(event){
      event.stopPropagation();
      $(this).toggleClass('active');
    });

    $(document).on('click','.file_detail',function(){
      event.stopPropagation();
      window.location.href = '?edit='+$(this).data('value');
    });
  </script>
@stop

