<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Sub Fields</label>
    </td>
    <td>
      <?php 
        echo '<div class="aptp-fields">';
                    
          vn4_panel('<div class="w25">Field Order</div><div class="w25">Field Label</div><div class="w25">Field Name</div><div class="w25">Field Type</div>',function() use ($id_field,$__env,$plugin){
            ?>
              <div class="list-fields">
                  <div class="no_fields_message">
                      No fields. Click the <strong>+ Add Field</strong> button to create your first field.    
                  </div>
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
<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Minimum Rows</label>
    </td>
    <td>
      <input type="number" name="fields[{!!$id_field!!}][repeater][minimum_rows]" value="{!!$minimum_rows!!}"  class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Maximum Rows</label>
    </td>
    <td>
      <input type="number" name="fields[{!!$id_field!!}][repeater][maximum_rows]" value="{!!$maximum_rows!!}"  class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_flexible">
    <td class="td-label">
      <label for="post_type">Button Label</label>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][repeater][button_label]" value="{!!$button_label!!}" class="change_name form-control">
    </td>
</tr>