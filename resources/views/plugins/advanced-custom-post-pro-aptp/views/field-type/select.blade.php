<tr class="field_option field_option_select">
    <td class="td-label">
      <label for="post_type">Choices</label>
      <p class="description">
       Enter each choice on a new line. <br>
       For more control, you may specify both a value and label like this: <br>
       red : Red <br> blue : Blue
      </p>
    </td>
    <td>
      <?php 

        if( $choices !== '' ){

          $list_option = explode("\n", $choices);

          $choices = '';

          foreach($list_option as $option){
            $option = explode(':', $option);
            if( isset($option[1]) ) $choices .= trim($option[0]).' : '.trim($option[1])."\n"; 
            else $choices .= trim($option[0]).' : '. trim($option[0])."\n";
          }

          $choices = substr($choices, 0, -1);

        }

       ?>
      <textarea name="fields[{!!$id_field!!}][select][choices]" class="change_name form-control" rows="6">{!!$choices!!}</textarea>
    </td>
</tr>
<tr class="field_option field_option_select">
    <td class="td-label">
      <label for="post_type">Default Value</label>
      <p class="description">
       Enter each default value on a new line
      </p>
    </td>
    <td>
      <textarea name="fields[{!!$id_field!!}][select][default_value]" class="change_name form-control" rows="6">{!!$default_value!!}</textarea>
    </td>
</tr>

<tr class="field_option field_option_select">
    <td class="td-label">
      <label for="post_type">Allow Null?</label>
    </td>
    <td>
      <label><input type="radio" @if($allow_null === '1') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][select][allow_null]" value="1" class="change_name form-control">Yes</label>&nbsp;&nbsp;
      <label><input @if($allow_null === '0') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][select][allow_null]" value="0" class="change_name form-control">No</label>
    </td>
</tr>
<tr class="field_option field_option_select">
    <td class="td-label">
      <label for="post_type">Select multiple values?</label>
    </td>
    <td>

      <label><input type="radio" @if($multiple === '1') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][select][multiple]" value="1" class="change_name form-control">Yes</label>&nbsp;&nbsp;
      <label><input @if($multiple === '0') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][select][multiple]" value="0" class="change_name form-control">No</label>

    </td>
</tr>