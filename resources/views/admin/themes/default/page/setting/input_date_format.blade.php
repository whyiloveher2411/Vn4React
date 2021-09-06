<?php $checked = false; ?>

@foreach($list_option as $k => $v)
<div class="radio">
	<label>
	  <input type="radio" @if($k === $value) <?php $checked = true;  ?> checked @endif name="{!!$key!!}" value="{!!$k!!}">
	  {!!$v!!}
	</label>
</div>
@endforeach
<div class="radio">
    <label>
      <input type="radio" name="{!!$key!!}" id="{!!$key!!}_input_radio_custom" @if(!$checked) checked @endif class="{!!$key!!}_input_custom" value="custom_date" >
      Custom </label> <input type="text" class="form-control input-radio-custom {!!$key!!}_input_custom" id="{!!$key!!}_input_custom" value="{!!$value!!}" name="{!!$key!!}_input_custom"> <span class="{!!$key!!}_result_custom_text">{!!date($value)!!}</span>
  </div>

<?php 
  add_action('vn4_footer',function() use ($key, $value){
    ?>
      <script>
          $(document).ready(function () {

              $(document).on('change','input[type=radio][name={!!$key!!}]:not(.{!!$key!!}_input_custom)',function() {
                    $('.{!!$key!!}_result_custom_text').text($(this).closest('label').text());
                    $('.{!!$key!!}_input_custom').val($(this).val());
              });

              $(document).on('click','#{!!$key!!}_input_custom',function(event) {
                $('#{!!$key!!}_input_radio_custom').prop("checked", true);
              });



              function ajaxGetData(data){
                $.ajax({
                  type: 'POST',
                  dataType: 'Json',
                  data: data,
                  success:function(resutl){
                     $('.{!!$key!!}_result_custom_text').text(resutl.result);
                  }
                });
              }

              $(document).on('focusout','#{!!$key!!}_input_custom',function(event) {
                  ajaxGetData({
                      _token: '{!!csrf_token()!!}',
                      'data': $(this).val(),
                    });
              });


              

          });
      </script>
    <?php 
  });
?>