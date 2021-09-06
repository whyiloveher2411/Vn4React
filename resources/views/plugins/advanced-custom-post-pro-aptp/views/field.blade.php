<div class="field-item field_type-{!!$field['field_type']!!} {!!isset($active)?$active:''!!}">
    <input type="hidden" name="{!!isset($name_field)?$name_field:'field-key[]'!!}" class="field-key" value="{!!$id_field!!}">
    <div class="field_meta">
        <div class="w25 ensort label_number">
            <span class="circle">{!!$index + 1!!}</span>
        </div>
        <div class="w25 label_label">
             <a href="#" class="not-href toggle-field">{!!$field['title']?$field['title']:'New Field'!!}</a><br>
            <span class="action"><a href="#" class="not-href">Edit</a> | <a href="#" class="not-href">Duplicate</a> | <a href="#" class="not-href">Delete</a></span>
        </div>
        <div class="w25 label_name">
            <span class="name">{!!$field['field_name']!!}</span>
        </div>
        <div class="w25 label_type">
            {!!$field['field_type_title']!!} 
        </div>
      
        <div class="clearfix"></div>
    </div>

    
    <div class="field_form_mask" {!!isset($active)?'':'style="display:none;"'!!}>
       <table class="aptp_input widefat" id="aptp_location">
          <tbody>
            <tr class="field_label">
              <td class="td-label">
                <label for="post_type">Field Label<span class="required">*</span></label>
                <p class="description">
                  This is the name which will appear on the EDIT page
                </p>
              </td>
              <td>
                <input type="text" value="{!!$field['title']!!}" name="fields[{!!$id_field!!}][title]" required="required" class="i-field-label form-control change_name">
              </td>
            </tr>

            <tr class="field_name">
              <td class="td-label">
                <label for="post_type">Field Name<span class="required">*</span></label>
                <p class="description">
                  Single word, no spaces. Underscores and dashes allowed
                </p>
              </td>
              <td>
                <input type="text" value="{!!$field['field_name']!!}" name="fields[{!!$id_field!!}][field_name]" required="required" class="i-field-name form-control change_name">
              </td>
            </tr>

            <tr class="field_type">
              <td class="td-label">
                <label for="post_type">Field Type<span class="required">*</span></label>
              </td>
              <td>
                <input type="hidden" name="fields[{!!$id_field!!}][field_type_title]" class="field_type_title change_name" value="{!!$field['field_type_title']!!}" >

                <select class="form-control i-field-type change_name"  name="fields[{!!$id_field!!}][field_type]" >

                    @foreach($fieldType as $k => $g)
                    <optgroup label="{!!$k!!}">
                        @foreach($g as $k2 => $g2)
                        <option @if( $k2 === $field['field_type']) selected @endif value="{!!$k2!!}">{!!$g2!!}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
              </td>
            </tr>

            <tr class="field_instructions">
                <td class="td-label">
                  <label for="post_type">Field Instructions</label>
                  <p class="description">
                    Instructions for authors. Shown when submitting data
                  </p>
                </td>
                <td>
                  <textarea class="form-control change_name" name="fields[{!!$id_field!!}][field_instructions]">{!!$field['field_instructions']!!}</textarea>
                </td>
            </tr>

            <tr class="field_required">
                <td class="td-label">
                  <label for="post_type">Required?</label>
                </td>
                <td>
                  <label><input type="radio" @if($field['field_required'] === '1') checked="checked" @endif data-checked="1"  name="fields[{!!$id_field!!}][field_required]" value="1" class="change_name">Yes</label>&nbsp;&nbsp;<label><input @if($field['field_required'] === '0') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][field_required]" value="0" class="change_name">No</label>
                </td>
            </tr>
            <?php 
                $list_input_view = [];

                foreach ($fieldTypeAttribute[$field['field_type']] as $key => $value) {
                    if( isset($field[$field['field_type']][$key]) && $field[$field['field_type']][$key] ){
                        $list_input_view[$key] = $field[$field['field_type']][$key];
                    }else{
                        $list_input_view[$key] = $value;
                    }
                }

                $list_input_view['id_field'] = $id_field;
                $list_input_view['index'] = $index;
             ?>
            {!!view_plugin($plugin,'views.field-type.'.$field['field_type'],$list_input_view)!!}

            <tr class="field_save">
              <td class="td-label">
              </td>
              <td>
                <span class="vn4-btn close-field">Close Field</span>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
</div>