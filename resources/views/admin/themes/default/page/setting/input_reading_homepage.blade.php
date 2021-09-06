<?php
  
  if( !isset($name) ){
    $name = $key;
  }

  if( is_string($value) ) $value = json_decode($value,true);

  if( !is_array($value) ){
    $value = [];
  }

  if( !isset($value['type']) ){
    $value['type'] = 'default';
  }

  $admin_object = get_admin_object();

  if( !isset($value['post-type']) ){
    $value['post-type'] = key($admin_object);
  }

  if( !isset($value['post-id']) ){
    $value['post-id'] = 0;
  }

  if( !isset($value['static-page']) ){
    $value['static-page'] = 'none';
  }

  if( $value['type'] === 'custom' && !$page = get_post($value['post-type'],$value['post-id']) ){
    $value['type'] = 'default';
  }

  if( $value['type'] === 'static-page' && !file_exists(cms_path('resource').'views/themes/'.theme_name().'/page/'.$value['static-page'].'.blade.php') ){
    $value['type'] = 'default';
  }
 ?>

<div class="radio">
	<label>
	  <input type="radio" name="{!!$name!!}[type]" @if( $value['type'] === 'default' ) checked="checked" @endif class="type-reading" value="default">
	  Default
	</label>
</div>

<div class="radio">
  <label>
    <input type="radio" name="{!!$name!!}[type]" @if( $value['type'] === 'static-page' ) checked="checked" @endif class="type-reading" value="static-page">
    A static page <select name="{!!$key!!}[static-page]" class="form-control" style="display: inline;width: auto;max-width: 100%;" >
        <?php 
          $file_page =  file_exists(cms_path('resource').'views/themes/'.theme_name().'/page') ? File::allFiles(cms_path('resource').'views/themes/'.theme_name().'/page'):[];
         ?>
       @foreach($file_page as $page)

        <?php 

              $v = basename($page,'.blade.php');

              $name = $v;

              $name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
              preg_match( '|Template Name:(.*)$|mi', file_get_contents( $page ), $header );

              if( isset($header[1]) ){
                  $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
              }

           ?>
           <option @if($value['static-page'] === $v) selected @endif value="{!!$v!!}">{!!$name!!}</option>
       @endforeach
    </select>
  </label>
</div>


<div class="radio">
  <label>
    <input type="radio" name="{!!$name!!}[type]" @if( $value['type'] === 'custom' ) checked="checked" @endif class="type-reading" id="{!!$key!!}__type__custom" value="custom">
    Custom &nbsp; 
    
  </label>
  <br>
  <label style=" margin: 10px 0;">
    Post Type: 
    <select class="form-control change-readonly" id="{!!$key!!}__post-type" @if( $value['type'] !== 'custom' ) readonly="readonly" @endif  name="{!!$key!!}[post-type]" style="display: inline;width: auto;max-width: 100%;">
      @foreach($admin_object as $k => $a)
        @if( $a['public_view'] )
        <option @if( $value['post-type'] === $k ) selected @endif value="{!!$k!!}">{!!$a['title']!!}</option>
        @endif
      @endforeach
    </select>
  </label>
  <br>
   <label>
    Post Type: 
    <select class="form-control change-readonly" @if( $value['type'] !== 'custom' ) readonly="readonly" @endif name="{!!$key!!}[post-id]" id="{!!$key!!}__post-id" style="display: inline;width: auto;max-width: 100%;">

    </select>
  </label>
</div>



<?php 
  add_action('vn4_footer',function() use ($value, $key) {
    ?>
      <script>
         $(window).load(function(){

             vn4_ajax({
                url:'{!!route('admin.controller',['controller'=>'setting','method'=>'get-homepage'])!!}',
                data:{
                  'post-type':$('#{!!$key!!}__post-type').val()
                },
                callback:function(data){
                    $('#{!!$key!!}__post-id').empty();

                    var post_type = $('#{!!$key!!}__post-type').val();

                    for (var i = 0; i < data.items.length; i++) {
                        if( post_type == '{!!$value['post-type']!!}' && data.items[i].@id == '{!!$value['post-id']!!}' ){
                          $('#{!!$key!!}__post-id').append('<option selected value="'+data.items[i].@id+'">'+data.items[i].title+'</option>');
                        }else{
                          $('#{!!$key!!}__post-id').append('<option value="'+data.items[i].@id+'">'+data.items[i].title+'</option>');
                        }
                    }
                }
              });

             $(document).on('change','#{!!$key!!}__post-type',function(event) {
                  vn4_ajax({
                    url:'{!!route('admin.controller',['controller'=>'setting','method'=>'get-homepage'])!!}',
                    data:{
                      'post-type':$(this).val()
                    },
                    callback:function(data){
                        $('#{!!$key!!}__post-id').empty();
                        var post_type = $('#{!!$key!!}__post-type').val();
                        for (var i = 0; i < data.items.length; i++) {
                             if( post_type == '{!!$value['post-type']!!}' && data.items[i].@id == '{!!$value['post-id']!!}' ){
                            $('#{!!$key!!}__post-id').append('<option selected value="'+data.items[i].@id+'">'+data.items[i].title+'</option>');
                          }else{
                            $('#{!!$key!!}__post-id').append('<option value="'+data.items[i].@id+'">'+data.items[i].title+'</option>');
                          }
                        }
                    }
                  });
             });
            
            $(document).on('change','.change-readonly',function(event) {
                $(this).closest('.form-group').find('.type-reading[value=custom]').prop('checked',true);
                $(this).closest('.form-group').find('.change-readonly').removeAttr('readonly');
            });

             $(document).on('change','input:radio.type-reading',function() {
              if (this.value == 'custom' ) {
                  $(this).closest('.form-group').find('.change-readonly').removeAttr('readonly');
              }else{
                  $(this).closest('.form-group').find('.change-readonly').attr({'readonly':'readonly'});
              }
            });
         });
      </script>
    <?php 
  });
?>