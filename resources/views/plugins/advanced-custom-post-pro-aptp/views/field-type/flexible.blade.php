<?php 
    $fieldTypeAttribute = [
        'text'=>[
            'default_value'=>'',
            'placeholder'=>'',
            'prepend'=>'',
            'append'=>'',
            'formatting'=>'html',
            'character_limit'=>'',
        ],
        'textarea'=>[
            'default_value'=>'',
            'placeholder'=>'',
            'rows'=>8,
            'formatting'=>'html',
            'character_limit'=>'',
        ],
        'number'=>[
            'default_value'=>'',
            'placeholder'=>'',
            'prepend'=>'',
            'append'=>'',
            'minimum_value'=>'',
            'maximum_value'=>'',
            'step_size'=>'',
        ],
        'email'=>[
            'default_value'=>'',
            'placeholder'=>'',
            'prepend'=>'',
            'append'=>'',
        ],
        'password'=>[
            'placeholder'=>'',
            'prepend'=>'',
            'append'=>'',
        ],
        'editor'=>[
            'default_value'=>'',
            'toolbar'=>'full',
            'media'=>'1',
        ],
        'image'=>[
            'width'=>'',
            'height'=>'',
            'min_width'=>'',
            'max_width'=>'',
            'min_height'=>'',
            'max_height'=>'',
            'ratio_width'=>'',
            'ratio_height'=>'',
            'multi_img'=>'0',
        ],
        'asset-file'=>[
        ],
        'select'=>[
            'default_value'=>'',
            'choices'=>'',
            'allow_null'=>'0',
            'multiple'=>'0',
        ],
        'checkbox'=>[
            'default_value'=>'',
            'choices'=>'',
            'layout'=>'vertical'
        ],
        'radio'=>[
            'default_value'=>'',
            'choices'=>'',
            'layout'=>'vertical',
            'other_choice'=>'0',
            'save_other_choice'=>'0',
        ],
        'true_false'=>[
            'default_value'=>'',
            'message'=>'',
        ],
        'relationship_many'=>[
        ],
        'relationships_mm'=>[
            'object_relationship'=>'',
        ],
        'repeater'=>[
            'layout'=>'table',
            'button_label'=>'Add Row',
            'maximum_rows'=>0,
            'minimum_rows'=>0,
            'sub_fields'=>''
        ],
        'flexible'=>[
            'button_label'=>'Add Row',
            'maximum_rows'=>0,
            'minimum_rows'=>0,
            'templates'=>''
        ],
        'link'=>[

        ]
    ];
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
        ]
    ];


?>
@if( is_array($templates) )
@foreach($templates as $k => $t)
<?php 
    $k = $k.'______________str_unique';
 ?>
<tr class="field_option field_option_flexible tr_flexible_template ">
      
    <td class="td-label">
        <label for="post_type">Template</label>
        <span class="action" style="line-height: 20px;font-weight: bold;">
          <a href="#" class="reoder-flexible-template">Reorder</a> <br> <a href="#" class="not-href delete-flexible-template">Delete</a> <br> <a href="#" class="not-href duplicate-flexible-template">Duplicate</a> <br> <a href="#" class="not-href add-flexible-template">Add New</a> </span>
    </td>
    <td class="td-flexible-template" >
        <input type="hidden" class="index_templates" name="fields[{!!$id_field!!}][flexible][index_templates][]" value="{!!$k!!}">
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon"  style=" width: 80px;text-align: left;">Lable</div>
            <input name="fields[{!!$id_field!!}][flexible][templates][{!!$k!!}][title]" value="{!!$t['title']!!}" required="required" type="text" class="form-control col-md-7 col-xs-12 flexible-templates-label">
        </div>
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon" style=" width: 80px;text-align: left;">Name</div>
            <input name="fields[{!!$id_field!!}][flexible][templates][{!!$k!!}][name]" value="{!!$t['name']!!}" required="required" type="text" class="form-control col-md-7 col-xs-12 flexible-templates-name">
        </div>
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon" style=" width: 80px;text-align: left;">Layout</div>
            <select name="fields[{!!$id_field!!}][flexible][templates][{!!$k!!}][layout]" id="" class="form-control col-md-7 col-xs-12">
                <option @if('table' === $t['layout']) selected="selected" @endif  value="table">Table</option>
                <option @if('block' === $t['layout']) selected="block" @endif value="block">Block</option>
            </select>
        </div>


        <?php 
          echo '<div class="aptp-fields ">';
            $fields = $t['items'];

            vn4_panel('<div class="w25">Field Order</div><div class="w25">Field Label</div><div class="w25">Field Name</div><div class="w25">Field Type</div>',function() use ($fieldType , $fieldTypeAttribute , $id_field,$fields, $__env,$plugin, $k){

              $index = 0;
              ?>
                <div class="list-fields">
                    <div class="no_fields_message" @if(!empty($fields)) style="display:none;" @endif>
                        No fields. Click the <strong>+ Add Field</strong> button to create your first field.    
                    </div>

                      @foreach( $fields as $field)

                          <?php 
                              $list_id_fields = [];

                              $id_field2 = $id_field.'][flexible][templates]['.$k.'][field_'.str_random(12);

                              while( array_search($id_field2, $list_id_fields) !== false ){
                                  $id_field2 = 'field_'.str_random(13);
                              }

                              $list_id_fields[] = $id_field2;

                           ?>
                          {!!view_plugin($plugin,'views.field',['index'=>$index,'name_field'=>'fields['.$id_field.'][flexible][templates][field-key][]','field'=>$field,'fieldType'=>$fieldType,'fieldTypeAttribute'=>$fieldTypeAttribute,'id_field'=>$id_field2])!!}
                          <?php ++$index; ?>
                      @endforeach
                    
                <?php
                }, true,null, ['footer'=>function(){
                  ?>  
                      <span class="pull-left note-drag"><i class="fa fa-reply icon-drap"></i> Drag and drop to reorder</span>
                      <span class="vn4-btn vn4-btn-blue pull-right btn-add-field add-template-flexible">+ Add Field</span>
                      <div class="clearfix"></div>
                  <?php
              }]);

             echo '</div>';
         ?>
    </td>
</tr>
@endforeach
@else

<tr class="field_option field_option_flexible tr_flexible_template ">
      
    <td class="td-label">
        <label for="post_type">Template</label>
        <span class="action" style="line-height: 20px;font-weight: bold;">
          <a href="#" class="reoder-flexible-template">Reorder</a> <br> <a href="#" class="not-href delete-flexible-template">Delete</a> <br> <a href="#" class="not-href duplicate-flexible-template">Duplicate</a> <br> <a href="#" class="not-href add-flexible-template">Add New</a> </span>
    </td>
    <td class="td-flexible-template" >
        <input type="hidden" class="index_templates" name="fields[{!!$id_field!!}][flexible][index_templates][]" value="index_1_____str_unique">
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon"  style=" width: 80px;text-align: left;">Lable</div>
            <input name="fields[{!!$id_field!!}][flexible][templates][index_1_____str_unique][title]" value="" required="required" type="text" class="form-control col-md-7 col-xs-12 flexible-templates-label">
        </div>
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon" style=" width: 80px;text-align: left;">Name</div>
            <input name="fields[{!!$id_field!!}][flexible][templates][index_1_____str_unique][name]" value="" required="required" type="text" class="form-control col-md-7 col-xs-12 flexible-templates-name">
        </div>
        <div class="input-group" style="margin-bottom: 10px;">
            <div class="input-group-addon" style=" width: 80px;text-align: left;">Display</div>
            <select name="fields[{!!$id_field!!}][flexible][templates][index_1_____str_unique][layout]" id="" class="form-control col-md-7 col-xs-12">
                <option value="table">Table</option>
                <option value="block">Block</option>
            </select>
        </div>


        <?php 
          echo '<div class="aptp-fields ">';
            vn4_panel('<div class="w25">Field Order</div><div class="w25">Field Label</div><div class="w25">Field Name</div><div class="w25">Field Type</div>',function(){
              ?>
                <div class="list-fields">
                    <div class="no_fields_message">
                        No fields. Click the <strong>+ Add Field</strong> button to create your first field.    
                    </div>
                <?php
                }, true,null, ['footer'=>function(){
                  ?>  
                      <span class="pull-left note-drag"><i class="fa fa-reply icon-drap"></i> Drag and drop to reorder</span>
                      <span class="vn4-btn vn4-btn-blue pull-right btn-add-field add-template-flexible">+ Add Field</span>
                      <div class="clearfix"></div>
                  <?php
              }]);
             echo '</div>';
         ?>
    </td>
</tr>

@endif

<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Button Label</label>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][flexible][button_label]" value="{!!$button_label!!}" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Minimum Rows</label>
    </td>
    <td>
      <input type="number" name="fields[{!!$id_field!!}][flexible][minimum_rows]" value="{!!$minimum_rows!!}"  class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Maximum Rows</label>
    </td>
    <td>
      <input type="number" name="fields[{!!$id_field!!}][flexible][maximum_rows]" value="{!!$maximum_rows!!}"  class="change_name form-control">
    </td>
</tr>

