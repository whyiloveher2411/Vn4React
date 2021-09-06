<?php

if( !isset($simple) ) $simple = false;

if( !$post && isset($default_value) ) $value = $default_value;

add_load_javascript_unique(asset('admin/tinymce/tinymce.min.js'), 'vn4_footer');
add_load_css_unique(asset('article.css?v=1'),'vn4_head');

if( !isset($templates) ) $templates = null;

add_action('vn4_footer',function() use ($key,$templates,$simple,$__env){
    ?>
    <script>

      $(window).load(function() {

        $(document).on('click', '.warpper-editor .menu-top a:not(.download-image)', function(event) {
          $(this).closest('.warpper-editor').find('.content-visual .tox-tinymce,.editor-content').css({'visibility':'hidden','opacity':'0','z-index':'-1','position':'fixed'});

          if( $(this).hasClass('tab-editor') ){
            $(this).closest('.warpper-editor').find('.'+$(this).attr('data')).css({'visibility':'initial','opacity':'1','z-index':'1','position':'initial','display':'flex'});
          }else{
            $(this).closest('.warpper-editor').find('.'+$(this).attr('data')).css({'visibility':'initial','opacity':'1','z-index':'1','position':'initial','display':'block'});
          }

        });

          $('body').on('click', '.warpper-editor .tab-editor', function(event) {
            event.preventDefault();
            if (typeof tinymce != 'object') {
               return;
            } 

            var $this = $(this), warpper = $this.closest('.warpper-editor');

            if( !warpper.find('textarea').data('change-id') ){
              warpper.find('textarea').attr('id','__change_id_unique_editor_'+ Math.random().toString(36).substr(2, 9)).attr('data-change-id',true);
            }

                tinymce.init({
                      selector: '#'+warpper.find('textarea').attr('id'),
                      auto_resize: true,
                      verify_html : false,
                      init_instance_callback:function(editor){
                          warpper.find('textarea').hide();
                          warpper.find('.mce-tinymce').show();
                          $('#'+editor.id+'_ifr').height(($('#'+editor.id+'_ifr').contents().find('html').height()));
                      },
                      extended_valid_elements: true,
                      fontsize_formats: "8px 10px 12px 14px 16px 18px 24px 36px",
                      setup: function(editor) {
                        
                          editor.on('click',function(e){
                              e.preventDefault();
                              e.stopPropagation();
                          });
                          
                          editor.on('paste',function(e){
                           
                            positionY = $(window).scrollTop();
                            setTimeout(function() {
                              $(window).scrollTop(positionY);
                            }, 0);
                            e.stopPropagation();
                          });

                          editor.on('change', function(e) {
                              editor.save();
                              warpper.find('textarea').val(editor.getContent());
                              warpper.find('.data-visual').html(warpper.find('textarea').val());
                          });

                           editor.on('init', function(args) {
                              tinymce.execCommand('mceFocus',true,'#'+warpper.find('textarea').attr('id')); 
                              warpper.find('iframe html').trigger('click');
                          });

                      },
                      formats:{
                        underline:{inline:'u',exact:true}
                      },

                      @if( !$simple )
                      plugins: [
                        'autoresize advlist imagetools codesample powerpaste wordcount autolink template lists link image charmap print preview anchor codemirror searchreplace visualblocks help insertdatetime media table  responsivefilemanager example '
                      ],
                      codemirror: {
                        indentOnInit: true,
                        path: 'codemirror-4.8',
                        config: {
                          lineNumbers: true       
                        }
                      },
                      <?php  $str_toolbar = 'fontselect |  fontsizeselect | sizeselect | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image responsivefilemanager media | code | removeformat | example '; ?>
                      toolbar: '{!!$str_toolbar!!}',
                      @else
                      menubar: false,
                      plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                      ],
                      toolbar: 'fontselect |  fontsizeselect | sizeselect | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor  | link | removeformat | help',
                      @endif
                      image_caption: true,
                      file_browser_callback_types: 'file image media',
                      automatic_uploads: false,
                      autoresize_on_init: false,
                      @if( isset($templates[0]) )
                        templates: [
                        @foreach($templates as $t)
                          { title: '{!!$t['title']!!}', description: '{!!$t['description']!!}', content: '{!!$t['content']!!}' },
                        @endforeach
                        ],
                      @endif
                      template_cdate_format: '[CDATE: %m/%d/%Y : %H:%M:%S]',
                      template_mdate_format: '[MDATE: %m/%d/%Y : %H:%M:%S]',
                      image_title: true,
                      body_class: 'editor-content',
                      powerpaste_word_import: 'prompt',
                      powerpaste_html_import: 'prompt',
                      content_css : '{!!asset('article.css')!!}',
                      external_filemanager_path:"{!!asset('filemanager/filemanager')!!}/",
                      filemanager_title:"Quản lý file" ,
                      external_plugins: { 
                        "filemanager" : "{!!asset('filemanager/filemanager/plugin.min.js')!!}",
                         "example" : "{!!asset('admin/js/tinymce/plugin/customplugin.js')!!}"
                      },
                      
                });

          });

    
      });

    </script>
    <?php
},$key, true);

?>
<div class="warpper-editor warpper-editor-{!!$key!!} vn4_tabs_top " id="warpper-editor-{!!$key!!}">
  <div class="tag-visual menu-top">
    <a href="#" class="active tab-text" data="data-text">@__('Text')</a>
    <a href="#" class="tab-visual" data="data-visual">@__('Visual')</a>
    <a href="#" class="tab-editor btn_add_editor_{!!$key!!}" data="tox-tinymce">@__('WYSIWYG Editor')</a>&nbsp;
   <label style="margin:0"> <input type="checkbox" name="_download_image_{!!$key!!}" value="1"> Download Image</label>

    <span class="validate-html-w3c vn4-btn vn4-btn-blue" style="position: absolute;right: 20px;height: 29px;line-height: 29px;bottom:0;margin: 0;border-radius: 4px 4px 0 0;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Validate W3C</span>
  </div>
  <div class="content-visual input-editor">
      <div contenteditable="true" class="form-control editor-content data-visual content-visual height_textare_{!!$key!!}" style="background: white;z-index:-1;opacity:0;position:fixed;top:100%;min-height:300px;height:auto;padding: 10px;word-wrap: break-word;" name="{!!isset($name)?$name:$key!!}">
          {!!$value!!}
      </div>
      <style type="text/css">
        .tox-edit-area__iframe{
          height: 100% !important;
        }
        .tox-tinymce{
          background: #fff;
        }
      </style>
      <textarea class="editor-content content-text form-control data-text active"  style="min-height:300px;overflow:auto;z-index:1;width:100%;word-wrap: break-word;height:auto;" name="{!!isset($name)?$name:$key!!}" id="{!!$key!!}">{{$value}}</textarea>
  </div>
</div>


<?php 
add_action('vn4_footer',function(){
  ?>
  <style>
    #popupValidateHtmlW3C{
      padding: 17px !important;margin-top: 30px !important;
    }
    #popupValidateHtmlW3C button.close{
        position: absolute;
        top: 20px;
        right: 20px;
        opacity: 1;
        margin: 0;
        background: #999;
        color: #FFF;
        font-weight: 100;
        width: 30px;
        height: 30px;
        line-height: 0px;
        display: inline-block;
        padding: 0;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
        font-size: 100%;
        margin-top: -35px;
        z-index: 10000;
        margin-right: -35px;
    }
     #popupValidateHtmlW3C button.close:hover{
      background: #5d5d5d;
     }
  </style>
  <div class="modal" id="popupValidateHtmlW3C">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-body" style="margin-top:15px;overflow: auto;">
            <form action="{!!route('admin.page','tool-genaral')!!}" target="iframeValidateHtml" class="form-rel" id="iframeValidateHtmlForm" method="post">
             <input type="hidden" name="_token" value="{!!csrf_token()!!}">
             <input type="hidden" name="is_editor" value="true">
             <input type="hidden" name="key" id="validate_key"  value="">
             <textarea hidden name="code" id="myCode"></textarea>
            </form>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    

    $(window).scroll(function(event) {


      $('.warpper-editor').each(function(index, el) {

          var $warpper = el,subtop = 0,
            $menu_top = $(el).find('.menu-top'),
            $input_editor = $(el).find('.input-editor'),
            $menubar = $(el).find('.tox-menubar'), 
            $toolbar = $(el).find('.tox-toolbar'), 
            $tinymce_editor = $(el).find('.tox-tinymce'),
            width = $warpper.offsetWidth,
            top = $warpper.getBoundingClientRect().top;

            if( $tinymce_editor.css('opacity') == 1 ){
                var dk = top + $warpper.offsetHeight > 200 + $menu_top.height() + $menubar.height() + $toolbar.height(),
                paddingTop = $menu_top.height();
            }else{
                var dk = top + $warpper.offsetHeight > 200 + $menu_top.height(),
                paddingTop = $menu_top.height();
            }


            if( $('body').hasClass('is-iframe') ){
              subtop = 44;
            }


          if( top < ( 44 - subtop ) && dk  ){


              if( $(el).find('.tab-editor').hasClass('active') ){
                $($warpper).css({'padding-top':$toolbar.height() + $menubar.height()});
              }else{
                $($warpper).css({'padding-top':0});
              }

          		$menu_top.css({position:'fixed','z-index':999,top:44 - subtop,width:width,'border-bottom':'1px solid #ccc'});

              $menubar.css({position:'fixed','z-index':1,background:'url("data:image/svg+xml;charset=utf8,%3Csvg height="39px" viewBox="0 0 40 39px" width="40" xmlns="http://www.w3.org/2000/svg"%3E%3Crect x="0" y="38px" width="100" height="1" fill="%23cccccc"/%3E%3C/svg%3E") left 0 top 0 #fff',top:44 - subtop + $menu_top.height(),width:width});
              $toolbar.css({position:'fixed','z-index':1,background:'url("data:image/svg+xml;charset=utf8,%3Csvg height="39px" viewBox="0 0 40 39px" width="40" xmlns="http://www.w3.org/2000/svg"%3E%3Crect x="0" y="38px" width="100" height="1" fill="%23cccccc"/%3E%3C/svg%3E") left 0 top 0 #fff',top:44 - subtop + $menubar.height()+ $menu_top.height(),width:width});

              $input_editor.css({'padding-top':paddingTop});

          }else{

            $($warpper).css({'padding-top':'0'});
            $menu_top.css({position:'relative',top:'initial',width:'initial','border-bottom':'none'});
            $toolbar.css({position:'relative',background:'url("data:image/svg+xml;charset=utf8,%3Csvg height="39px" viewBox="0 0 40 39px" width="40" xmlns="http://www.w3.org/2000/svg"%3E%3Crect x="0" y="38px" width="100" height="1" fill="%23cccccc"/%3E%3C/svg%3E") left 0 top 0 #fff',top:'initial',width:'initial'});
            $menubar.css({position:'relative',background:'url("data:image/svg+xml;charset=utf8,%3Csvg height="39px" viewBox="0 0 40 39px" width="40" xmlns="http://www.w3.org/2000/svg"%3E%3Crect x="0" y="38px" width="100" height="1" fill="%23cccccc"/%3E%3C/svg%3E") left 0 top 0 #fff',top:'initial',width:'initial'});
            $input_editor.css({'padding-top': 'initial'});
          }

      });

    });

    $(window).load(function(){

        $(document).on('click','.data-visual',function(event){
          event.preventDefault();
          event.stopPropagation();
        });

        $(document).on('keyup','.data-visual',function(event) {

            $($(this).parent().find('textarea')).val($(this).html());


            if ( !tinyMCE.get($(this).parent().find('textarea').attr('id')) ) {
                return;
            } 

            tinyMCE.get($(this).parent().find('textarea').attr('id')).setContent($(this).html());

            
        });

       $(document).on('keyup','.warpper-editor textarea',function(event) {
          
          $(this).parent().find('.data-visual').html($(this).val());

          if ( !tinyMCE.get($(this).attr('id')) ) {
              return;
          } 

          tinyMCE.get($(this).attr('id')).setContent($(this).val());

      });
    });

     $(document).on('click','.warpper-editor .validate-html-w3c',function(event) {

          if( $(this).closest('.warpper-editor').find('.mce-tinymce').length < 1 ){
            $(this).closest('.warpper-editor').find('.menu-top>.tab-editor').trigger('click');
          }

          $('#validate_key').val($(this).closest('.warpper-editor').find('textarea').attr('id'));
          $('html').addClass('show-popup');
          $('#myCode').val($(this).closest('.warpper-editor').find('textarea').val());
          $('#iframeValidateHtmlIframe').remove();
          $('#popupValidateHtmlW3C .modal-body').append('<iframe style="width:100%;border:none;height:'+($('#popupValidateHtmlW3C').height() - 120)+'px;" name="iframeValidateHtml" id="iframeValidateHtmlIframe" src="" style="width: 100%;"></iframe>');
          $('#iframeValidateHtmlForm').submit();
          $('#iframeValidateHtmlIframe').load(function(){
            $('#popupValidateHtmlW3C').modal('show');
            $('html').removeClass('show-popup');
          });
    });


    var fit_modal_body;

      fit_modal_body = function(modal) {
        var body, bodypaddings, header, headerheight, height, modalheight;
        header = $("#popupValidateHtmlW3C .modal-header", modal);
        footer = $("#popupValidateHtmlW3C .modal-footer", modal);
        body = $("#popupValidateHtmlW3C .modal-body", modal);
        modalheight = parseInt(modal.css("height"));
        headerheight = parseInt(header.css("height")) + parseInt(header.css("padding-top")) + parseInt(header.css("padding-bottom"));
        footerheight = parseInt(footer.css("height")) + parseInt(footer.css("padding-top")) + parseInt(footer.css("padding-bottom"));
        bodypaddings = parseInt(body.css("padding-top")) + parseInt(body.css("padding-bottom"));
        height = $(window).height() - headerheight - footerheight - bodypaddings - 150;
        $('#iframeValidateHtmlIframe').css('height',$('#popupValidateHtmlW3C').height() - 80);
        $("#popupValidateHtmlW3C .modal-body").css('max-height',$('#popupValidateHtmlW3C').height() - 80 + 'px' );
        return body.css({"max-height": "" + height + "px", 'height':'auto'});
      };

      fit_modal_body($(".modal#popupValidateHtmlW3C "));
      $(window).resize(function() {
        return fit_modal_body($(".modal#popupValidateHtmlW3C "));
      });
  </script>

  <?php
},'popupValidateHtmlW3C',true);
 ?>
