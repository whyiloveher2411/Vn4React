<tr class="field_option field_option_wysiwyg">
    <td class="td-label">
      <label for="post_type">Default Value</label>
      <p class="description">
        Appears when creating a new post
      </p>
    </td>
    <td>
      <textarea name="fields[{!!$id_field!!}][wysiwyg][default_value]" value="{!!$default_value!!}" class="change_name form-control">{!!$default_value!!}</textarea>
    </td>
</tr>
<tr class="field_option field_option_wysiwyg">
    <td class="td-label">
      <label for="post_type">Toolbar</label>
    </td>
    <td>

	<label><input type="radio" @if($toolbar === 'full') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][wysiwyg][toolbar]" value="full"  class="change_name form-control">Full</label>&nbsp;&nbsp;

  	<label><input @if($toolbar === 'basic') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][wysiwyg][toolbar]" value="basic"  class="change_name form-control">Basic</label>

    </td>
</tr>
<tr class="field_option field_option_wysiwyg">
    <td class="td-label">
      <label for="post_type">Show Media Upload Buttons?</label>
    </td>
    <td>
      <label><input type="radio" @if($media === '1') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][wysiwyg][media]" value="1"  class="change_name form-control">Yes</label>&nbsp;&nbsp;

  	<label><input @if($media === '0') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][wysiwyg][media]" value="0" class="change_name form-control">No</label>
    </td>
</tr>