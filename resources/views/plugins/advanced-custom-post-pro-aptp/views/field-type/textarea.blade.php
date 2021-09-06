<tr class="field_option field_option_textarea">
    <td class="td-label">
      <label for="post_type">Default Value</label>
      <p class="description">
        Appears when creating a new post
      </p>
    </td>
    <td>
      <textarea class="form-control change_name" name="fields[{!!$id_field!!}][textarea][default_value]" >{!!$default_value!!}</textarea>
    </td>
</tr>
<tr class="field_option field_option_textarea">
    <td class="td-label">
      <label for="post_type">Placeholder Text</label>
      <p class="description">
        Appears within the input
      </p>
    </td>
    <td>
      <input type="text" value="{!!$placeholder!!}" name="fields[{!!$id_field!!}][textarea][placeholder]" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_textarea">
    <td class="td-label">
      <label for="post_type">Character Limit</label>
      <p class="description">
        Leave blank for no limit
      </p>
    </td>
    <td>
      <input type="number" value="{!!$character_limit!!}" name="fields[{!!$id_field!!}][textarea][character_limit]" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_textarea">
    <td class="td-label">
      <label for="post_type">Rows</label>
      <p class="description">
        Sets the textarea height
      </p>
    </td>
    <td>
      <input type="number" value="{!!$rows!!}" value="{!!$rows!!}" name="fields[{!!$id_field!!}][textarea][rows]" class="change_name form-control">
    </td>
</tr>
<tr class="field_option field_option_textarea">
    <td class="td-label">
      <label for="post_type">Formatting</label>
      <p class="description">
        Affects value on front end
      </p>
    </td>
    <td>
      <select class="form-control change_name" name="fields[{!!$id_field!!}][textarea][formatting]" >
          <option @if($formatting === 'none') selected="selected" @endif value="none">No formatting</option>
          <option @if($formatting === 'br') selected="selected" @endif value="br">Convert new lines into &lt;br /&gt; tags</option>
          <option @if($formatting === 'html') selected="selected" @endif value="html">Convert HTML into tags</option>
      </select>
    </td>
</tr>