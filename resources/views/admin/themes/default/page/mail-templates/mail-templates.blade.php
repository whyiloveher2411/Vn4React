@extends(backend_theme('master'))

@section('content')
<?php 
  title_head( __('Mail Templates') );

  $emails = [];

  if( file_exists( $file = cms_path('resource','views/themes/'.theme_name().'/emails/emails.php')) ){
    $emails = include $file;
  }

  if( !empty($emails) ){

  $key = array_keys($emails);

  if( ($email = Request::get('email')) && ( array_search($email, $key) !== false ) ){
    $key = $email;
  }else{
    $key = $key[0]??'';
  }

 ?>
<style type="text/css">
   #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    .change-tab{
      cursor: pointer;
    }
    .change-tab.active{
      font-weight: bold;
    }

    /* width */
    .ace_scrollbar-v::-webkit-scrollbar{
      width: 5px;
    }
    .ace_scrollbar-h{
      right: 0 !important;
    }
    .ace_scrollbar-v{
      bottom: 0 !important;
    }
    .ace_scrollbar-h::-webkit-scrollbar {
      height: 5px;
    }

    /* Track */
    .ace_scrollbar-v::-webkit-scrollbar-track ,.ace_scrollbar-h::-webkit-scrollbar-track {
      background: #f1f1f1; 
      border-radius: 15px;
    }
     
    /* Handle */
    .ace_scrollbar-v::-webkit-scrollbar-thumb, .ace_scrollbar-h::-webkit-scrollbar-thumb {
      background: #888; 
      border-radius: 15px;
    }

    /* Handle on hover */
    .ace_scrollbar-v::-webkit-scrollbar-thumb:hover, .ace_scrollbar-h::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }


</style>

<div class="row">
  <div class="col-xs-12 col-md-3">

    <form id="form-test">
       <div class="form-group">
         <label>
           Selected Template
         </label>
         <select  class="form-control select-template" name="select-template" >
            @foreach($emails as $k => $email) 
            <option @if( $key === $k) selected="selected" @endif value="{!!$k!!}" data-description="{{$email['description']}}">[Theme] {!!$email['title']!!}</option>
            @endforeach
         </select>
       </div>

       <div class="form-group">
         <label>Subject</label>
         <input type="text" name="subject" class="form-control">
       </div>

       <div class="form-group">
         <label style="width: 100%;line-height: 28px;">To <span class="vn4-btn save_email_test_address pull-right" >Save Email</span></label>
         {!!get_field('flexible', [
            'title'=>'Email',
            'key'=>'to',
            'value'=>setting('email_test_address',[]),
            'templates'=>[
                'to'=>[
                  'title'=>'To Email',
                  'items'=>[
                    'name'=>['title'=>'Name'],
                    'email'=>['title'=>'Email']
                  ]
                ],
                'cc'=>[
                  'title'=>'CC Email',
                  'items'=>[
                    'name'=>['title'=>'Name'],
                    'email'=>['title'=>'Email']
                  ]
                ],
                'bcc'=>[
                  'title'=>'BCC Email',
                  'items'=>[
                    'name'=>['title'=>'Name'],
                    'email'=>['title'=>'Email']
                  ]
                ]
            ]
         ])!!}
       </div>
      
       <hr>
        <h4>@__('Parameters')</h4>
       @if( isset($emails[$key]) )
        @foreach($emails[$key]['parameters'] as $k => $field)
          <?php 
              if( !isset($field['view']) ) $field['view'] = 'text';
              if( !isset($field['key']) ) $field['key'] = 'parameters['.$k.']';
              $field['value'] = '';
           ?>
          <div class="form-group">
          <label>
            {!!$field['title']!!}
          </label>
          {!!get_field($field['view'], $field)!!}
          <p class="note">{!!$field['description']!!}</p>
          </div>
        @endforeach
       @endif
     </form>

       <button class="vn4-btn vn4-btn-blue test_email" >Test Email</button>

  </div>


  <div class="col-xs-12 col-md-9">
     <div style="display: flex;flex-wrap: wrap;">

      <p style="width: 100%;line-height: 28px;">
        <span class="change-tab active" data-tab="ace-editor" >EDITOR&nbsp;&nbsp;</span> | 
        <span class="change-tab" data-tab="visual">&nbsp;&nbsp;VISUAL</span> 
        <button class="update_template vn4-btn vn4-btn-blue" style="float: right;">@__('Update')</button>
      </p>

       <div class="col-xs-12 col-md-12 tab  tab-ace-editor" style="position: relative;min-height: 500px;">
          <div id="editor" style="display: none;" class="">{{file_get_contents( cms_path('resource','views/themes/'.theme_name().'/emails/'.$emails[$key]['template'].'.blade.php'))}}</div>
       </div>
       <div class="col-xs-12 col-md-12 tab  tab-visual" style="padding:0;display: none;">
          <iframe src="about:blank" class="" style="width: 100%;border: none;min-height: 500px;">
          </iframe>
       </div>
     </div>
  </div>
</div>

<?php 
}else{
  ?>

  <h4 style="font-size:18px;text-align: center;">
    <img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}">
    <strong>@__('Email template not found.')<br> 
      <span style="color:#ababab;font-size: 16px;">@__('Seems like no email template have been created yet.')</span>
    </strong>
  </h4>

  <?php
}
?>

  
@stop

@section('js')

@if( !empty($emails) )
<link href="{!!asset('')!!}/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="{!!asset('')!!}/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="@asset()vendors/ace/ace.js"></script>
  <script type="text/javascript">

      function formatState (state) {
      if (!state.id) {
        return state.text;
      }
      var $state = $(
        '<span>' + state.text + '</span><p>'+state.element.dataset.description+'</p>'
      );
      return $state;
    };

    $(".select-template").select2({
      templateResult: formatState
    });

    $(document).on('click','.update_template',function(){

        var editor = ace.edit("editor");

        vn4_ajax({
          show_loading: 'Rendering',
          data:{
            content: editor.getValue(),
            update_template: $('.select-template').val()
          },
        });

    });

    $(document).on('click','.save_email_test_address',function(){

        var formdata  = $('#form-test').serializeArray();
        formdata .push({name:'save_email_test_address',value:1 });

        var data = {};
        $(formdata ).each(function(index, obj){
            data[obj.name] = obj.value;
        });

        vn4_ajax({
          data:data,
        });

    });

    $(document).on('click','.test_email',function(){

        var editor = ace.edit("editor");

        var formdata  = $('#form-test').serializeArray();

        formdata .push({name:'content',value:editor.getValue() });
        formdata .push({name:'test_email',value:1 });

        var data = {};
        $(formdata ).each(function(index, obj){
            data[obj.name] = obj.value;
        });

        vn4_ajax({
          show_loading: 'Rendering',
          data:data,
          callback:function(result){
            if( result.content ){
              $('.change-tab').removeClass('active');
              $('.change-tab[data-tab="visual"]').addClass('active');
              $('.tab').hide();
              $('.tab-visual').show();

              let targetFrame = document.querySelector ("iframe[src='about:blank']");
              $(targetFrame.contentDocument.body).css({'margin':0}).html(result.content);
              targetFrame.style.height = (targetFrame.contentWindow.document.body.offsetHeight + 80) + 'px';
            }
          }
        });



    });

    $(document).on('click','.change-tab',function(){

      var $this = $(this);

      if( $this.data('tab') == 'visual' ){

         var editor = ace.edit("editor");

        var formdata  = $('#form-test').serializeArray();

        formdata .push({name:'content',value:editor.getValue() });
        formdata .push({name:'view_visual',value:$('.select-template').val() });

        var data = {};
        $(formdata ).each(function(index, obj){
            data[obj.name] = obj.value;
        });

        vn4_ajax({
          show_loading: 'Rendering',
          data:data,
          callback:function(result){
            $('.change-tab').removeClass('active');
            $this.addClass('active');
            $('.tab').hide();
            $('.tab-'+$this.data('tab')).show();

            let targetFrame = document.querySelector ("iframe[src='about:blank']");

            $(targetFrame.contentDocument.body).css({'margin':0}).html(result.content);

            targetFrame.style.height = (targetFrame.contentWindow.document.body.offsetHeight + 80) + 'px';
          }
        });

      }else{
        $('.change-tab').removeClass('active');
        $this.addClass('active');
        $('.tab').hide();
        $('.tab-'+$this.data('tab')).show();
      }
    });

    $(document).on('change', '.select-template', function(){
      window.location.href = replaceUrlParam(window.location.href, 'email', $(this).val());
    });

    $(window).load(function(){

       var editor = ace.edit("editor");
      editor.setTheme("ace/theme/monokai");
      editor.session.setMode("ace/mode/php");

      setTimeout(function() {
        $('#editor').show();
      },100);
    });
  </script>

@endif

@stop

