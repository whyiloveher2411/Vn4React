<?php
$find2 = '';
$class_input = 'col-md-10 col-sm-10 col-xs-12';
if(isset($find)){
  $find2 = $find;
  $class_input = 'col-md-7 col-sm-7 col-xs-12';
}


add_load_javascript_unique(asset('public/admin/tinymce/tinymce.min.js'), 'vn4_footer');
add_load_css_unique(asset('public/admin/tinymce/skins/lightgray/skin.min.css?wp-mce-4310-20160418'),'vn4_head');

add_action('vn4_footer',function() use ($key, $find2){
    ?>
    <script>
        $(window).load(function() {
            window.asset_file_interval = setInterval(function(){ 
                if (typeof tinymce != 'object') {
                   return;
                } 
                var {{$find2.$key}} = tinymce.init({
                    selector: '#{{$find2.$key}}',
                    setup: function(editor) {
                        editor.on('change', function(e) {
                             editor.save();
                        });
                    },
                    plugins: [
                        'responsivefilemanager '
                    ],
                    toolbar: ' responsivefilemanager ',
                    file_browser_callback_types: ' media',
                    automatic_uploads: false,
                    menubar:false,
                    autoresize_on_init: false,
                    code_dialog_height:200,  
 code_dialog_width:300 ,
                    content_css: [
                      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                      '{{asset('public/css/article.css')}}'
                    ],
                    body_class: 'article-content',
                    content_css : '{{asset('public/article.css')}}',
                    external_filemanager_path:"{{asset('filemanager/filemanager')}}/",
                    filemanager_title:"Responsive Filemanager" ,
                    external_plugins: { "filemanager" : "{{asset('filemanager/filemanager/plugin.min.js')}}"}
                });
                clearInterval(asset_file_interval);
            }, 1000);
        });
        

        
    </script>
    <?php
},$find2.$key, true);

?>

<textarea style="width:100%;" name="{{$find2.$key}}" id="{{$find2.$key}}">
    {{$value}}
</textarea>
