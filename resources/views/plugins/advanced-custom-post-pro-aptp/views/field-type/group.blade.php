<tr class="field_option field_option_group">
    <td class="td-label">
      <label for="post_type">Sub Fields</label>
    </td>
    <td>
      <?php 
        echo '<div class="aptp-fields group">';
                    
          vn4_panel('<div class="w25">Field Order</div><div class="w25">Field Label</div><div class="w25">Field Name</div><div class="w25">Field Type</div>',function() use ($sub_fields, $id_field,$__env,$plugin){

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

            $index = 0;
            ?>
              <div class="list-fields">
                  <div class="no_fields_message" @if(!empty($sub_fields)) style="display:none;" @endif>
                      No fields. Click the <strong>+ Add Field</strong> button to create your first field.    
                  </div>
              @if(is_array($sub_fields))
              @foreach( $sub_fields as $field)

                  <?php 

                      $list_id_fields = [];

                      $id_field2 = $id_field.'][group][sub_fields][field_'.str_random(12);

                      while( array_search($id_field2, $list_id_fields) !== false ){
                          $id_field2 = 'field_'.str_random(13);
                      }

                      $list_id_fields[] = $id_field2;

                   ?>
                  {!!view_plugin($plugin,'views.field',['index'=>$index,'name_field'=>'fields['.$id_field.'][group][sub_fields][field-key][]','field'=>$field,'fieldType'=>$fieldType,'fieldTypeAttribute'=>$fieldTypeAttribute,'id_field'=>$id_field2])!!}
                  <?php ++$index; ?>
              @endforeach
              @endif
              
              </div>
              
            <?php

          }, true,null, ['footer'=>function(){
              ?>  
                  <span class="pull-left note-drag"><i class="fa fa-reply icon-drap"></i> Drag and drop to reorder</span>
                  <span class="vn4-btn vn4-btn-blue pull-right btn-add-field sub-fields-group">+ Add Field</span>
                  <div class="clearfix"></div>
              <?php
          }]);

           echo '</div>';
       ?>
    </td>
</tr>
<tr class="field_option field_option_group">
    <td class="td-label">
      <label for="post_type">Layout</label>
    </td>
    <td>
      <label><input type="radio" @if($layout === 'table') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][group][layout]" value="table" class="change_name form-control">Table</label>&nbsp;&nbsp;
      <label><input @if($layout === 'block') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][group][layout]" value="block" class="change_name form-control">Block</label>
    </td>
</tr>
