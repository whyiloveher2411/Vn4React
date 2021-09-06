<tr class="field_option field_option_true_false">
    <td class="td-label">
      <label for="post_type">Message</label>
      <p class="description">
       eg. Show extra content
      </p>
    </td>
    <td>
      <input type="text" name="fields[{!!$id_field!!}][true_false][message]" class="change_name form-control" value="{!!$message!!}" >
    </td>
</tr>


<tr class="field_option field_option_true_false">
    <td class="td-label">
      <label for="post_type">Default Value</label>
    </td>
    <td>
      <input type="checkbox" @if($default_value === '1') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][true_false][default_value]" value="1" class="change_name form-control">
    </td>
</tr>
