<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Default Value</label>
      <p class="description">
        Appears when creating a new post
      </p>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][text][default_value]" value="{!!$default_value!!}" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Placeholder Text</label>
      <p class="description">
        Appears within the input
      </p>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][text][placeholder]" value="{!!$placeholder!!}" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Prepend</label>
      <p class="description">
        Appears before the input
      </p>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][text][prepend]" value="{!!$prepend!!}" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Append</label>
      <p class="description">
        Appears after the input
      </p>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][text][append]" value="{!!$append!!}" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Formatting</label>
      <p class="description">
        Affects value on front end
      </p>
    </td>
    <td>
      <select class="form-control change_name" name="fields[{!!$id_field!!}][text][formatting]" >
          <option @if($formatting === 'none') selected="selected" @endif value="none">No formatting</option>
          <option @if($formatting === 'html') selected="selected" @endif value="html">Convert HTML into tags</option>
      </select>
    </td>
</tr>


<tr class="field_option field_option_text">
    <td class="td-label">
      <label for="post_type">Character Limit</label>
      <p class="description">
        Leave blank for no limit
      </p>
    </td>
    <td>
      <input type="text"  value="{!!$character_limit!!}" name="fields[{!!$id_field!!}][text][character_limit]" class="form-control change_name">
    </td>
</tr>