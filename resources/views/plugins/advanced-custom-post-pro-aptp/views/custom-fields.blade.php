@extends(backend_theme('master'))

<?php 
    $post_type = 'ace_custom_fields';

    $get_admin_object = get_admin_object();

    $postTypeConfig = $get_admin_object[$post_type];

    $post_id = Request::get('post',0);
    $action_post = Request::get('action_post','add');

    $post =  Vn4Model::firstOrAddnew($postTypeConfig['table'], [Vn4Model::$id=>$post_id]);

    if( $post->exists ){
        title_head('Edit Custom Fields');
        $hasPost = true;
        $action_post = 'edit';
    } else{
        title_head('Add New Custom Fields');
        $hasPost = false;
        $action_post = 'add';
    }

    add_action('vn4_heading',function(){
        echo '<a href="'.route('admin.aptp.update').'" class="pull-left vn4-btn-white"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>';
    });

    include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/variable.php');

    $fieldType = [
        'Basic'=>[
            'text'=>'Text',
            'textarea'=>'Text Area',
            'number'=>'Number',
            'email'=>'Email',
            'password'=>'Password',
            'link'=>'Link',
        ],
        'Content'=>[
            'editor'=>'Wysiwyg Editor',
            'image'=>'Image',
            'asset-file'=>'File',
        ],
        'Choice'=>[
            'select'=>'Select',
            'checkbox'=>'Checkbox',
            'radio'=>'Radio Button',
            'true_false'=>'True / False',
        ],
        'Relationship'=>[
            'relationship_many'=>'Relationship many',
            'relationships_mm'=>'Relationship one',
        ],
        'Layout'=>[
            'repeater'=>'Repeater',
            'flexible'=>'Flexible Content',
            'tab'=>'Tab',
            'group'=>'Group',
        ]

    ];
 
    $list_id_fields = [];

    $id_field_first = 'field_'.str_random(13);

    $list_id_fields[] = $id_field_first;

?>
@section('css')
  <style type="text/css">
        .description{
            display: block;
            font-size: 12px;
            line-height: 1.4em;
            padding: 0 !important;
            margin: 3px 0 0 !important;
            font-style: normal;
            line-height: 16px;
            color: #899194
        }
        .aptp-content .x_content{
            padding: 0;
        }
        .aptp-content table{
            width: 100%;
        }
        table.aptp_input tbody tr td.td-label{
            width: 24%;
            vertical-align: top;
            background: #F9F9F9;
            border-right: 1px solid #E1E1E1;
        }
        table.aptp_input>tbody>tr>td{
            padding: 13px 15px;
        }
        #aptp_location .location-group table tbody tr td{
            padding: 4px;
        }
        .td-label label{
            display: block;
            font-size: 13px;
            line-height: 1.4em;
            font-weight: bold;
            padding: 0;
            margin: 0 0 3px;
            color: #333;
        }
        .aptp_input h4{
            color: #7d7d7d;
            font-size: 1em;
            margin: 0 0 4px 0;
            font-weight: bold;
        }
        .list-fields .field-item .field_form{}
        .w25{display: inline-block;width: 25%;font-weight: bold;float: left;}
        .w12{display: inline-block;width: 12.5%;font-weight: bold;float: left;}
        .location-group .param{width: 40%;}
        .location-group .operator{width: 20%;}
        .location-group .add{width: 40px;}
        .location-group .remove{width: 32px;}
        .circle{font-weight:bold;border-radius: 50%;border: 1px solid #BBBBBB;font-size: 12px;display:inline-block;height: 23px;width: 23px;text-align: center;line-height: 22px;}
        .aptp-content .icon-drap{
            -ms-transform: rotate(90deg)  rotateX(180deg); /* IE 9 */
            -webkit-transform: rotate(90deg)  rotateX(180deg); /* Safari 3-8 */
            transform: rotate(90deg) rotateX(180deg);
            font-size: 20px;
        }
        .aptp-content .x_footer{
            background: #EAF2FA;
        }
        .aptp-content .note-drag{
            color: #8196c1;
        }
        .field-item{border-bottom: 1px solid #F0F0F0;background: white;}
        .field-item .field_form_mask{border-top: 1px solid #F0F0F0;}
        .field-item.active>.field_meta{background: #3595BC;
            background-image: -webkit-gradient(linear, left top, left bottom, from(#46AFDB), to(#3199C5));
            background-image: -webkit-linear-gradient(top, #46AFDB, #3199C5);
            background-image: -moz-linear-gradient(top, #46AFDB, #3199C5);
            background-image: -o-linear-gradient(top, #46AFDB, #3199C5);
            background-image: linear-gradient(to bottom, #46AFDB, #3199C5);
            color: white;
        }
        .field_meta .w25, .field_meta .w12{padding:10px;}
        .field_meta .w25.ensort{cursor: move;}
        .toggle-field{
            font-weight: bold;
            font-size: 14px;
        }
        .x_title{
            z-index: inherit;
        }
        .field-item.active>.field_meta .toggle-field{
            color: white;
        }
        .field-item.active>.field_meta .circle{
            border-color: white;
        }
        .list-fields .field_form_mask tr:not(:last-child){
            border-bottom: 1px solid #E1E1E1;
        }
        span.required{
            color: #f00;
            display: inline;
            font-weight: bold;
            margin-left: 2px;
        }
        .ui-sortable-helper{
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);border: 1px solid #F0F0F0;
        }
        .ui-sortable-placeholder{
            visibility: visible !important;
            background: #F9F9F9;
            border: #DFDFDF solid 1px;
            border-bottom-color: #F0F0F0;
            border-top: 0 none;
        }
        .aptp-fields .x_title{padding: 0;}
        .aptp-fields .x_title .w25{padding: 10px;}
        .location-group .remove .circle{cursor: pointer;display: none;}
        .location-group .remove .circle:hover i{color: #d30e16;}
        .location-group tr:hover .remove .circle{display: inline-block;}
        .no_fields_message{padding: 15px 10px;background: #FCFCFC;}
        .label_label .action{opacity: 0;visibility: hidden;cursor: pointer;font-size: 12px;color: #0073aa;font-weight: normal;line-height: 18px;}
        .label_label:hover .action{opacity: 1;visibility: inherit;}
        .label_label .action a:hover{color: #00a0d2;}
        .field-item.active>.field_meta .label_label .action, .field-item.active>.field_meta .label_label .action a,.field-item.active>.field_meta .label_label .action a:hover {color: white;}
        .aptp-fields.repeater .label_label .action{line-height: 18.5px;}
        .warpper-flexible-templates table.table-flexible-templates:not(:last-child){border-bottom: 1px solid #E1E1E1;}
        .warpper-flexible-templates table.table-flexible-templates{background: white;}
        .ui-sortable-placeholder.table-flexible-templates{background: #F9F9F9 !important;}
        .field_type-tab .field_name, .field_type-tab .field_instructions, .field_type-tab .field_required{display: none;}
        .field_type-tab{margin-top: 15px;}
        .x_content{background: white;}
        .x_panel,.aptp-fields>.x_panel>.x_content{background: transparent;}
        .x_title {background: white;}
  </style>
@stop
@section('content')


  <div class="create_data">
      <form class="form-horizontal form-label-left input_mask" id="form_create" method="POST">
        {!!duplicate_submission()!!}
        <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
        <div class="row">
          <div class="col-md-9 col-xs-12 column-left">
              <input type="text" class="form-control" name="title" required="required" value="{!!$post->title!!}" placeholder="Enter title here" style="font-size: 24px;">
              <br>
              <div class="aptp-content">
              <?php 
                vn4_panel('Location',function() use ($get_admin_object, $__env, $post_type,$post,$plugin ){
                  ?>
                    <table class="aptp_input widefat" id="aptp_location">
                      <tbody>
                        <tr>
                          <td class="td-label">
                            <label for="post_type">Rules</label>
                            <p class="description">
                              Create a set of rules to determine which edit screens will use these advanced custom fields
                            </p>
                          </td>
                          <td>
                            <div class="location-groups">
                            <h4>Show this field group if</h4>
                                <?php 
                                    $location = json_decode($post->location,true);

                                    if( !$location ) $location = [];

                                    $index1 = 0;
                                    // dd($location);
                                 ?>

                                @forElse($location as $group)
                                <?php $index2 = 0; ?>
                              <div class="location-group">
                                    <table>
                                        <tbody>

                                            @foreach( $group as $g)
                                                {!!view_plugin($plugin,'views.location',['index1'=>$index1,'index2'=>$index2,'g'=>$g,'get_admin_object'=>$get_admin_object])!!}
                                                <?php ++$index2; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4>or</h4>
                              </div>
                                <?php ++$index1; ?>
                              @empty
                              <div class="location-group">
                                    <table>
                                        <tbody>
                                            {!!view_plugin($plugin,'views.location',['index1'=>0,'index2'=>0,'g'=>['param'=>'post-type','operator'=>'==','value'=>''],'get_admin_object'=>$get_admin_object])!!}
                                        </tbody>
                                    </table>
                                    <h4>or</h4>
                              </div>
                              @endforelse
                              <span class="vn4-btn btn-add-rule-group">Add rule group</span>
                            </div>  
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  <?php

                }, true);
                
                echo '<div class="aptp-fields">';

                vn4_panel('<div class="w25">Field Order</div><div class="w25">Field Label</div><div class="w25">Field Name</div><div class="w25">Field Type</div>',function() use ($get_admin_object, $__env, $post_type, $plugin, $post, $fieldType, $fieldTypeAttribute,$list_id_fields  ){
                  ?>
                    <div class="list-fields">

                        <?php 
                            $fields = json_decode($post->fields,true);
                            if( !$fields ) $fields = [];
                            $index = 0;
                         ?>
                        
                        <div class="no_fields_message" @if(!empty($fields)) style="display:none;" @endif>
                            No fields. Click the <strong>+ Add Field</strong> button to create your first field.    
                        </div>


                        
                         @foreach( $fields as $field)
                            <?php 

                                $id_field = 'field_'.str_random(13);

                                while( array_search($id_field, $list_id_fields) !== false ){
                                    $id_field = 'field_'.str_random(13);
                                }

                                $list_id_fields[] = $id_field;

                             ?>
                            {!!view_plugin($plugin,'views.field',['index'=>$index,'field'=>$field,'fieldType'=>$fieldType,'fieldTypeAttribute'=>$fieldTypeAttribute,'id_field'=>$id_field])!!}
                            <?php ++$index; ?>
                        @endforeach
                    </div>  
                  <?php

                }, true,null, ['footer'=>function(){
                    ?>  
                        <span class="pull-left note-drag"><i class="fa fa-reply icon-drap"></i> Drag and drop to reorder</span>
                        <span class="vn4-btn vn4-btn-blue pull-right btn-add-field">+ Add Field</span>
                        <div class="clearfix"></div>
                    <?php
                }]);

                 echo '</div>';

               ?>
               </div>
         
          </div>
          <div class="col-md-3 col-xs-12">

            @include( backend_theme('post-type.input-status'),['published_on'=>false,'visibility'=>false])

          </div>
                
        </div>

      </form>

  </div>

@stop


@section('js')
    <script id="location-item-tempate" type="text/template">
        {!!view_plugin($plugin,'views.location',['index1'=>0,'index2'=>0,'g'=>['param'=>'post-type','operator'=>'==','value'=>''],'get_admin_object'=>$get_admin_object])!!}
    </script>
    <script id="field-item-defautl" type="text/template">
        {!!view_plugin($plugin,'views.field',['index'=>0,'field'=>array_merge(['field_type_title'=>'Text','title'=>'','field_name'=>'','field_type'=>'text','field_instructions'=>'','field_required'=>1,'text'=>$fieldTypeAttribute['text']]),'fieldType'=>$fieldType,'fieldTypeAttribute'=>$fieldTypeAttribute,'active'=>'active','id_field'=>$id_field_first])!!}
    </script>
    
    <script>
        $(document).ready(function($) {

            var script = document.createElement('script');
            script.onload = function () {
               $( ".list-fields" ).sortable({
                    handle:'>.field_meta>.ensort',
                    start:function(event,ui){
                    },
                    stop:function(event, ui){
                    },
                    update: function(event, ui) {
                        udpateNumberField();
                    },
                    create:function(event, ui){
                        
                    }

              });
            };

            

            script.src = "{!!asset('admin/js/jquery-ui.min.js')!!}";

            document.head.appendChild(script);

            $(document).on('click','.toggle-field',function(){

                var $parent = $(this).closest('.field-item');

                $parent.toggleClass('active');

                if( $parent.hasClass('active') ){
                    $parent.find('>.field_form_mask').slideDown(200);
                }else{
                    $parent.find('>.field_form_mask').slideUp(200);
                }

            });


            $(document).on('click','input[type=radio]',function(){
                $('input[type=radio][name="'+$(this).attr('name')+'"]').attr('data-checked','0');
                $(this).attr('data-checked','1');
            });

            $(document).on('keyup','.i-field-label',function(){

                $(this).closest('.field-item').find('.toggle-field:first').text($(this).val());

            });

             $(document).on('change','.i-field-label',function(){
                $(this).closest('.field-item').find('.i-field-name:first').val(str_slug($(this).val())).trigger('change');
             });

            function str_slug(title){
                
                var slug;

                slug = title.toLowerCase();

                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                slug = slug.replace(/\`|\~|\!|\@|\-|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;/gi, '_');
                slug = slug.replace(/ /gi, "-");
                slug = slug.replace(/\-\-\-\-\-/gi, '_');
                slug = slug.replace(/\-\-\-\-/gi, '_');
                slug = slug.replace(/\-\-\-/gi, '_');
                slug = slug.replace(/\-\-/gi, '_');
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                return slug;
            }

            $(document).on('keyup','.i-field-name',function(){

                $(this).closest('.field-item').find('>.field_meta>.w25.label_name').text($(this).val());

            });

            $(document).on('change','.i-field-name',function(){

                var value = str_slug($(this).val());
                $this = $(this);

                $(this).closest('.list-fields').find('>.field-item>.field_form_mask>.aptp_input>tbody>.field_name>td>.i-field-name').not(this).each(function(index, el) {
                    if( $(el).val() == value ){
                        value = $(this).val()+'_'+makeid();
                    }                        
                });

                $(this).val(value);

                $(this).closest('.field-item').find('>.field_meta>.label_name').text($(this).val());

            });

            $(document).on('click', '.btn-add-location', function(event) {
                event.preventDefault();

                $($('#location-item-tempate').html()).insertAfter($(this).closest('tr'));

                updateNameGroupRule();

            });

            $(document).on('click', '.btn-add-rule-group', function(event) {
                event.preventDefault();
                $('<div class="location-group"><table><tbody>'+$('#location-item-tempate').html()+'</tbody></table><h4>or</h4></div>').insertBefore($(this));

                updateNameGroupRule();

            });

            $(document).on('click', '.remove .circle', function(event) {
                event.preventDefault();

                var group = $(this).closest('.location-group');

                if( group.find('tr').length > 1){
                    $(this).closest('tr').remove();
                }else{
                    group.remove();
                }

                updateNameGroupRule();
                
            });

            window.___list_id = [];

            function makeid() {
              var text = "";
              var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

              for (var i = 0; i < 14; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

                if( ___list_id.indexOf(text) !== -1 ){
                    return makeid();
                } 
                ___list_id.push(text);

              return text;
            }



            $(document).on('click', '.btn-add-field', function(event) {


                event.preventDefault();

                var $this = $(this),id = 'field_'+makeid();

                while( $('.field-key[value='+id+']').length > 0 ){
                    id = 'field_'+makeid();
                }

                if( $this.hasClass('sub-fields-group') ){

                    var idParent = $this.closest('.aptp-fields').closest('.field-item').find('>.field-key:first').val();

                    var element = $($('#field-item-defautl').html().replace(/{!!$id_field_first!!}/g, idParent + '][group][sub_fields]['+id ));

                    element.find('.field-key').attr('name','fields['+idParent+'][group][sub_fields][field-key][]');

                    $this.closest('.x_panel').find('.list-fields').append(element);

                }else if( $this.hasClass('sub-fields-repeater') ){
                    var idParent = $this.closest('.aptp-fields').closest('.field-item').find('>.field-key:first').val();

                    var element = $($('#field-item-defautl').html().replace(/{!!$id_field_first!!}/g, idParent + '][repeater][sub_fields]['+id ));

                    element.find('.field-key').attr('name','fields['+idParent+'][repeater][sub_fields][field-key][]');

                    $this.closest('.x_panel').find('.list-fields').append(element);

                }else if( $this.hasClass('add-template-flexible') ){

                    var idParent = $this.closest('.aptp-fields').closest('.field-item').find('>.field-key:first').val();
                    var index_template = $(this).closest('.td-flexible-template').find('>.index_templates').val();

                    var element = $($('#field-item-defautl').html().replace(/{!!$id_field_first!!}/g, idParent + '][flexible][templates]['+index_template+']['+id ));

                    $this.closest('.x_panel').find('>.x_content>.list-fields').append(element);

                }else{
                    var element = $('#field-item-defautl').html().replace(/{!!$id_field_first!!}/g, id );

                    $this.closest('.x_panel').find('>.x_content>.list-fields').append(element);
                }
                    


                udpateNumberField();
            });

            $(document).on('click','.delete-flexible-template',function(event){

                if( $(this).closest('table').find('>tbody>tr.tr_flexible_template').length > 1 ){
                    $(this).closest('tr').remove();
                }

            });

            $('body').on('click','.duplicate-flexible-template',function(event){

                var idNew = makeid(),idOld = $(this).closest('tr').find('.index_templates').val();

                var element = $(this).closest('tr').clone();

                if( element.find('.flexible-templates-name').attr('value') ){
                    element.find('.flexible-templates-name').attr('value',element.find('.flexible-templates-name').val()+'_'+makeid());
                }
                element.find('.index_templates').val(idNew);

                element = element.closest('tr')[0].outerHTML;

                element = element.replace(new RegExp(idOld, "g"), idNew);

                $(element).insertAfter($(this).closest('tr'));

                $(this).closest('.field-item').find('input[type=radio]').each(function(index2, el2){

                    if( $(el2).attr('data-checked') === '1' ){
                        $(el2).prop('checked',true);
                    }else{
                        $(el2).prop('checked',false);
                    }
                });
            });


            $('body').on('click','.add-flexible-template',function(event){
                
                var idNew = makeid(),idOld = $(this).closest('tr').find('.index_templates').val();
                var element = $(this).closest('tr').clone();

               element.find('input,textarea').val('').attr('value','');
               element.find('.field-item').remove();
               element.find('.no_fields_message').show();
               element.find('.index_templates').val(idNew);

               element = element[0].outerHTML;
               element = element.replace(new RegExp(idOld, "g"), idNew);

                $(element).insertAfter($(this).closest('tr'));

                $(this).closest('.field-item').find('input[type=radio]').each(function(index2, el2){

                    if( $(el2).attr('data-checked') === '1' ){
                        $(el2).prop('checked',true);
                    }else{
                        $(el2).prop('checked',false);
                    }
                });

            });
            
            $(document).on('change','.flexible-templates-label',function(event){
                var name = str_slug($(this).val());

                if( name === '' ) return;


                $(this).closest('td').find('>.input-group>.flexible-templates-name').val(name).trigger('change');
            });

            $(document).on('change','.flexible-templates-name',function(event){

                var name = str_slug($(this).val());
                while( $(this).closest('table').find('.flexible-templates-name[value='+name+']').not(this).length > 0 ){
                    name = str_slug($(this).val())+'_'+makeid(10);
                }

                $(this).val(name);
            });


            $(document).on('change','input:not([type=radio]):not([type=checkbox])',function(){
                $(this).attr('value',$(this).val());
            });

            $(document).on('change','textarea',function(){
                $(this).attr('value',$(this).val());
            });

            $(document).on('click','.close-field',function(){
                $(this).closest('.field-item').find('.toggle-field').trigger('click');
            });

            $(document).on('click', '.label_label>.action>a:nth-child(1)', function(event) {
                event.preventDefault();
                $(this).closest('.label_label').find('.toggle-field').trigger('click');
            });

            $(document).on('click', '.label_label>.action>a:nth-child(2)', function(event) {
                event.preventDefault();

                var id = 'field_'+makeid();

                while( $('.field-key[value='+id+']').length > 0 ){
                    id = 'field_'+makeid();
                }

                var element = $(this).closest('.field-item'),idOld = element.find('>.field-key').val();


               idOld = idOld.replace(/\[/g, '\\[').replace(/\]/g, '\\]');

               var idOld = idOld.split("[");
               idOld = idOld[idOld.length - 1];

                element = element[0].outerHTML.replace(new RegExp(idOld, "g"), id );

                $(element).insertAfter($(this).closest('.field-item'));

                udpateNumberField();
            });

            $(document).on('click', '.label_label>.action>a:nth-child(3)', function(event) {
                event.preventDefault();
                $(this).closest('.field-item').remove();
                udpateNumberField();
            });

          


            function updateNameGroupRule(){

                $('.location-groups .location-group').each(function(index, el) {
                    $(el).find('tr').each(function(index2, el2) {
                        $(el2).find('.select-param').attr('name','location['+index+']['+index2+'][param]');
                        $(el2).find('.select-operator').attr('name','location['+index+']['+index2+'][operator]');
                        $(el2).find('.select-value').attr('name','location['+index+']['+index2+'][value]');
                    });
                }); 

            }


            function udpateNumberField(){

                $('.aptp-fields').each(function(index, el) {

                    var $this = $(el);

                    if( $this.find('>.x_panel>.x_content>.list-fields>.field-item').length < 1){
                        $this.find('>.x_panel>.x_content>.list-fields>.no_fields_message').show();
                    }else{
                        $this.find('>.x_panel>.x_content>.list-fields>.no_fields_message').hide();

                        $this.find('>.x_panel>.x_content>.list-fields>.field-item').each(function(index, el2) {

                            $(el2).find('>.field_meta>.ensort>.circle').text(index + 1);

                        });
                    }
                });
                
                $( ".list-fields" ).sortable({

                    handle:'>.field_meta>.ensort',
                    start:function(event,ui){
                    },
                    stop:function(event, ui){
                    },
                    update: function(event, ui) {
                        udpateNumberField();
                    },
                    create:function(event, ui){
                    }
                  });

                
            }

            $(document).on('change','.select-param',function(){
                var type = $(this).find('option:checked').data('type'),selectValue = $(this).closest('tr').find('.select-value');
                    data = $(this).find('option:checked').data();
                    data.action = 'get-value-rule';

                
                selectValue.empty();

                vn4_ajax({
                    data:data,
                    callback:function(result){
                        for( var i = 0; i < result.data.length ; i ++){
                            selectValue.append('<option value="'+result.data[i].id+'">'+result.data[i].title+'</option>');
                        }
                    }
                });
            });

            $(document).on('change','.i-field-type',function(){

                show_loading('@__p('Loading View',$plugin->key_word)');

                $(this).find('option[selected]').removeAttr('selected');
                $(this).find('option:checked').attr('selected','selected');
                $(this).closest('.field-item').find('.field_meta .w25:nth-child(4)').text($(this).find('option:checked').text());
                $(this).closest('td').find('.field_type_title').val($(this).find('option:checked').text());

                var $tbody = $(this).closest('tbody');

                $tbody.find('.field_option').hide();

                $(this).closest('.field-item').attr('class','field-item active field_type-'+$(this).val());
                
                if( $tbody.find('.field_option.field_option_'+$(this).val()).length > 0 ){
                  $tbody.find('.field_option.field_option_'+$(this).val()).show();
                  hide_loading();
                }else{
                  vn4_ajax({
                    type:'POST',
                    dataType:'html',
                    data:{
                      'field-type':$(this).val(),
                      'action':'get-field',
                      'index': $('.field-item').index($(this).closest('.field-item')),
                      'field-key': $(this).closest('.field-item').find('>.field-key:first').val(),
                    },
                    callback:function(html){
                        $(html).insertBefore($tbody.find('.field_save'));
                        hide_loading();
                    }
                  });
                }

            });

        });
    </script>

 

@stop

