<tr class="field_option field_option_image">
    <td class="td-label">
      <label for="post_type">Size</label>
      <p class="description">
        Request the size of the image
      </p>
    </td>
    <td>

    	<table>
    		<tr style="border-bottom: none;">
    			<td><div class="col-md-12">Width:<input type="number" name="fields[{!!$id_field!!}][image][width]" value="{!!$width!!}" class="change_name form-control"></div></td>
    			<td><div class="col-md-12">Height:<input type="number" name="fields[{!!$id_field!!}][image][height]" value="{!!$height!!}" class="change_name form-control"></div></td>
    		</tr>
    		<tr style="border-bottom: none;">
    			<td><div class="col-md-12">Min Width:<input type="number" name="fields[{!!$id_field!!}][image][min_width]" value="{!!$min_width!!}" class="change_name form-control"></div></td>
    			<td><div class="col-md-12">Min Height:<input type="number" name="fields[{!!$id_field!!}][image][min_height]" value="{!!$min_height!!}" class="change_name form-control"></div></td>
    		</tr>
    		<tr style="border-bottom: none;">
    			<td><div class="col-md-12">Max Width:<input type="number" name="fields[{!!$id_field!!}][image][max_width]" value="{!!$max_width!!}" class="change_name form-control"></div></td>
    			<td><div class="col-md-12">Max Height:<input type="number" name="fields[{!!$id_field!!}][image][max_height]" value="{!!$max_height!!}" class="change_name form-control"></div></td>
    		</tr>
    	</table>
    </td>
</tr>
<tr class="field_option field_option_image">
    <td class="td-label">
      <label for="post_type">Ratio</label>
      <p class="description">
      </p>
    </td>
    <td>
    	<table>
    		<tr style="border-bottom: none;">
    			<td><div class="col-md-12">Width:<input type="number" name="fields[{!!$id_field!!}][image][ratio_width]" value="{!!$ratio_width!!}" class="change_name form-control"></div></td>
    			<td><div class="col-md-12">Height:<input type="number" name="fields[{!!$id_field!!}][image][ratio_height]" value="{!!$ratio_height!!}" class="change_name form-control"></div></td>
    		</tr>
    	</table>
    </td>
</tr>

<tr class="field_option field_option_image">
    <td class="td-label">
      <label for="post_type">Quantity</label>
    </td>
    <td>
		 <label><input type="radio" @if($multi_img === '0') checked="checked" data-checked="1" @endif  name="fields[{!!$id_field!!}][image][multi_img]" value="0" class="change_name form-control">Only One</label>&nbsp;&nbsp;
    	<label><input @if($multi_img === '1') checked="checked" data-checked="1" @endif type="radio" name="fields[{!!$id_field!!}][image][multi_img]" value="1" class="change_name form-control">Multi</label>
  	
    </td>
</tr>